import fs from 'node:fs/promises'
import path from 'node:path'
import { spawn } from 'node:child_process'
import { chromium } from 'playwright'

const FRONTEND_DIR = path.resolve(new URL('../', import.meta.url).pathname)
const SCREENSHOT_DIR = path.join(FRONTEND_DIR, 'responsive-screenshots')
const PREVIEW_PORT = 4173
const BASE_URL = `http://127.0.0.1:${PREVIEW_PORT}`
const PREVIEW_CMD = 'npx'
const PREVIEW_ARGS = ['vite', 'preview', '--host', '127.0.0.1', '--port', `${PREVIEW_PORT}`, '--strictPort']

const pages = [
  { name: 'home', url: '/' },
  { name: 'a-propos', url: '/a-propos' },
  { name: 'programmes', url: '/programmes' },
  { name: 'admissions', url: '/admissions' },
  { name: 'galerie', url: '/galerie' },
  { name: 'contact', url: '/contact' },
]

const viewports = [
  { name: 'small', width: 375, height: 812 },
  { name: 'medium', width: 540, height: 960 },
  { name: 'tablet', width: 768, height: 1024 },
]

async function runPreviewServer() {
  const previewProc = spawn(PREVIEW_CMD, PREVIEW_ARGS, {
    cwd: FRONTEND_DIR,
    stdio: ['ignore', 'pipe', 'pipe'],
    shell: true,
  })

  previewProc.stdout.on('data', (chunk) => {
    process.stdout.write(`[preview] ${chunk}`)
  })
  previewProc.stderr.on('data', (chunk) => {
    process.stderr.write(`[preview] ${chunk}`)
  })

  previewProc.on('exit', (code) => {
    if (code !== 0) {
      console.error(`Preview server exited with code ${code}`)
    }
  })

  const started = await waitForServerReady(previewProc)
  if (!started) {
    previewProc.kill('SIGINT')
    throw new Error('Preview server did not start in time')
  }

  return previewProc
}

async function waitForServerReady(previewProc) {
  const maxAttempts = 40
  for (let attempt = 1; attempt <= maxAttempts; attempt += 1) {
    if (previewProc.killed) {
      return false
    }

    try {
      const response = await fetch(BASE_URL)
      if (response.ok) {
        return true
      }
    } catch {
      // ignore until server is ready
    }

    await new Promise((resolve) => setTimeout(resolve, 500))
  }

  return false
}

async function evaluateViewport(page) {
  const issues = await page.evaluate(() => {
    const body = document.body
    const html = document.documentElement
    const viewportWidth = window.innerWidth
    const scrollWidth = Math.max(body.scrollWidth, html.scrollWidth)
    const overflowElements = []
    const all = Array.from(document.querySelectorAll('body *'))
    all.forEach((el) => {
      const rect = el.getBoundingClientRect()
      if (rect.right > viewportWidth + 1 && rect.left < viewportWidth + 1) {
        const style = window.getComputedStyle(el)
        if (style.display !== 'none' && style.visibility !== 'hidden') {
          overflowElements.push({
            tag: el.tagName.toLowerCase(),
            class: el.className ? String(el.className).slice(0, 80) : '',
            right: Math.round(rect.right),
            width: Math.round(rect.width),
          })
        }
      }
    })
    return {
      scrollWidth,
      viewportWidth,
      overflowCount: overflowElements.length,
      overflowExamples: overflowElements.slice(0, 12),
    }
  })

  return issues
}

async function runChecks() {
  await fs.mkdir(SCREENSHOT_DIR, { recursive: true })
  const browser = await chromium.launch({ headless: true })
  const context = await browser.newContext({ locale: 'fr-FR' })

  try {
    for (const pageDef of pages) {
      const pageUrl = `${BASE_URL}${pageDef.url}`
      for (const viewport of viewports) {
        const page = await context.newPage()
        await page.setViewportSize({ width: viewport.width, height: viewport.height })
        await page.goto(pageUrl, { waitUntil: 'networkidle' })
        await page.waitForTimeout(400)

        const results = await evaluateViewport(page)
        const screenshotPath = path.join(SCREENSHOT_DIR, `${pageDef.name}-${viewport.name}-${viewport.width}x${viewport.height}.png`)
        await page.screenshot({ path: screenshotPath, fullPage: true })

        console.log(`✔ ${pageDef.name} @ ${viewport.width}x${viewport.height}: scrollWidth=${results.scrollWidth}, viewportWidth=${results.viewportWidth}, overflowCount=${results.overflowCount}`)
        if (results.overflowCount > 0) {
          console.warn(`  ⚠ Overflow examples:`, results.overflowExamples)
        }

        await page.close()
      }
    }
  } finally {
    await browser.close()
  }
}

async function main() {
  console.log('Starting responsive QA run...')
  console.log(`Preview URL: ${BASE_URL}`)
  const previewProc = await runPreviewServer()

  try {
    await runChecks()
  } catch (error) {
    console.error(error)
    process.exitCode = 1
  } finally {
    previewProc.kill('SIGINT')
    console.log('Responsive QA run complete.')
    console.log(`Screenshots saved to ${SCREENSHOT_DIR}`)
  }
}

main().catch((error) => {
  console.error(error)
  process.exit(1)
})
