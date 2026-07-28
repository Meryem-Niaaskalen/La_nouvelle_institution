<template>
  <div class="input-wrapper">
    <label v-if="label" :for="id" class="input-label">
      {{ label }}
      <span v-if="required" class="text-error">*</span>
    </label>

    <div class="input-container">
      <span v-if="prefix" class="input-prefix">{{ prefix }}</span>

      <input
        :id="id"
        :class="[
          'input',
          `input-${variant}`,
          { 'input-error': error },
          { 'input-success': success },
          { 'input-disabled': disabled },
        ]"
        :type="type"
        :placeholder="placeholder"
        :disabled="disabled"
        :value="modelValue"
        v-bind="$attrs"
        @input="$emit('update:modelValue', $event.target.value)"
      />

      <span v-if="suffix" class="input-suffix">{{ suffix }}</span>
    </div>

    <p v-if="error" class="input-error-message">{{ error }}</p>
    <p v-else-if="hint" class="input-hint">{{ hint }}</p>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  id: String,
  modelValue: [String, Number],
  type: {
    type: String,
    default: 'text',
  },
  label: String,
  placeholder: String,
  hint: String,
  error: String,
  success: Boolean,
  disabled: Boolean,
  required: Boolean,
  prefix: String,
  suffix: String,
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'filled', 'outlined'].includes(v),
  },
})

defineEmits(['update:modelValue'])

const id = computed(() => props.id || `input-${Math.random().toString(36).substr(2, 9)}`)
</script>

<style scoped>
  @reference '../styles/tailwind.css';
.input-wrapper {
  @apply w-full;
}

.input-label {
  @apply block text-sm font-semibold text-gray-900 mb-2 cursor-pointer;
}

.input-container {
  @apply relative inline-flex items-center w-full;
}

.input {
  @apply w-full px-4 py-2 rounded-lg border transition-smooth focus-ring;
  @apply text-gray-900 placeholder:text-gray-400;
}

/* Variants */
.input-default {
  @apply border-gray-300 bg-white hover:border-gray-400 focus:border-primary-500;
}

.input-filled {
  @apply border-b-2 border-gray-300 bg-gray-50 hover:border-gray-400 focus:border-primary-500 focus:bg-white;
}

.input-outlined {
  @apply border-2 border-gray-300 hover:border-gray-400 focus:border-primary-500;
}

/* States */
.input-error {
  @apply border-error focus:border-error focus:ring-error;
}

.input-success {
  @apply border-success focus:border-success focus:ring-success;
}

.input-disabled {
  @apply disabled-state;
}

/* Prefix and Suffix */
.input-prefix,
.input-suffix {
  @apply absolute text-gray-500 pointer-events-none;
}

.input-prefix {
  @apply left-4;
}

.input:has(+ .input-suffix) {
  @apply pr-10;
}

.input-suffix {
  @apply right-4;
}

.input:has(+ .input-prefix) {
  @apply pl-10;
}

/* Messages */
.input-error-message {
  @apply text-error text-sm mt-1;
}

.input-hint {
  @apply text-gray-500 text-sm mt-1;
}
</style>
