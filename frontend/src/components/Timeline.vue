<template>
  <div class="timeline">
    <div
      v-for="(item, index) in timelineItems"
      :key="item.id"
      class="timeline-item"
      :class="{ 'timeline-item-last': index === timelineItems.length - 1 }"
    >
      <div class="timeline-marker">
        <div class="timeline-icon">
          <div class="timeline-icon-inner" v-html="getIconSvg(item.icon)"></div>
          <div class="timeline-year">{{ item.year }}</div>
        </div>
      </div>

      <div class="timeline-content">
        <div class="timeline-chip">{{ item.period || 'Étape clé' }}</div>
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

// Map simple keys or emojis to elegant inline SVGs. If the incoming item.icon is already a key like 'school' or an emoji, map it.
const iconMap = {
  school: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L3 7v6c0 5 3.58 9 9 11 5.42-2 9-6 9-11V7l-9-5z" stroke="#F57C00" stroke-width="1.2" fill="url(#g)"/><defs><linearGradient id="g" x1="0" x2="1"><stop offset="0" stop-color="#fff" stop-opacity="0.9"/><stop offset="1" stop-color="#fff" stop-opacity="0.5"/></linearGradient></defs></svg>`,
  book: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 6.5A2.5 2.5 0 0 1 5.5 4H20" stroke="#F57C00" stroke-width="1.2"/><path d="M21 7v11a2 2 0 0 1-2 2H6.5A2.5 2.5 0 0 1 4 17.5V6" stroke="#424242" stroke-width="1" fill="#fff"/></svg>`,
  star: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.8l2.4 4.87 5.37.78-3.88 3.78.92 5.36L12 16.9 6.19 18.6l.92-5.36L3.23 9.46l5.37-.78L12 2.8z" fill="#F57C00"/></svg>`,
  building: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="18" height="16" rx="2" stroke="#F57C00" stroke-width="1.2" fill="#fff"/><path d="M8 8h.01M8 12h.01M8 16h.01M12 8h.01M12 12h.01M12 16h.01M16 8h.01M16 12h.01M16 16h.01" stroke="#424242" stroke-width="0.8" stroke-linecap="round"/></svg>`,
  graduation: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2l9 5-9 5-9-5 9-5z" stroke="#F57C00" stroke-width="1.2" fill="#fff"/><path d="M3 10v4c0 5 3.58 9 9 11 5.42-2 9-6 9-11v-4" stroke="#424242" stroke-width="1"/></svg>`,
}

function getIconSvg(key) {
  if (!key) return iconMap.school

  if (iconMap[key]) return iconMap[key]

  const emojiMap = {
    '': 'school',
    '': 'graduation',
    '': 'book',
    '⭐': 'star',
    '️': 'building',
    '️': 'school',
    '': 'star',
    '': 'star',
    '': 'school',
  }

  if (emojiMap[key]) return iconMap[emojiMap[key]]

  const emojiRegex = /[\p{Extended_Pictographic}]/u
  if (emojiRegex.test(String(key))) {
    const escaped = String(key)
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')

    return `<svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="22" fill="#fff" stroke="#F57C00" stroke-width="2"/><text x="24" y="29" text-anchor="middle" font-size="20" fill="#424242" font-family="Inter, sans-serif">${escaped}</text></svg>`
  }

  return iconMap.school
}

onMounted(() => {
  const items = document.querySelectorAll('.timeline-item')
  if (items.length > 0) {
    stagger(items, 0.9, 0.14)
  }
})
</script>

<style scoped>
  @reference '../styles/tailwind.css';

.timeline {
  @apply relative py-8 md:py-12;
}

.timeline::before {
  @apply absolute left-1/2 -translate-x-1/2 top-0 bottom-0 w-1.5 bg-gradient-to-b from-primary-500 via-primary-400 to-gray-200;
  content: '';
  box-shadow: 0 0 18px rgba(245, 124, 0, 0.18);
}

.timeline-item {
  @apply relative mb-10 md:mb-16 grid grid-cols-[1fr_56px_1fr] items-center gap-0 md:gap-0;
  opacity: 0;
  transform: translateY(18px) scale(0.98);
}

.timeline-marker {
  @apply relative z-10 col-start-2 row-start-1 flex flex-col items-center justify-center;
}

.timeline-content {
  @apply col-start-1 row-start-1 mr-6 w-full max-w-[430px] justify-self-end rounded-[28px] border border-gray-200/80 bg-gradient-to-br from-white via-gray-50 to-white p-7 shadow-[0_20px_55px_rgba(0,0,0,0.09)];
  position: relative;
  transform: perspective(1200px) rotateX(1deg) rotateY(-1deg);
  transition: transform 0.35s ease, box-shadow 0.35s ease;
}

.timeline-item:nth-child(even) .timeline-content {
  @apply col-start-3 mr-0 ml-6 justify-self-start;
  transform: perspective(1200px) rotateX(1deg) rotateY(1deg);
}

.timeline-item:hover .timeline-content {
  transform: perspective(1200px) rotateX(0deg) rotateY(0deg) translateY(-4px);
  box-shadow: 0 26px 65px rgba(15, 23, 42, 0.16);
}

.timeline-icon {
  @apply relative z-10 flex h-[88px] w-[88px] items-center justify-center rounded-full border-[3px] border-white/90 bg-gradient-to-br from-primary-50 via-white to-orange-50 text-3xl shadow-[0_18px_42px_rgba(245,124,0,0.22)];
  transform: translateZ(0);
  line-height: 1;
  animation: timelineFloat 4s ease-in-out infinite;
  position: relative;
}

.timeline-icon::after {
  content: '';
  display: none;
}

.timeline-icon-inner {
  @apply relative z-10 flex items-center justify-center leading-none drop-shadow-[0_3px_6px_rgba(0,0,0,0.12)];
  opacity: 0.9;
}

.timeline-icon-inner svg {
  width: 38px;
  height: 38px;
  display: block;
}

.timeline-year {
  @apply absolute inset-0 flex items-center justify-center text-[10px] font-extrabold uppercase tracking-[0.24em] text-primary-700;
  pointer-events: none;
  text-shadow: 0 1px 0 rgba(255,255,255,0.9);
}

.timeline-content::before {
  content: '';
  @apply absolute left-0 top-0 h-full w-full rounded-[28px];
  background: linear-gradient(135deg, rgba(245, 124, 0, 0.04), rgba(255,255,255,0));
  pointer-events: none;
}

.timeline-chip {
  @apply mb-4 inline-flex items-center rounded-full border border-primary-200 bg-primary-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-primary-700;
}

.timeline-title {
  @apply mb-3 text-xl font-semibold text-gray-900;
}

.timeline-description {
  @apply mb-4 text-base leading-7 text-gray-600;
}

.timeline-details {
  @apply space-y-2 border-t border-gray-200 pt-4;
}

.timeline-detail {
  @apply flex items-start gap-2 text-sm text-gray-700;
}

.timeline-detail::before {
  content: '✦';
  @apply mt-0.5 text-primary-500;
}

.timeline-item-last .timeline-marker::before {
  display: none;
}

@keyframes timelineFloat {
  0%,
  100% {
    transform: translateY(0px) scale(1);
  }
  50% {
    transform: translateY(-4px) scale(1.03);
  }
}

@media (max-width: 768px) {
  .timeline::before {
    @apply left-6;
  }

  .timeline-item {
    @apply grid-cols-[1fr_40px_1fr] gap-0 pl-2;
  }

  .timeline-marker {
    @apply col-start-2 row-start-1 items-center justify-center;
  }

  .timeline-content {
    @apply col-start-1 col-span-3 row-start-1 ml-0 mr-0 mt-0 w-full max-w-none rounded-[20px] p-5;
    transform: none;
  }

  .timeline-item:nth-child(even) .timeline-content {
    @apply ml-0 mr-0;
    transform: none;
  }

  .timeline-icon {
    @apply h-12 w-12 text-xl;
  }

  .timeline-year {
    @apply mt-2 text-[11px];
  }
}
</style>

