<template>
  <nav class="navbar" :class="{ 'navbar-scrolled': isScrolled }">
    <div class="navbar-container">
      <div class="navbar-brand">
        <slot name="logo">
          <router-link to="/" class="brand-link">
            <img
              src="/images/logo-school-3.png"
              alt="Logo La nouvelle institution"
              class="brand-logo"
            />
            <span class="brand-text">
              <span class="brand-name">La nouvelle institution</span>
              <span class="brand-tagline">ÉCOLE DE RÉFÉRENCE DEPUIS 1997</span>
            </span>
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
          <router-link to="/contact" class="navbar-cta">
            <span class="navbar-cta-icon"></span>
            <span>Nous contacter</span>
          </router-link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
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
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 40;
  background: rgba(255, 255, 255, 0.94);
  backdrop-filter: blur(18px);
  border-bottom: 1px solid rgba(15, 23, 42, 0.06);
  transition: box-shadow 0.3s ease, background-color 0.3s ease;
}

.navbar-scrolled {
  box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
}

.navbar-container {
  max-width: 1520px;
  margin: 0 auto;
  padding: 16px 40px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-height: 96px;
}

.navbar-brand {
  flex-shrink: 0;
}

.brand-link {
  display: flex;
  align-items: center;
  gap: 14px;
  text-decoration: none;
}

.brand-logo {
  width: 56px;
  height: 56px;
  border-radius: 999px;
  object-fit: contain;
  border: 1px solid rgba(15, 23, 42, 0.08);
  background: #fff;
  box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
}

.brand-text {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.brand-name {
  font-size: 0.98rem;
  color: #18212f;
  font-weight: 700;
}

.brand-tagline {
  font-size: 0.68rem;
  color: #6b7280;
  text-transform: uppercase;
  font-weight: 700;
}

.navbar-toggle {
  display: none;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  width: 42px;
  height: 42px;
  padding: 0;
  border: 0;
  background: transparent;
  cursor: pointer;
}

.navbar-toggle span {
  display: block;
  width: 24px;
  height: 2px;
  margin: 4px auto;
  background: #18212f;
  transition: transform 0.25s ease, opacity 0.25s ease;
}

.navbar-toggle-active span:nth-child(1) {
  transform: rotate(45deg) translate(4px, 4px);
}

.navbar-toggle-active span:nth-child(2) {
  opacity: 0;
}

.navbar-toggle-active span:nth-child(3) {
  transform: rotate(-45deg) translate(4px, -4px);
}

.navbar-menu {
  display: flex;
  align-items: center;
  gap: 26px;
}

.navbar-nav {
  display: flex;
  align-items: center;
  gap: 8px;
}

.nav-link {
  position: relative;
  display: inline-flex;
  align-items: center;
  padding: 12px 10px;
  color: #18212f;
  text-decoration: none;
  font-weight: 700;
  font-size: 0.94rem;
  transition: color 0.25s ease;
}

.nav-link::after {
  content: '';
  position: absolute;
  left: 10px;
  right: 10px;
  bottom: 6px;
  height: 3px;
  background: #f57c00;
  border-radius: 999px;
  transform: scaleX(0);
  transform-origin: center;
  transition: transform 0.25s ease;
}

.nav-link:hover,
.nav-link-active {
  color: #f57c00;
}

.nav-link:hover::after,
.nav-link-active::after {
  transform: scaleX(1);
}

.navbar-actions {
  display: flex;
  align-items: center;
}

.navbar-cta {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 0.85rem 1.2rem;
  border-radius: 999px;
  background: #f57c00;
  color: #fff;
  font-weight: 700;
  text-decoration: none;
  box-shadow: 0 12px 24px rgba(245, 124, 0, 0.22);
}

.navbar-cta-icon {
  font-size: 1rem;
}

@media (max-width: 1024px) {
  .navbar-container {
    padding-inline: 20px;
    flex-wrap: wrap;
    gap: 12px;
  }

  .navbar-toggle {
    display: flex;
  }

  .navbar-menu {
    display: none;
    width: 100%;
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
    padding: 16px 4px 4px;
  }

  .navbar-menu-open {
    display: flex;
  }

  .navbar-nav {
    flex-direction: column;
    align-items: flex-start;
    gap: 4px;
    width: 100%;
  }

  .nav-link {
    width: 100%;
    padding: 10px 6px;
  }

  .navbar-actions {
    justify-content: flex-start;
    width: 100%;
  }
}

@media (max-width: 768px) {
  .brand-tagline {
    display: none;
  }

  .brand-name {
    font-size: 0.95rem;
  }

  .brand-logo {
    width: 50px;
    height: 50px;
  }
}
</style>

