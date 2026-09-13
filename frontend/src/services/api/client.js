import axios from 'axios'

const resolveApiBaseUrl = () => {
  if (typeof window !== 'undefined' && import.meta.env.DEV) {
    return '/api/v1'
  }

  if (import.meta.env.VITE_API_URL) {
    return import.meta.env.VITE_API_URL
  }

  return '/api/v1'
}

const api = axios.create({
  baseURL: resolveApiBaseUrl(),
  headers: {
    Accept: 'application/json',
  },
  withCredentials: false,
})

api.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  config.headers['X-Requested-With'] = 'XMLHttpRequest'

  if (!(config.data instanceof FormData)) {
    config.headers['Content-Type'] = 'application/json'
  }

  return config
})

export default api
