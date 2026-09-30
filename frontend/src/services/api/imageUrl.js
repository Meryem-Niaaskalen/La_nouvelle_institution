const apiOrigin = (() => {
  const configuredApiUrl = import.meta.env.VITE_API_URL

  if (configuredApiUrl) {
    try {
      return new URL(configuredApiUrl, window.location.origin).origin
    } catch {
      return ''
    }
  }

  return import.meta.env.DEV ? 'http://127.0.0.1:8000' : ''
})()

const isLocalHost = (hostname) =>
  hostname === 'localhost' || hostname === '127.0.0.1' || hostname === '::1'

export const resolveImageUrl = (value, fallback = '') => {
  const raw = String(value || '').trim()
  if (!raw) return fallback
  if (/^(data:|blob:)/i.test(raw)) return raw

  try {
    const url = new URL(raw)

    if (apiOrigin && (isLocalHost(url.hostname) || /^\/(storage|images)\//.test(url.pathname))) {
      url.host = new URL(apiOrigin).host
      url.protocol = new URL(apiOrigin).protocol
    } else if (url.protocol === 'http:' && window.location.protocol === 'https:') {
      url.protocol = 'https:'
    }

    return url.href
  } catch {
    if (raw.startsWith('/images/') || raw.startsWith('/assets/')) return raw

    const imagePath = raw.startsWith('/')
      ? raw
      : `/storage/${raw.replace(/^\/+/, '')}`

    return apiOrigin ? new URL(imagePath, apiOrigin).href : imagePath
  }
}