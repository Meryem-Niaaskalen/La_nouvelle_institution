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
  @apply py-section px-6 md:px-8 transition-smooth;
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
  @apply bg-gray-900 text-white;
}

.section-no-padding {
  @apply py-0 px-0;
}

.section-container {
  @apply w-full;
}

.section-header {
  @apply text-center mb-16 md:mb-20;
}

.section-title {
  @apply text-4xl md:text-5xl font-semibold font-heading mb-4;
}

.section-subtitle {
  @apply text-lg md:text-xl text-gray-600 max-w-2xl mx-auto;
}

.section-dark .section-subtitle {
  @apply text-gray-300;
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
}
</style>
