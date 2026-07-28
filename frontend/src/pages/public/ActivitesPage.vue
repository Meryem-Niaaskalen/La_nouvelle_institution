<script setup>
import { Section, Card } from '@/components'

const activities = [
  {
    title: 'Tournoi inter-classes',
    description: 'Une journée sportive riche en émotions et en esprit d’équipe.',
    date: '15 mai 2026',
    location: 'Complexe sportif',
  },
  {
    title: 'Exposition scientifique',
    description: 'Des projets innovants présentés par les élèves devant l’ensemble de la communauté.',
    date: '28 avril 2026',
    location: 'Campus principal',
  },
  {
    title: 'Journée culturelle',
    description: 'Musique, théâtre, arts et échanges autour du patrimoine et de la création.',
    date: '10 avril 2026',
    location: 'Auditorium',
  },
  {
    title: 'Voyage pédagogique',
    description: 'Une expérience d’apprentissage hors les murs enrichissante et formatrice.',
    date: '18 mars 2026',
    location: 'Marrakech',
  },
]
</script>

<template>
  <div class="bg-gray-50">
    <Section title="Activités et événements" subtitle="Un environnement vivant, riche et propice à l’épanouissement des élèves.">
      <div class="grid gap-6 lg:grid-cols-2">
        <Card v-for="activity in activities" :key="activity.title" :title="activity.title" :description="activity.description" :hoverable="true">
          <div class="mt-4 text-sm text-gray-600">
            <p><strong>Date :</strong> {{ activity.date }}</p>
            <p class="mt-1"><strong>Lieu :</strong> {{ activity.location }}</p>
          </div>
        </Card>
      </div>
    </Section>
  </div>
</template>
