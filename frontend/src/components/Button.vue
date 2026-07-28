<template>
  <button
    :class="[
      'btn',
      `btn-${variant}`,
      `btn-${size}`,
      { 'btn-full': fullWidth },
      { 'btn-disabled': disabled },
      customClass,
    ]"
    :disabled="disabled"
    v-bind="$attrs"
  >
    <span v-if="icon" class="btn-icon">{{ icon }}</span>
    <slot>{{ label }}</slot>
  </button>
</template>

<script setup>
defineProps({
  variant: {
    type: String,
    default: 'primary',
    validator: (v) => ['primary', 'secondary', 'outline', 'ghost', 'danger'].includes(v),
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v),
  },
  label: String,
  icon: String,
  disabled: Boolean,
  fullWidth: Boolean,
  customClass: String,
})
</script>

<style scoped>
  @reference '../styles/tailwind.css';
.btn {
  @apply px-4 py-2 rounded-lg font-semibold transition-smooth focus-ring;
  @apply inline-flex items-center justify-center gap-2;
  @apply cursor-pointer border border-transparent;
}

/* Sizes */
.btn-sm {
  @apply px-3 py-1 text-sm;
}

.btn-md {
  @apply px-4 py-2 text-base;
}

.btn-lg {
  @apply px-6 py-3 text-lg;
}

/* Variants */
.btn-primary {
  @apply bg-primary-500 text-white hover:bg-primary-600 active:bg-primary-700;
}

.btn-secondary {
  @apply bg-gray-100 text-gray-900 hover:bg-gray-200 active:bg-gray-300;
}

.btn-outline {
  @apply bg-transparent border-2 border-primary-500 text-primary-500 hover:bg-primary-50 active:bg-primary-100;
}

.btn-ghost {
  @apply bg-transparent text-primary-500 hover:bg-gray-100 active:bg-gray-200;
}

.btn-danger {
  @apply bg-error text-white hover:bg-red-600 active:bg-red-700;
}

/* Full width */
.btn-full {
  @apply w-full;
}

/* Disabled state */
.btn-disabled {
  @apply disabled-state;
}

/* Icon styling */
.btn-icon {
  @apply inline-flex items-center justify-center text-lg;
}
</style>
