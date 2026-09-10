import axios from 'axios'

const getCookie = (name) => {
  if (typeof document === 'undefined') return null
  const value = `; ${document.cookie}`
  const parts = value.split(`; ${name}=`)
  if (parts.length === 2) {
    return decodeURIComponent(parts.pop().split(';').shift())
  }
  return null
}

const resolveApiBaseUrl = () => {
  if (typeof window !== 'undefined' && import.meta.env.DEV) {
    return '/api/v1'
  }

  if (import.meta.env.VITE_API_URL) {
    return import.meta.env.VITE_API_URL
  }

  return '/api/v1'
}

const resolveSanctumBaseUrl = () => {
  if (typeof window !== 'undefined' && import.meta.env.DEV) {
    return '/'
  }

  if (import.meta.env.VITE_API_URL) {
    return import.meta.env.VITE_API_URL.replace(/\/api(?:\/v1)?\/?$/i, '')
  }

  return '/'
}

const api = axios.create({
  baseURL: resolveApiBaseUrl(),
  headers: {
    Accept: 'application/json',
  },
  withCredentials: true,
})

api.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  const csrfToken = getCookie('XSRF-TOKEN')
  if (csrfToken) {
    config.headers['X-XSRF-TOKEN'] = csrfToken
  }
  config.headers['X-Requested-With'] = 'XMLHttpRequest'

  if (!(config.data instanceof FormData)) {
    config.headers['Content-Type'] = 'application/json'
  }

  return config
})

export const sanctumBaseUrl = resolveSanctumBaseUrl()
export default api
