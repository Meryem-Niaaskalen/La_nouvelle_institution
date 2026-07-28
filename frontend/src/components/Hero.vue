<template>
  <section class="hero" :style="{ backgroundImage: `url(${backgroundImage})` }">
    <div class="hero-overlay"></div>

    <div class="hero-content">
      <div v-if="$slots.logo || logo" class="hero-logo">
        <slot name="logo">
          <img :src="logo" :alt="title" class="w-20 h-20" />
        </slot>
      </div>

      <h1 v-if="title" class="hero-title">{{ title }}</h1>
      <p v-if="subtitle" class="hero-subtitle">{{ subtitle }}</p>

      <p v-if="description" class="hero-description">{{ description }}</p>

      <div v-if="$slots.actions" class="hero-actions">
        <slot name="actions" />
      </div>

      <div v-if="showScrollIndicator" class="hero-scroll-indicator">
        <div class="scroll-dot"></div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted } from 'vue'
import { useGSAP } from '../useGSAP'

defineProps({
  title: String,
  subtitle: String,
  description: String,
  logo: String,
  backgroundImage: {
    type: String,
    default: 'https://via.placeholder.com/1920x600',
  },
  showScrollIndicator: {
    type: Boolean,
    default: true,
  },
  parallaxSpeed: {
    type: Number,
    default: 0.5,
  },
})

const { slideUp, parallax } = useGSAP()

onMounted(() => {
  const hero = document.querySelector('.hero')
  if (hero) {
    slideUp(hero, 0.8)
    parallax(hero, 0.3)
  }
})
</script>

<style scoped>
  @reference '../styles/tailwind.css';
.hero {
  @apply relative w-full h-screen flex items-center justify-center bg-cover bg-center overflow-hidden;
}

.hero-overlay {
  @apply absolute inset-0 bg-black/40;
}

.hero-content {
  @apply relative z-10 text-center text-white px-6 md:px-12 max-w-4xl;
}

.hero-logo {
  @apply mb-6 animate-slide-up;
}

.hero-title {
  @apply text-5xl md:text-7xl font-bold mb-4 leading-tight;
}

.hero-subtitle {
  @apply text-xl md:text-2xl font-semibold text-white/90 mb-6;
}

.hero-description {
  @apply text-lg md:text-xl text-white/80 mb-8 max-w-2xl mx-auto;
}

.hero-actions {
  @apply flex flex-col md:flex-row gap-4 justify-center items-center;
}

.hero-scroll-indicator {
  @apply absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce;
}

.scroll-dot {
  @apply w-2 h-2 bg-white rounded-full animate-pulse-slow;
}

@media (max-width: 768px) {
  .hero-title {
    @apply text-3xl md:text-4xl;
  }

  .hero-subtitle {
    @apply text-lg;
  }

  .hero-description {
    @apply text-base;
  }
}
</style>
