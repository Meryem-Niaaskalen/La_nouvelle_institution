<template>
  <div class="gallery-container">
    <div v-if="$slots.header || categories" class="gallery-header">
      <slot name="header">
        <div v-if="categories" class="gallery-filters">
          <button
            v-for="cat in categories"
            :key="cat"
            :class="['filter-btn', { 'filter-btn-active': activeCategory === cat }]"
            @click="activeCategory = cat"
          >
            {{ cat }}
          </button>
        </div>
      </slot>
    </div>

    <div class="gallery-grid">
      <div
        v-for="(item, index) in filteredItems"
        :key="item.id"
        class="gallery-item"
        :style="{ '--index': index }"
      >
        <div class="gallery-image-wrapper">
          <img
            :src="item.image"
            :alt="item.title"
            class="gallery-image"
            @click="openLightbox(item)"
          />
          <div class="gallery-overlay">
            <button class="gallery-zoom-btn" @click="openLightbox(item)">
              🔍
            </button>
          </div>
        </div>
        <div v-if="item.title || item.date" class="gallery-info">
          <h3 v-if="item.title" class="gallery-title">{{ item.title }}</h3>
          <p v-if="item.date" class="gallery-date">{{ item.date }}</p>
        </div>
      </div>
    </div>

    <!-- Lightbox -->
    <Teleport to="body">
      <Transition name="lightbox">
        <div v-if="lightboxItem" class="lightbox" @click="closeLightbox">
          <div class="lightbox-content" @click.stop>
            <button class="lightbox-close" @click="closeLightbox">✕</button>
            <img :src="lightboxItem.image" :alt="lightboxItem.title" class="lightbox-image" />
            <h3 v-if="lightboxItem.title" class="lightbox-title">{{ lightboxItem.title }}</h3>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
  categories: Array,
  categoryField: {
    type: String,
    default: 'category',
  },
})

const activeCategory = ref(props.categories?.[0] || 'all')
const lightboxItem = ref(null)

const filteredItems = computed(() => {
  if (activeCategory.value === 'all' || !activeCategory.value) {
    return props.items
  }
  return props.items.filter((item) => item[props.categoryField] === activeCategory.value)
})

const openLightbox = (item) => {
  lightboxItem.value = item
  document.body.style.overflow = 'hidden'
}

const closeLightbox = () => {
  lightboxItem.value = null
  document.body.style.overflow = 'auto'
}
</script>

<style scoped>
  @reference '../styles/tailwind.css';
.gallery-container {
  @apply w-full;
}

.gallery-header {
  @apply mb-12 text-center;
}

.gallery-filters {
  @apply flex flex-wrap gap-4 justify-center;
}

.filter-btn {
  @apply px-4 py-2 rounded-full border-2 border-gray-300 text-gray-700 font-semibold transition-smooth hover:border-primary-500 hover:text-primary-500;
  @apply cursor-pointer focus-ring;
}

.filter-btn-active {
  @apply bg-primary-500 text-white border-primary-500;
}

.gallery-grid {
  @apply columns-1 md:columns-2 lg:columns-3 gap-6;
}

.gallery-item {
  @apply break-inside-avoid mb-6 animate-fade-in;
  animation: fadeIn 0.6s ease-out both;
  animation-delay: calc(var(--index) * 0.1s);
}

.gallery-image-wrapper {
  @apply relative overflow-hidden rounded-lg bg-gray-200 cursor-pointer;
}

.gallery-image-wrapper:hover .gallery-image {
  transform: scale(1.1);
}

.gallery-image-wrapper:hover .gallery-overlay {
  background-color: rgba(0, 0, 0, 0.4);
}

.gallery-image-wrapper:hover .gallery-zoom-btn {
  opacity: 1;
}

.gallery-image {
  @apply w-full h-auto block transition-smooth;
}

.gallery-overlay {
  @apply absolute inset-0 bg-black/0 flex items-center justify-center transition-smooth;
}

.gallery-zoom-btn {
  @apply w-12 h-12 bg-white text-gray-900 rounded-full font-bold opacity-0 transition-smooth focus-ring;
  @apply flex items-center justify-center;
}

.gallery-info {
  @apply mt-3;
}

.gallery-title {
  @apply text-lg font-semibold text-gray-900;
}

.gallery-date {
  @apply text-sm text-gray-500;
}

/* Lightbox */
.lightbox {
  @apply fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4;
}

.lightbox-content {
  @apply relative max-w-4xl w-full animate-scale-in;
}

.lightbox-image {
  @apply w-full h-auto rounded-lg max-h-[80vh] object-contain;
}

.lightbox-close {
  @apply absolute -top-12 right-0 w-10 h-10 bg-white text-black rounded-full font-bold hover:bg-gray-200 transition-colors focus-ring;
  @apply flex items-center justify-center;
}

.lightbox-title {
  @apply mt-4 text-white text-xl font-semibold;
}

.lightbox-enter-active,
.lightbox-leave-active {
  @apply transition-opacity duration-150;
}

.lightbox-enter-from,
.lightbox-leave-to {
  @apply opacity-0;
}

@media (max-width: 768px) {
  .gallery-grid {
    @apply columns-1;
  }

  .lightbox-close {
    @apply -top-10 right-2;
  }
}
</style>
