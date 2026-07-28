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
      <div v-if="badge" class="card-badge">{{ badge }}</div>

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
  hoverable: Boolean,
  clickable: Boolean,
  customClass: String,
})
</script>

<style scoped>
  @reference '../styles/tailwind.css';
.card {
  @apply bg-white rounded-lg overflow-hidden transition-smooth;
}

/* Variants */
.card-default {
  @apply shadow-soft border border-gray-200;
}

.card-elevated {
  @apply shadow-medium;
}

.card-outlined {
  @apply border-2 border-gray-300;
}

.card-filled {
  @apply bg-gray-50 border border-gray-200;
}

/* Hover effect */
.card-hover {
  @apply hover:shadow-large hover:-translate-y-1;
}

.card-clickable {
  @apply cursor-pointer;
}

/* Image */
.card-image {
  @apply w-full h-48 overflow-hidden bg-gray-200;
}

.card-image img {
  @apply w-full h-full object-cover transition-smooth;
}

.card-hover .card-image img {
  @apply hover:scale-105;
}

/* Content */
.card-content {
  @apply p-6;
}

/* Badge */
.card-badge {
  @apply inline-block px-3 py-1 bg-primary-100 text-primary-600 rounded-full text-xs font-semibold mb-3 uppercase tracking-wide;
}

/* Title */
.card-title {
  @apply text-xl font-semibold text-gray-900 mb-2;
}

/* Description */
.card-description {
  @apply text-gray-600 text-sm leading-relaxed mb-4;
}

/* Body */
.card-body {
  @apply mb-4;
}

/* Footer */
.card-footer {
  @apply pt-4 border-t border-gray-200;
}
</style>
