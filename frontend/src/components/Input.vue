<template>
  <div class="input-wrapper">
    <label v-if="label" :for="id" class="input-label">
      {{ label }}
      <span v-if="required" class="text-error">*</span>
    </label>

    <div class="input-container">
      <span v-if="prefix" class="input-prefix">{{ prefix }}</span>

      <component
        :is="type === 'textarea' ? 'textarea' : 'input'"
        :id="id"
        :class="[
          'input',
          `input-${variant}`,
          { 'input-error': error },
          { 'input-success': success },
          { 'input-disabled': disabled },
          { 'input-textarea': type === 'textarea' },
        ]"
        :type="type === 'textarea' ? undefined : type"
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
  @apply w-full rounded-[20px] border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 placeholder:text-slate-400 transition-all duration-200 focus:border-primary-500 focus:ring-primary-200 focus:ring-2;
}

/* Variants */
.input-default {
  @apply border-slate-200 bg-slate-50 hover:border-slate-300 focus:border-primary-500;
}

.input-filled {
  @apply border-transparent bg-slate-100 hover:border-slate-300 focus:border-primary-500 focus:bg-white;
}

.input-outlined {
  @apply border-2 border-slate-200 bg-white hover:border-slate-300 focus:border-primary-500;
}

.input-textarea {
  @apply min-h-[160px] resize-none;
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
