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

    <div :class="['gallery-grid', { 'gallery-grid--animated': isAllCategory }]">
      <div
        v-for="(item, index) in filteredItems"
        :key="item.id"
        class="gallery-item"
        :style="{ '--index': index }"
      >
        <div class="gallery-image-wrapper" @click="openLightbox(item)">
          <img
            :src="getImageUrl(item)"
            :alt="item[props.categoryField] || 'Photo'"
            class="gallery-image"
          />
          <div class="gallery-overlay">
            <div>
              <p class="gallery-overlay-label">Voir en grand</p>
              <span class="gallery-overlay-icon"></span>
            </div>
          </div>
        </div>
        <div class="gallery-item-meta">
          <div class="gallery-item-labels">
            <span class="gallery-item-category">{{ item[props.categoryField] || 'Photo' }}</span>
            <span v-if="item.date" class="gallery-item-date">{{ item.date }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Lightbox -->
    <Teleport to="body">
      <Transition name="lightbox">
        <div v-if="lightboxItem" class="lightbox" @click="closeLightbox">
          <div class="lightbox-content" @click.stop>
            <button class="lightbox-close" @click="closeLightbox">✕</button>
            <img :src="getImageUrl(lightboxItem)" :alt="lightboxItem.title" class="lightbox-image" />
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

const activeCategory = ref(
  props.categories?.find((category) => ['all', 'tous', 'tout'].includes(String(category).toLowerCase())) || props.categories?.[0] || 'all'
)
const lightboxItem = ref(null)

const isAllCategory = computed(() => ['all', 'tous', 'tout'].includes(String(activeCategory.value).toLowerCase()))

const getImageUrl = (item) => {
  return item?.image || item?.image_url || item?.url || item?.path || item?.src || '/images/school-front.jpg'
}

const filteredItems = computed(() => {
  const normalized = String(activeCategory.value).toLowerCase().trim()
  if (normalized === 'tous' || normalized === 'all' || normalized === '') {
    return props.items
  }
  return props.items.filter((item) => String(item[props.categoryField] ?? '').toLowerCase() === normalized)
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
  @apply flex flex-wrap gap-3 justify-center;
}

.filter-btn {
  @apply px-5 py-2 rounded-full border border-slate-200 bg-white text-slate-700 font-semibold transition-smooth hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900;
  @apply cursor-pointer focus-ring;
}

.filter-btn-active {
  @apply bg-gradient-to-r from-primary-600 via-sky-600 to-emerald-500 text-white border-transparent shadow-lg;
}

.gallery-grid {
  @apply grid gap-5;
  grid-template-columns: repeat(3, minmax(0, 1fr));
}

.gallery-grid--animated .gallery-item {
  animation: galleryCardEntry 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
  animation-delay: calc(var(--index) * 0.08s);
}

.gallery-item {
  animation: fadeIn 0.6s ease-out both;
}

.gallery-image-wrapper {
  @apply relative overflow-hidden rounded-[28px] bg-slate-100 shadow-soft ring-1 ring-slate-200 aspect-[4/3];
  transition: transform 0.35s ease, box-shadow 0.35s ease;
}

.gallery-image-wrapper::after {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: inherit;
  box-shadow: inset 0 0 0 1px rgba(255,255,255,0.18);
  pointer-events: none;
}

.gallery-image-wrapper:hover {
  transform: translateY(-3px);
  box-shadow: 0 26px 50px rgba(15, 23, 42, 0.14);
}

.gallery-image-wrapper:hover .gallery-image {
  transform: scale(1.03);
}

.gallery-image-wrapper:hover .gallery-overlay {
  background: rgba(15, 23, 42, 0.32);
}

.gallery-image {
  @apply block w-full h-full object-cover transition-smooth;
}

.gallery-overlay {
  @apply absolute inset-0 flex items-center justify-center opacity-0 transition-all duration-300;
}

.gallery-image-wrapper:hover .gallery-overlay {
  @apply opacity-100;
}

.gallery-overlay-label {
  @apply text-sm uppercase tracking-[0.22em] text-white/80;
}

.gallery-overlay-icon {
  @apply mt-2 text-2xl text-white;
}

.gallery-item-meta {
  @apply p-5 border-t border-slate-200 bg-white;
}

.gallery-item-labels {
  @apply mb-3 flex flex-wrap gap-3 text-xs uppercase tracking-[0.24em] text-slate-500;
}

.gallery-item-category {
  @apply rounded-full border border-primary-200 bg-primary-50 px-3 py-1 text-primary-700;
}

.gallery-item-date {
  @apply text-slate-500;
}

.gallery-item-meta h4 {
  @apply text-lg font-semibold text-slate-900;
}

.lightbox {
  @apply fixed inset-0 bg-slate-950/90 flex items-center justify-center z-50 p-4;
}

.lightbox-content {
  @apply relative max-w-5xl w-full rounded-[32px] bg-white p-6 shadow-large;
}

.lightbox-image {
  @apply w-full h-auto rounded-[24px] object-cover;
}

.lightbox-close {
  @apply absolute -top-12 right-0 w-10 h-10 bg-white text-slate-900 rounded-full font-bold hover:bg-slate-100 transition-colors focus-ring;
  @apply flex items-center justify-center;
}

.gallery-lightbox-meta {
  @apply mt-5;
}

.gallery-lightbox-meta p {
  @apply text-sm uppercase tracking-[0.24em] text-slate-500 mb-2;
}

@keyframes galleryCardEntry {
  from {
    opacity: 0;
    transform: translateY(18px) scale(0.97);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}
@keyframes galleryCardEntry {
  from {
    opacity: 0;
    transform: translateY(18px) scale(0.97);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
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

@media (max-width: 1023px) {
  .gallery-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (max-width: 767px) {
  .gallery-grid {
    grid-template-columns: 1fr;
  }

  .lightbox-close {
    @apply -top-10 right-2;
  }
}
</style>

