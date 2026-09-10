<script setup>
import { ref } from 'vue'
import { RouterLink, RouterView, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'
import { Images, LayoutDashboard, LogOut, Mail, Newspaper, Phone } from 'lucide-vue-next'

const auth = useAuthStore()
const router = useRouter()
const route = useRoute()
const mobileNavOpen = ref(false)

function logout() {
  auth.clearSession()
  router.push({ name: 'admin-connexion' })
}

const navItems = [
  { name: 'admin-dashboard', label: 'Tableau de bord', icon: LayoutDashboard },
  { name: 'admin-messages', label: 'Messages', icon: Mail },
  { name: 'admin-galerie', label: 'Galerie', icon: Images },
  { name: 'admin-actualites', label: 'Actualités', icon: Newspaper },
  { name: 'admin-contacts', label: 'Contacts', icon: Phone },
]
</script>

<template>
  <div class="min-h-screen flex bg-slate-50 text-slate-700">
    <aside class="hidden w-80 shrink-0 flex-col border-r border-slate-200 bg-slate-950 text-slate-100 lg:flex">
      <div class="border-b border-white/10 px-6 py-7">
        <div class="flex items-center gap-3">
          <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-primary-500 text-xl text-white shadow-lg shadow-primary-500/30">L</div>
          <div>
            <p class="text-xs uppercase tracking-[0.35em] text-primary-200">Administration</p>
            <h2 class="mt-2 text-xl font-semibold text-white">La nouvelle institution</h2>
          </div>
        </div>
      </div>

      <nav class="flex-1 px-5 py-6 space-y-2" aria-label="Navigation admin">
        <RouterLink
          v-for="item in navItems"
          :key="item.name"
          :to="{ name: item.name }"
          class="flex items-center gap-4 rounded-3xl px-4 py-4 text-sm font-semibold transition"
          :class="route.name === item.name ? 'bg-primary-500/15 text-white ring-1 ring-primary-500/25' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
        >
          <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-base">
            <component :is="item.icon" :size="19" :stroke-width="1.8" aria-hidden="true" />
          </span>
          <span>{{ item.label }}</span>
        </RouterLink>
      </nav>

      <div class="border-t border-white/10 px-5 py-5">
        <button
          type="button"
          class="flex w-full items-center gap-3 rounded-3xl bg-slate-900/80 px-4 py-4 text-sm font-semibold text-slate-200 transition hover:bg-slate-800"
          @click="logout"
        >
          <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10">
            <LogOut :size="19" :stroke-width="1.8" aria-hidden="true" />
          </span>
          Déconnexion
        </button>
      </div>
    </aside>

    <div class="flex-1">
      <header class="border-b border-slate-200 bg-white/95 px-6 py-4 backdrop-blur-sm shadow-sm lg:px-8">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
          <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-primary-500 text-xl text-white">A</div>
            <div>
              <p class="text-sm font-semibold text-slate-900">Espace administrateur</p>
              <p class="text-sm text-slate-500">Gestion du contenu et des communications</p>
            </div>
          </div>

          <div class="flex flex-wrap items-center gap-3">
            <button
              type="button"
              class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-100 lg:hidden"
              @click="mobileNavOpen = !mobileNavOpen"
            >
              <span>{{ mobileNavOpen ? 'Fermer' : 'Menu' }}</span>
              <span class="text-slate-500">▾</span>
            </button>

            <nav class="hidden sm:flex gap-3">
              <RouterLink to="/" class="text-sm text-slate-600 transition hover:text-slate-900">Voir le site</RouterLink>
              <RouterLink :to="{ name: 'admin-dashboard' }" class="text-sm text-slate-600 transition hover:text-slate-900">Tableau de bord</RouterLink>
            </nav>
            <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700">Bonjour, Admin</div>
          </div>
        </div>

        <div v-if="mobileNavOpen" class="mt-4 lg:hidden">
          <div class="rounded-3xl border border-slate-200 bg-slate-950/95 p-4 shadow-lg shadow-slate-900/20">
            <nav class="space-y-2">
              <RouterLink
                v-for="item in navItems"
                :key="item.name"
                :to="{ name: item.name }"
                class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-semibold transition"
                :class="route.name === item.name ? 'bg-primary-500/20 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                @click="mobileNavOpen = false"
              >
                <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-white/10 text-base">
                  <component :is="item.icon" :size="18" :stroke-width="1.8" aria-hidden="true" />
                </span>
                <span>{{ item.label }}</span>
              </RouterLink>
            </nav>
          </div>
        </div>
      </header>

      <main class="p-6 md:p-8">
        <RouterView />
      </main>
    </div>
  </div>
</template>
