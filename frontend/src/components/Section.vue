<template>
  <section
    :class="[
      'section',
      `section-${variant}`,
      { 'section-dark': dark },
      { 'section-no-padding': noPadding },
    ]"
  >
    <div class="section-container">
      <div v-if="title || $slots.header" class="section-header">
        <slot name="header">
          <h2 v-if="title" class="section-title">{{ title }}</h2>
          <p v-if="subtitle" class="section-subtitle">{{ subtitle }}</p>
        </slot>
      </div>

      <div class="section-content">
        <slot />
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  title: String,
  subtitle: String,
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'wide', 'contained'].includes(v),
  },
  dark: Boolean,
  noPadding: Boolean,
})
</script>

<style scoped>
  @reference '../styles/tailwind.css';
.section {
  @apply py-section px-4 sm:px-6 lg:px-8 transition-smooth;
}

.section-default {
  @apply max-w-7xl mx-auto;
}

.section-wide {
  @apply max-w-full;
}

.section-contained {
  @apply max-w-6xl mx-auto;
}

.section-dark {
  @apply bg-slate-950 text-white;
}

.section-no-padding {
  @apply py-0 px-0;
}

.section-container {
  @apply w-full;
}

.section-header {
  @apply text-center mb-16 md:mb-20 space-y-4;
}

.section-title {
    @apply mx-auto max-w-3xl text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-[-0.02em] text-slate-900 relative;
    --accent: theme('colors.orange.400');
    animation: sectionTitleIn .6s cubic-bezier(.2,.9,.3,1) both;
}

.section-title::after {
  content: '';
  display: block;
  width: 96px;
  height: 4px;
  margin: 14px auto 0;
  border-radius: 999px;
  background: linear-gradient(90deg, rgba(245,124,0,0.15), rgba(245,124,0,0.9), rgba(245,124,0,0.15));
}

.section-subtitle {
    @apply mx-auto max-w-2xl text-base sm:text-lg leading-8 text-slate-600;
    opacity: .95;
    transform-origin: center;
    animation: sectionSubtitleIn .6s cubic-bezier(.2,.9,.3,1) .08s both;
}

@keyframes sectionTitleIn {
  from { transform: translateY(18px) scale(.995); opacity: 0 }
  to   { transform: translateY(0) scale(1); opacity: 1 }
}

@keyframes sectionSubtitleIn {
  from { transform: translateY(8px); opacity: 0 }
  to   { transform: translateY(0); opacity: 1 }
}
.section-dark .section-title {
  @apply text-white;
}

.section-dark .section-subtitle {
  @apply text-slate-300;
}

.section-content {
  @apply w-full;
}

@media (max-width: 768px) {
  .section {
    @apply py-section-sm;
  }

  .section-header {
    @apply mb-12;
  }

  .section-title {
    @apply text-3xl;
  }
}
</style>
