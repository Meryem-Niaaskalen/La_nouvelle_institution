<template>
  <div class="timeline">
    <div
      v-for="(item, index) in timelineItems"
      :key="item.id"
      class="timeline-item"
      :class="{ 'timeline-item-last': index === timelineItems.length - 1 }"
    >
      <div class="timeline-marker">
        <div class="timeline-icon">{{ item.icon }}</div>
        <div class="timeline-year">{{ item.year }}</div>
      </div>

      <div class="timeline-content">
        <h3 class="timeline-title">{{ item.title }}</h3>
        <p class="timeline-description">{{ item.description }}</p>
        <div v-if="item.items" class="timeline-details">
          <div v-for="detail in item.items" :key="detail" class="timeline-detail">
            {{ detail }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useGSAP } from '../useGSAP'

defineProps({
  timelineItems: {
    type: Array,
    required: true,
    validator: (arr) =>
      arr.every((item) => item.id && item.year && item.title && item.description),
  },
})

const { stagger } = useGSAP()

onMounted(() => {
  const items = document.querySelectorAll('.timeline-item')
  if (items.length > 0) {
    stagger(items, 0.6, 0.15)
  }
})
</script>

<style scoped>
  @reference '../styles/tailwind.css';
.timeline {
  @apply relative py-12;
}

.timeline::before {
  @apply absolute left-1/2 -translate-x-1/2 top-0 bottom-0 w-1 bg-gradient-to-b from-primary-500 to-primary-200;
  content: '';
}

.timeline-item {
  @apply mb-16 grid grid-cols-1 md:grid-cols-2 gap-8 relative;
}

.timeline-item:nth-child(even) .timeline-content {
  @apply md:order-first;
}

.timeline-marker {
  @apply flex flex-col items-center md:flex-col justify-center;
}

.timeline-icon {
  @apply w-16 h-16 bg-white border-4 border-primary-500 rounded-full flex items-center justify-center text-2xl relative z-10 shadow-medium;
}

.timeline-year {
  @apply text-primary-500 font-bold text-lg mt-4 md:mt-2;
}

.timeline-content {
  @apply bg-gray-50 p-8 rounded-lg border border-gray-200 hover:shadow-medium transition-smooth;
}

.timeline-title {
  @apply text-xl font-semibold text-gray-900 mb-3;
}

.timeline-description {
  @apply text-gray-600 leading-relaxed mb-4;
}

.timeline-details {
  @apply space-y-2 pt-4 border-t border-gray-300;
}

.timeline-detail {
  @apply text-gray-700 flex items-start gap-2;
}

.timeline-detail::before {
  @apply content-['✓'] text-primary-500 font-bold mr-2 mt-0.5;
  content: '✓';
}

.timeline-item-last .timeline-marker::before {
  display: none;
}

@media (max-width: 768px) {
  .timeline::before {
    @apply left-4;
  }

  .timeline-item {
    @apply grid-cols-1 md:grid-cols-1 gap-0 pl-20;
  }

  .timeline-marker {
    @apply absolute left-0 top-0;
  }

  .timeline-icon {
    @apply w-12 h-12 text-lg;
  }

  .timeline-year {
    @apply text-sm mt-2;
  }

  .timeline-content {
    @apply p-6;
  }
}
</style>
