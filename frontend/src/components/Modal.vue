<template>
  <Teleport to="body">
    <Transition name="modal">
      <div v-if="isOpen" class="modal-overlay" @click="closeModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h2 v-if="title" class="modal-title">{{ title }}</h2>
            <button
              class="modal-close"
              aria-label="Close modal"
              @click="closeModal"
            >
              ✕
            </button>
          </div>

          <div class="modal-body">
            <slot />
          </div>

          <div v-if="$slots.footer" class="modal-footer">
            <slot name="footer" />
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { computed, watch } from 'vue'

const props = defineProps({
  modelValue: Boolean,
  title: String,
  closeOnEscape: {
    type: Boolean,
    default: true,
  },
  closeOnClickOutside: {
    type: Boolean,
    default: true,
  },
})

const emit = defineEmits(['update:modelValue'])

const isOpen = computed({
  get: () => props.modelValue,
  set: (val) => emit('update:modelValue', val),
})

const closeModal = () => {
  if (props.closeOnClickOutside) {
    isOpen.value = false
  }
}

watch(isOpen, (val) => {
  if (val) {
    document.body.style.overflow = 'hidden'
  } else {
    document.body.style.overflow = 'auto'
  }
})

const handleKeydown = (e) => {
  if (props.closeOnEscape && e.key === 'Escape') {
    isOpen.value = false
  }
}

if (typeof window !== 'undefined') {
  window.addEventListener('keydown', handleKeydown)
}
</script>

<style scoped>
  @reference '../styles/tailwind.css';
.modal-overlay {
  @apply fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4;
}

.modal-content {
  @apply bg-white rounded-lg shadow-large max-w-md w-full max-h-[90vh] overflow-y-auto;
  @apply animate-scale-in;
}

.modal-header {
  @apply flex items-center justify-between px-6 py-4 border-b border-gray-200;
}

.modal-title {
  @apply text-xl font-semibold text-gray-900;
}

.modal-close {
  @apply w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-900 transition-colors rounded-lg hover:bg-gray-100;
  @apply cursor-pointer focus-ring;
}

.modal-body {
  @apply px-6 py-4;
}

.modal-footer {
  @apply px-6 py-4 border-t border-gray-200 flex gap-3 justify-end;
}

.modal-enter-active,
.modal-leave-active {
  @apply transition-all duration-300;
}

.modal-enter-from,
.modal-leave-to {
  @apply opacity-0;
}

.modal-enter-active .modal-content,
.modal-leave-active .modal-content {
  @apply transition-all duration-300;
}

.modal-enter-from .modal-content,
.modal-leave-to .modal-content {
  @apply scale-95 opacity-0;
}
</style>
