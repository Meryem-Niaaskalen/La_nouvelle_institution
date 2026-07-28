<template>
  <div class="stats-container">
    <div
      v-for="stat in stats"
      :key="stat.id"
      class="stat-card"
      :data-stat-id="stat.id"
    >
      <div class="stat-icon">{{ stat.icon }}</div>
      <div :ref="`counter-${stat.id}`" class="stat-value">0</div>
      <p class="stat-label">{{ stat.label }}</p>
      <p v-if="stat.suffix" class="stat-suffix">{{ stat.suffix }}</p>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useGSAP } from '../useGSAP'

const props = defineProps({
  stats: {
    type: Array,
    required: true,
    validator: (arr) => arr.every((s) => s.id && s.icon && s.value && s.label),
  },
})

const { counter, scrollTriggerFadeIn } = useGSAP()

onMounted(() => {
  const container = document.querySelector('.stats-container')
  if (container) {
    scrollTriggerFadeIn(container, 0.6)
  }

  props.stats.forEach((stat) => {
    const el = document.querySelector(`[data-stat-id="${stat.id}"]`)
    if (el) {
      const valueEl = el.querySelector('.stat-value')
      if (valueEl) {
        counter(valueEl, stat.value, 2)
      }
    }
  })
})
</script>

<style scoped>
  @reference '../styles/tailwind.css';
.stats-container {
  @apply grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8;
}

.stat-card {
  @apply text-center p-8 rounded-lg bg-gray-50 border border-gray-200 hover:shadow-medium transition-smooth;
}

.stat-icon {
  @apply text-4xl mb-4;
}

.stat-value {
  @apply text-4xl md:text-5xl font-bold text-primary-500 mb-2;
}

.stat-label {
  @apply text-gray-600 font-semibold mb-1;
}

.stat-suffix {
  @apply text-gray-500 text-sm;
}

@media (max-width: 768px) {
  .stat-card {
    @apply p-6;
  }

  .stat-value {
    @apply text-3xl;
  }
}
</style>
