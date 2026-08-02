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
  @apply inline-flex items-center justify-center gap-2 rounded-[20px] border border-transparent px-4 py-2 font-semibold shadow-sm transition-all duration-200 focus-ring;
  @apply cursor-pointer;
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
  @apply bg-gradient-to-r from-primary-600 via-primary-500 to-primary-400 text-white hover:from-primary-700 hover:via-primary-600 hover:to-primary-500 active:from-primary-800 active:via-primary-700 active:to-primary-600 shadow-lg;
}

.btn-secondary {
  @apply bg-slate-100 text-slate-900 hover:bg-slate-200 active:bg-slate-300;
}

.btn-outline {
  @apply bg-white border-2 border-primary-500 text-primary-600 hover:bg-primary-50 active:bg-primary-100;
}

.btn-ghost {
  @apply bg-transparent text-primary-600 hover:bg-slate-100 active:bg-slate-200;
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
