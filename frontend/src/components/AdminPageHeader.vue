<template>
  <div class="rounded-2xl border border-slate-200/80 bg-slate-50/90 px-5 py-4 shadow-sm sm:px-6 sm:py-5">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
      <div class="max-w-3xl">
        <h1 class="text-xl font-semibold tracking-tight text-slate-900 md:text-2xl">{{ title }}</h1>
        <p v-if="subtitle" class="mt-1 text-xs leading-5 text-slate-600 sm:text-sm">{{ subtitle }}</p>

        <nav v-if="breadcrumbs && breadcrumbs.length" class="mt-2 text-xs text-slate-500">
          <ol class="flex flex-wrap items-center gap-2">
            <li v-for="(crumb, i) in breadcrumbs" :key="i" class="flex items-center gap-2">
              <RouterLink v-if="crumb.to" :to="crumb.to" class="text-slate-600 transition hover:text-slate-900">{{ crumb.label }}</RouterLink>
              <span v-else class="text-slate-400">{{ crumb.label }}</span>
              <span v-if="i < breadcrumbs.length - 1" class="text-slate-300">/</span>
            </li>
          </ol>
        </nav>
      </div>

      <div v-if="$slots.actions" class="flex flex-wrap items-center gap-3">
        <slot name="actions" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { RouterLink } from 'vue-router'
defineProps({
  title: { type: String, required: true },
  subtitle: { type: String, default: '' },
  breadcrumbs: { type: Array, default: () => [] },
})
</script>
