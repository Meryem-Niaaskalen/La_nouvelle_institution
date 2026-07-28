<template>
  <nav class="navbar" :class="{ 'navbar-scrolled': isScrolled }">
    <div class="navbar-container">
      <div class="navbar-brand">
        <slot name="logo">
          <router-link to="/" class="brand-link">
            <span class="brand-icon">🏫</span>
            <span class="brand-name">La nouvelle institution</span>
          </router-link>
        </slot>
      </div>

      <button
        class="navbar-toggle md:hidden"
        :class="{ 'navbar-toggle-active': isOpen }"
        @click="isOpen = !isOpen"
      >
        <span></span>
        <span></span>
        <span></span>
      </button>

      <div class="navbar-menu" :class="{ 'navbar-menu-open': isOpen }">
        <div class="navbar-nav">
          <router-link
            v-for="link in navLinks"
            :key="link.path"
            :to="link.path"
            class="nav-link"
            :class="{ 'nav-link-active': isActive(link.path) }"
            @click="isOpen = false"
          >
            {{ link.label }}
          </router-link>
        </div>

        <div class="navbar-actions">
          <slot name="actions" />
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useRoute } from 'vue-router'

const props = defineProps({
  navLinks: {
    type: Array,
    default: () => [
      { path: '/', label: 'Accueil' },
      { path: '/a-propos', label: 'À Propos' },
      { path: '/programmes', label: 'Programmes' },
      { path: '/admissions', label: 'Admissions' },
      { path: '/galerie', label: 'Galerie' },
      { path: '/activites', label: 'Activités' },
      { path: '/contact', label: 'Contact' },
    ],
  },
})

const route = useRoute()
const isOpen = ref(false)
const isScrolled = ref(false)

const isActive = (path) => route.path === path

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
  @reference '../styles/tailwind.css';
.navbar {
  @apply fixed top-0 left-0 right-0 z-40 bg-white border-b border-gray-200 transition-smooth;
  @apply shadow-none;
}

.navbar-scrolled {
  @apply shadow-soft;
}

.navbar-container {
  @apply max-w-7xl mx-auto px-6 md:px-8 py-4 flex items-center justify-between;
}

.navbar-brand {
  @apply flex-shrink-0;
}

.brand-link {
  @apply flex items-center gap-3 text-gray-900 font-bold text-xl hover:text-primary-500 transition-colors;
  @apply no-underline;
}

.brand-icon {
  @apply text-2xl;
}

.brand-name {
  @apply hidden md:inline;
}

.navbar-toggle {
  @apply w-10 h-10 flex flex-col items-center justify-center gap-1.5 bg-transparent border-0 cursor-pointer focus-ring;
}

.navbar-toggle span {
  @apply w-6 h-0.5 bg-gray-900 transition-smooth;
}

.navbar-toggle-active span:nth-child(1) {
  @apply rotate-45 translate-y-2;
}

.navbar-toggle-active span:nth-child(2) {
  @apply opacity-0;
}

.navbar-toggle-active span:nth-child(3) {
  @apply -rotate-45 -translate-y-2;
}

.navbar-menu {
  @apply hidden md:flex items-center gap-8;
}

.navbar-menu-open {
  @apply flex flex-col absolute top-full left-0 right-0 bg-white border-b border-gray-200 px-6 py-6 gap-6;
}

.navbar-nav {
  @apply flex flex-col md:flex-row gap-4 md:gap-0;
}

.nav-link {
  @apply text-gray-600 font-medium hover:text-primary-500 transition-colors px-4 py-2 rounded-lg;
  @apply no-underline;
}

.nav-link-active {
  @apply text-primary-500 bg-primary-50;
}

.navbar-actions {
  @apply flex gap-4 mt-4 md:mt-0;
}

@media (max-width: 768px) {
  .navbar-menu-open {
    animation: slideDown 0.3s ease-out;
  }
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-1rem);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
