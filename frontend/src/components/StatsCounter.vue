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
    validator: (arr) => arr.every((s) => s.id != null && s.icon != null && s.value != null && s.label != null),
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
  @apply rounded-3xl border border-slate-200 bg-white p-7 text-center shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl;
}

.stat-icon {
  @apply mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-3xl bg-slate-100 text-2xl;
}

.stat-value {
  @apply text-4xl font-semibold text-slate-900;
}

.stat-label {
  @apply text-primary-700 font-semibold mb-1;
}

.stat-suffix {
  @apply text-primary-500 text-sm;
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
