<template>
  <div class="carousel">
    <div class="carousel-track">
      <div
        v-for="(item, index) in items"
        :key="index"
        :class="[
          'carousel-item',
          { 'carousel-item-active': index === currentIndex },
        ]"
      >
        <slot :item="item">
          <div class="p-8">
            <p class="text-lg font-semibold">{{ item.title }}</p>
            <p class="text-gray-600 mt-2">{{ item.description }}</p>
          </div>
        </slot>
      </div>
    </div>

    <!-- Navigation -->
    <div class="carousel-controls">
      <button
        class="carousel-btn"
        @click="previous"
        aria-label="Previous slide"
      >
        ❮
      </button>
      <button
        class="carousel-btn"
        @click="next"
        aria-label="Next slide"
      >
        ❯
      </button>
    </div>

    <!-- Indicators -->
    <div class="carousel-indicators">
      <button
        v-for="(_, index) in items"
        :key="index"
        :class="[
          'carousel-indicator',
          { 'carousel-indicator-active': index === currentIndex },
        ]"
        @click="currentIndex = index"
        :aria-label="`Go to slide ${index + 1}`"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
  autoplay: {
    type: Boolean,
    default: true,
  },
  interval: {
    type: Number,
    default: 5000,
  },
})

const currentIndex = ref(0)
let autoplayInterval = null

const next = () => {
  currentIndex.value = (currentIndex.value + 1) % props.items.length
}

const previous = () => {
  currentIndex.value = (currentIndex.value - 1 + props.items.length) % props.items.length
}

onMounted(() => {
  if (props.autoplay) {
    autoplayInterval = setInterval(next, props.interval)
  }
})

onUnmounted(() => {
  if (autoplayInterval) {
    clearInterval(autoplayInterval)
  }
})
</script>

<style scoped>
  @reference '../styles/tailwind.css';
.carousel {
  @apply relative w-full overflow-hidden rounded-lg;
}

.carousel-track {
  @apply relative w-full h-64 md:h-80;
}

.carousel-item {
  @apply absolute inset-0 bg-white opacity-0 transition-opacity duration-500 ease-out;
}

.carousel-item-active {
  @apply opacity-100;
}

.carousel-controls {
  @apply absolute inset-y-0 left-0 right-0 flex items-center justify-between px-4 z-10;
}

.carousel-btn {
  @apply w-10 h-10 rounded-full bg-black/50 text-white hover:bg-black/70 transition-colors flex items-center justify-center focus-ring;
}

.carousel-indicators {
  @apply absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10;
}

.carousel-indicator {
  @apply w-2 h-2 rounded-full bg-white/50 hover:bg-white/75 transition-colors cursor-pointer focus-ring;
}

.carousel-indicator-active {
  @apply bg-white;
}
</style>
