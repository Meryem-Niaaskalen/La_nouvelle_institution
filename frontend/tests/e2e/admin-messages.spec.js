const { test, expect } = require('@playwright/test')
const base = process.env.VITE_APP_URL || 'http://localhost:5173'

test('admin login and view messages', async ({ page }) => {
  await page.goto(`${base}/admin/connexion`)

  await page.fill('input#email', 'admin@lanouvelleinstitution.ma')
  await page.fill('input#password', 'password')
  await page.click('button:has-text("Se connecter")')

  // wait for redirect to admin
  await page.waitForURL('**/admin**', { timeout: 5000 })

  // open messages route
  await page.goto(`${base}/admin/messages`)

  // expect at least one message listed
  await expect(page.locator('button:has-text("Nouveau")').first()).toBeVisible({ timeout: 5000 })
})
