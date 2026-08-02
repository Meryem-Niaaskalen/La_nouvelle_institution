import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const routes = [
  {
    path: '/',
    component: () => import('@/layouts/PublicLayout.vue'),
    children: [
      {
        path: '',
        name: 'accueil',
        component: () => import('@/pages/public/AccueilPage.vue'),
        meta: { title: 'Accueil' },
      },
      {
        path: 'a-propos',
        name: 'a-propos',
        component: () => import('@/pages/public/AProposPage.vue'),
        meta: { title: 'À propos' },
      },
      {
        path: 'programmes',
        name: 'programmes',
        component: () => import('@/pages/public/ProgrammesPage.vue'),
        meta: { title: 'Programmes' },
      },
      {
        path: 'admissions',
        name: 'admissions',
        component: () => import('@/pages/public/AdmissionsPage.vue'),
        meta: { title: 'Admissions' },
      },
      {
        path: 'galerie',
        name: 'galerie',
        component: () => import('@/pages/public/GaleriePage.vue'),
        meta: { title: 'Galerie' },
      },
      {
        path: 'contact',
        name: 'contact',
        component: () => import('@/pages/public/ContactPage.vue'),
        meta: { title: 'Contact' },
      },
    ],
  },
  {
    path: '/admin/connexion',
    name: 'admin-connexion',
    component: () => import('@/pages/admin/ConnexionPage.vue'),
    meta: { title: 'Connexion admin', guest: true },
  },
  {
    path: '/admin',
    component: () => import('@/layouts/AdminLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        name: 'admin-dashboard',
        component: () => import('@/pages/admin/DashboardPage.vue'),
        meta: { title: 'Tableau de bord', requiresAuth: true },
      },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  },
})

router.beforeEach((to) => {
  const auth = useAuthStore()
  const title = to.meta.title ? `${to.meta.title} — La nouvelle institution` : 'La nouvelle institution'
  document.title = title

  if (to.meta.requiresAuth && !auth.isAuthenticated()) {
    return { name: 'admin-connexion', query: { redirect: to.fullPath } }
  }

  if (to.meta.guest && auth.isAuthenticated()) {
    return { name: 'admin-dashboard' }
  }

  return true
})

export default router
