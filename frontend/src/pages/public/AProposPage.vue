<script setup>
import { Section, Card, Badge } from '@/components'

const values = [
  {
    title: 'Excellence académique',
    description: 'Un encadrement rigoureux et des parcours adaptés à chaque élève.',
  },
  {
    title: 'Éducation moderne',
    description: 'Des outils numériques, des laboratoires et des méthodes innovantes.',
  },
  {
    title: 'Épanouissement humain',
    description: 'Des valeurs de respect, d’inclusion et de responsabilité citoyenne.',
  },
]

const milestones = [
  {
    id: 1,
    year: '1997',
    icon: '🏫',
    title: 'Création de l’établissement',
    description: 'Naissance d’une école ambitieuse portée par une vision d’excellence.',
    items: ['Équipe fondatrice', 'Première promotion', 'Projet éducatif clair'],
  },
  {
    id: 2,
    year: '2005',
    icon: '🎓',
    title: 'Expansion pédagogique',
    description: 'Développement des filières et renforcement des méthodes d’enseignement.',
    items: ['Programmes enrichis', 'Infrastructures modernisées', 'Succès académique constant'],
  },
  {
    id: 3,
    year: '2026',
    icon: '💻',
    title: 'École du futur',
    description: 'Une institution connectée, ouverte et tournée vers l’avenir des élèves.',
    items: ['Plateforme numérique', 'Culture scientifique', 'Partenariats locaux et internationaux'],
  },
]
</script>

<template>
  <div class="bg-gray-50">
    <Section title="À propos de La nouvelle institution" subtitle="Une école de confiance, de qualité et d’excellence depuis plus de 25 ans.">
      <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr] items-start">
        <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-soft">
          <Badge label="Notre identité" class="mb-4" />
          <p class="text-lg text-gray-700 leading-8">
            La nouvelle institution est un établissement d’enseignement de référence, reconnu pour la qualité de ses formations,
            la richesse de sa vie scolaire et l’accompagnement personnalisé offert à chaque élève.
          </p>
          <p class="mt-4 text-lg text-gray-700 leading-8">
            Nous formons des jeunes autonomes, curieux, responsables et prêts à réussir dans un monde en constante évolution.
          </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
          <Card title="+25 ans" description="D’expérience éducative et d’engagement institutionnel." badge="Expérience" />
          <Card title="500+" description="Élèves accompagnés chaque année dans leur parcours." badge="Élèves" />
        </div>
      </div>
    </Section>

    <Section title="Nos valeurs" subtitle="Des fondements solides pour une éducation de qualité" :dark="true">
      <div class="grid gap-6 md:grid-cols-3">
        <Card v-for="value in values" :key="value.title" :title="value.title" :description="value.description" :hoverable="true" />
      </div>
    </Section>

    <Section title="Notre histoire" subtitle="Un parcours marqué par la continuité, l’innovation et la confiance">
      <div class="rounded-3xl border border-gray-200 bg-white p-4 md:p-8 shadow-soft">
        <div class="relative">
          <div class="absolute left-6 top-0 bottom-0 hidden w-0.5 bg-primary-200 md:block" />
          <div class="space-y-6">
            <div v-for="item in milestones" :key="item.id" class="relative md:pl-12">
              <div class="absolute left-0 top-2 hidden h-5 w-5 rounded-full border-4 border-white bg-primary-500 md:block" />
              <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">
                <div class="mb-3 flex items-center gap-3">
                  <span class="text-2xl">{{ item.icon }}</span>
                  <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-primary-600">{{ item.year }}</p>
                    <h3 class="text-xl font-semibold text-gray-900">{{ item.title }}</h3>
                  </div>
                </div>
                <p class="text-gray-700 leading-7">{{ item.description }}</p>
                <ul class="mt-4 space-y-2 text-sm text-gray-600">
                  <li v-for="detail in item.items" :key="detail">• {{ detail }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Section>
  </div>
</template>
