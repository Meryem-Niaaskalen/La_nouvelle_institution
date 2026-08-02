<template>
  <div
    :class="[
      'card',
      `card-${variant}`,
      { 'card-hover': hoverable },
      { 'card-clickable': clickable },
      customClass,
    ]"
    v-bind="$attrs"
  >
    <div v-if="$slots.image || image" class="card-image">
      <slot name="image">
        <img :src="image" :alt="title" class="w-full h-full object-cover" />
      </slot>
    </div>

    <div class="card-content">
      <div v-if="badge" class="card-badge" :class="badgeClass">{{ badge }}</div>

      <h3 v-if="title" class="card-title">{{ title }}</h3>

      <p v-if="description" class="card-description">{{ description }}</p>

      <div v-if="$slots.default" class="card-body">
        <slot />
      </div>

      <div v-if="$slots.footer" class="card-footer">
        <slot name="footer" />
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'elevated', 'outlined', 'filled'].includes(v),
  },
  title: String,
  description: String,
  image: String,
  badge: String,
  badgeClass: String,
  hoverable: Boolean,
  clickable: Boolean,
  customClass: String,
})
</script>

<style scoped>
  @reference '../styles/tailwind.css';
.card {
  @apply bg-white rounded-[32px] overflow-hidden transition-smooth;
}

/* Variants */
.card-default {
  @apply shadow-soft border border-slate-200;
}

.card-elevated {
  @apply shadow-large;
}

.card-outlined {
  @apply border-2 border-slate-200;
}

.card-filled {
  @apply bg-slate-50 border border-slate-200;
}

/* Hover effect */
.card-hover {
  @apply hover:shadow-xl hover:-translate-y-1;
}

.card-clickable {
  @apply cursor-pointer;
}

/* Image */
.card-image {
  @apply w-full h-56 overflow-hidden bg-slate-200;
}

.card-image img {
  @apply w-full h-full object-cover transition-smooth;
}

.card-hover .card-image img {
  @apply hover:scale-105;
}

/* Content */
.card-content {
  @apply p-8;
}

/* Badge */
.card-badge {
  @apply inline-flex items-center rounded-full bg-primary-50 px-3 py-1.5 text-xs font-semibold text-primary-700 uppercase tracking-[0.24em] mb-3;
}

/* Title */
.card-title {
  @apply text-2xl font-semibold text-slate-900 mb-3;
}

/* Description */
.card-description {
  @apply text-slate-600 text-base leading-7 mb-5;
}

/* Body */
.card-body {
  @apply mb-4;
}

/* Footer */
.card-footer {
  @apply pt-4 border-t border-slate-200;
}
</style>
