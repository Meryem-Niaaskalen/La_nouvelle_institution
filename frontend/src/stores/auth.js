import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const token = ref(localStorage.getItem('auth_token'))
  const user = ref(null)

  const isAuthenticated = () => Boolean(token.value)

  function setSession(newToken, newUser) {
    token.value = newToken
    user.value = newUser
    if (newToken) {
      localStorage.setItem('auth_token', newToken)
    } else {
      localStorage.removeItem('auth_token')
    }
  }

  function clearSession() {
    setSession(null, null)
  }

  return { token, user, isAuthenticated, setSession, clearSession }
})
