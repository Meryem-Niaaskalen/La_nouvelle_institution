<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()

function logout() {
  auth.clearSession()
  router.push({ name: 'admin-connexion' })
}
</script>

<template>
  <div class="min-h-screen flex bg-surface text-text">
    <aside class="w-64 shrink-0 bg-secondary text-white">
      <div class="px-5 py-6 font-semibold">Administration</div>
      <nav class="flex flex-col gap-1 px-3 text-sm" aria-label="Navigation admin">
        <RouterLink class="rounded px-3 py-2 hover:bg-white/10" to="/admin">Tableau de bord</RouterLink>
      </nav>
      <button
        type="button"
        class="mx-3 mt-8 rounded px-3 py-2 text-left text-sm text-white/80 hover:bg-white/10"
        @click="logout"
      >
        Déconnexion
      </button>
    </aside>
    <div class="flex-1">
      <header class="border-b border-black/5 bg-white px-6 py-4 text-sm text-secondary">
        Espace administrateur
      </header>
      <main class="p-6">
        <RouterView />
      </main>
    </div>
  </div>
</template>
