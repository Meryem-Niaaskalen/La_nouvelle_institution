<script setup>
import { Section, GalleryGrid } from '@/components'

const galleryItems = [
  {
    id: 1,
    title: 'Campus moderne',
    date: 'Mai 2026',
    image: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=900&q=80',
    category: 'Campus',
  },
  {
    id: 2,
    title: 'Tournoi sportif',
    date: 'Avril 2026',
    image: 'https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=900&q=80',
    category: 'Événements',
  },
  {
    id: 3,
    title: 'Laboratoire scientifique',
    date: 'Mars 2026',
    image: 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=900&q=80',
    category: 'Sciences',
  },
  {
    id: 4,
    title: 'Journée culturelle',
    date: 'Février 2026',
    image: 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=900&q=80',
    category: 'Événements',
  },
  {
    id: 5,
    title: 'Classe connectée',
    date: 'Janvier 2026',
    image: 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=900&q=80',
    category: 'Campus',
  },
  {
    id: 6,
    title: 'Exposition scientifique',
    date: 'Décembre 2025',
    image: 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=900&q=80',
    category: 'Sciences',
  },
]
</script>

<template>
  <div class="bg-gray-50">
    <Section title="Galerie photo" subtitle="Des moments de vie, de découverte et d’excellence au sein de l’établissement.">
      <GalleryGrid :items="galleryItems" :categories="['Tous', 'Campus', 'Événements', 'Sciences']" category-field="category" />
    </Section>
  </div>
</template>
