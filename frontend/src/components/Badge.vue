<template>
  <span :class="['badge', `badge-${variant}`, `badge-${size}`]">
    <slot>{{ label }}</slot>
  </span>
</template>

<script setup>
defineProps({
  label: String,
  variant: {
    type: String,
    default: 'primary',
    validator: (v) => ['primary', 'secondary', 'success', 'warning', 'error', 'info'].includes(v),
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v),
  },
})
</script>

<style scoped>
  @reference '../styles/tailwind.css';
.badge {
  @apply inline-flex items-center justify-center font-semibold rounded-full whitespace-nowrap;
}

/* Sizes */
.badge-sm {
  @apply px-2 py-0.5 text-xs;
}

.badge-md {
  @apply px-3 py-1 text-sm;
}

.badge-lg {
  @apply px-4 py-1.5 text-base;
}

/* Variants */
.badge-primary {
  @apply bg-primary-100 text-primary-700;
}

.badge-secondary {
  @apply bg-gray-200 text-gray-800;
}

.badge-success {
  @apply bg-green-100 text-green-700;
}

.badge-warning {
  @apply bg-yellow-100 text-yellow-800;
}

.badge-error {
  @apply bg-red-100 text-red-700;
}

.badge-info {
  @apply bg-blue-100 text-blue-700;
}
</style>
