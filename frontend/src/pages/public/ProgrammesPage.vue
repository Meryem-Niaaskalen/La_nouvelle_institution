<script setup>
import { Section, Card, Button } from '@/components'

const programs = [
  {
    title: 'Baccalauréat scientifique',
    description: 'Un parcours orienté vers les sciences, la recherche et l’innovation.',
    points: ['Physique-chimie', 'Biologie', 'Mathématiques avancées'],
  },
  {
    title: 'Baccalauréat lettres',
    description: 'Un cursus riche en culture générale, expression et pensée critique.',
    points: ['Français', 'Histoire-géographie', 'Langues et littérature'],
  },
  {
    title: 'Système d’information',
    description: 'Des compétences solides en numérique, programmation et outils collaboratifs.',
    points: ['Informatique', 'Design', 'Création de contenus'],
  },
  {
    title: 'Préparation concours',
    description: 'Un accompagnement structuré pour les études supérieures et les grands concours.',
    points: ['Méthodologie', 'Entraînement', 'Suivi personnalisé'],
  },
]
</script>

<template>
  <div class="bg-gray-50">
    <Section title="Nos programmes" subtitle="Des formations modernes, variées et pensées pour l’avenir de chaque élève.">
      <div class="grid gap-6 lg:grid-cols-2">
        <Card v-for="program in programs" :key="program.title" :title="program.title" :description="program.description" :hoverable="true">
          <ul class="mt-4 space-y-2 text-sm text-gray-600">
            <li v-for="point in program.points" :key="point">• {{ point }}</li>
          </ul>
          <template #footer>
            <Button size="sm" variant="ghost" label="En savoir plus" />
          </template>
        </Card>
      </div>
    </Section>

    <Section title="Pourquoi choisir nos programmes ?" subtitle="Un cadre pédagogique exigeant et bienveillant" :dark="true">
      <div class="grid gap-6 md:grid-cols-3">
        <div class="rounded-2xl border border-gray-700 bg-gray-800 p-6 text-white">
          <h3 class="text-xl font-semibold">Pedagogie active</h3>
          <p class="mt-3 text-gray-300">Des cours interactifs, des projets et des activités de recherche.</p>
        </div>
        <div class="rounded-2xl border border-gray-700 bg-gray-800 p-6 text-white">
          <h3 class="text-xl font-semibold">Accompagnement personnalisé</h3>
          <p class="mt-3 text-gray-300">Chaque élève bénéficie d’un suivi attentif et adapté à son profil.</p>
        </div>
        <div class="rounded-2xl border border-gray-700 bg-gray-800 p-6 text-white">
          <h3 class="text-xl font-semibold">Ouverture internationale</h3>
          <p class="mt-3 text-gray-300">Des partenariats pour stimuler les compétences interculturelles.</p>
        </div>
      </div>
    </Section>
  </div>
</template>
