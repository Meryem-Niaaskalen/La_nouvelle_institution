<script setup>
import { Section, GalleryGrid } from '@/components'
import { galleryItems, galleryCategories } from '@/data/gallery'
</script>

<template>
  <div class="bg-slate-50">
    <Section
      title="Galerie photo"
      subtitle="Des instants authentiques et signifiants, révélateurs de notre vie scolaire."
    >
      <div class="grid gap-8 lg:grid-cols-[1.25fr_0.75fr] items-start">
        <div class="rounded-[32px] border border-slate-200 bg-white p-10 shadow-large">
          <div class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600">
            Galerie institutionnelle
          </div>
          <div class="mt-5 flex items-center gap-3">
            <span class="h-1.5 w-14 rounded-full bg-primary-600"></span>
            <span class="h-1.5 w-10 rounded-full bg-emerald-400"></span>
            <span class="h-1.5 w-6 rounded-full bg-sky-400"></span>
          </div>
          <h3 class="mt-6 text-4xl font-semibold text-slate-900 leading-tight">Des images élégantes qui valorisent notre identité et notre engagement.</h3>
          <p class="mt-5 text-lg leading-8 text-slate-600">
            Plongez dans une sélection visuelle pensée pour mettre en avant la qualité de nos espaces, la dynamique des élèves et la richesse des expériences pédagogiques.
          </p>
          <div class="mt-8 flex flex-wrap gap-3">
            <span class="rounded-full bg-primary-50 px-4 py-2 text-sm font-medium text-primary-700">Équilibre</span>
            <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700">Chaleur</span>
            <span class="rounded-full bg-sky-50 px-4 py-2 text-sm font-medium text-sky-700">Clarté</span>
          </div>
        </div>

        <div class="grid gap-4">
          <div class="rounded-[28px] border border-slate-200 bg-sky-50 p-8 shadow-soft">
            <p class="text-sm uppercase tracking-[0.28em] text-slate-500">Photos</p>
            <p class="mt-3 text-3xl font-semibold text-slate-900">{{ galleryItems.length }}</p>
            <p class="mt-4 text-sm leading-6 text-slate-600">Images sélectionnées pour exprimer l’élégance et la cohérence du projet.</p>
          </div>
          <div class="rounded-[28px] border border-slate-200 bg-amber-50 p-8 shadow-soft">
            <p class="text-sm uppercase tracking-[0.28em] text-slate-500">Ambiance</p>
            <h4 class="mt-3 text-xl font-semibold text-slate-900">Clarté, sobriété et style.</h4>
            <p class="mt-3 text-sm leading-6 text-slate-600">Une mise en page épurée, des contrastes doux et des images mises en valeur.</p>
          </div>
        </div>
      </div>

      <div class="mt-10 rounded-[32px] border border-slate-200 bg-white p-6 shadow-large">
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
          <div class="max-w-2xl">
            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-slate-500">Collection visuelle</p>
            <h3 class="mt-3 text-3xl font-semibold text-slate-900">Un ensemble cohérent, élégant et inspirant.</h3>
          </div>
          <div class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700">
            <span class="text-slate-900">{{ galleryItems.length }} photos</span>
          </div>
        </div>

        <GalleryGrid :items="galleryItems" :categories="galleryCategories" category-field="category" />
      </div>
    </Section>
  </div>
</template>
