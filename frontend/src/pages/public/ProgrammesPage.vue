<script setup>
import { Section, Card } from '@/components'

const cycles = [
  {
    title: 'Maternelle',
    subtitle: 'Éveil, créativité et premières découvertes.',
    label: '01',
    gradient: 'from-orange-400 to-orange-600',
    icon: '🧸',
  },
  {
    title: 'Primaire',
    subtitle: 'Bases solides et curiosité intellectuelle.',
    label: '02',
    gradient: 'from-blue-500 to-blue-700',
    icon: '✏️',
  },
  {
    title: 'Collège',
    subtitle: 'Culture générale et autonomie.',
    label: '03',
    gradient: 'from-emerald-500 to-emerald-700',
    icon: '🎒',
  },
  {
    title: 'Lycée',
    subtitle: 'Ambition, performance et réussite.',
    label: '04',
    gradient: 'from-slate-600 to-slate-900',
    icon: '🎓',
  },
]

const filieres = {
  college: [
    '3e année collège',
    '2e année collège',
    '1ère année collège',
  ],
  lycee: [
    'Sciences Mathématiques (A)',
    'Sciences Mathématiques (B)',
    'Sciences Physiques',
    'Sciences de la Vie et de la Terre',
    'Sciences Économiques et Gestion',
    'Lettres et Sciences Humaines',
  ],
}

const strengths = [
  {
    title: 'Encadrement qualifié',
    description: 'Des enseignants expérimentés engagés dans chaque étape du parcours.',
    icon: '',
  },
  {
    title: 'Effectifs maîtrisés',
    description: 'Des classes à taille humaine pour un véritable suivi individuel.',
    icon: '',
  },
  {
    title: 'Pédagogie moderne',
    description: 'Des contenus renouvelés et des méthodes actives pour motiver les élèves.',
    icon: '✨',
  },
  {
    title: 'Cadre serein',
    description: 'Un environnement sécurisé et propice à l’épanouissement scolaire.',
    icon: '',
  },
]
</script>

<template>
  <div class="bg-slate-50">
    <Section title="Nos cycles d’enseignement" subtitle="Un parcours complet du préscolaire au lycée, conçu pour accompagner chaque élève vers la réussite.">
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <Card
          v-for="cycle in cycles"
          :key="cycle.title"
          class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-soft transition-transform duration-300 hover:-translate-y-1"
        >
          <div class="relative overflow-hidden bg-slate-950/5 p-6">
            <div class="absolute inset-x-0 top-0 h-2 bg-gradient-to-r" :class="cycle.gradient"></div>
            <div class="flex items-center gap-4">
              <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-white shadow-sm" :class="cycle.gradient">
                <span class="text-3xl">{{ cycle.icon }}</span>
              </div>
              <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Cycle</p>
                <h3 class="mt-4 text-2xl font-semibold text-slate-900">{{ cycle.title }}</h3>
              </div>
            </div>
            <p class="mt-4 text-sm leading-6 text-slate-600">{{ cycle.subtitle }}</p>
          </div>

          <div class="border-t border-slate-200 bg-slate-50 px-6 py-5">
            <div class="flex items-center justify-between gap-4">
              <div>
                <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Étape</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">Cycle {{ cycle.label }}</p>
              </div>
              <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-slate-900 shadow-sm">
                {{ cycle.label }}
              </div>
            </div>
          </div>
        </Card>
      </div>
    </Section>

    <Section title="Filières proposées" subtitle="Des options claires et structurées pour le collège et le lycée.">
      <div class="grid gap-8 xl:grid-cols-2">
        <div class="rounded-[36px] border border-slate-200 bg-white p-10 shadow-soft">
          <div class="flex items-center gap-3 rounded-full bg-orange-100 px-5 py-3 text-orange-700 font-semibold">
            <span class="text-lg">01</span>
            Filière Lycée Collégial
          </div>
          <ul class="mt-8 space-y-4 text-slate-700">
            <li v-for="item in filieres.college" :key="item" class="flex items-start gap-4">
              <span class="mt-1 h-2.5 w-2.5 rounded-full bg-orange-500"></span>
              <span>{{ item }}</span>
            </li>
          </ul>
        </div>

        <div class="rounded-[36px] border border-slate-200 bg-white p-10 shadow-soft">
          <div class="flex items-center gap-3 rounded-full bg-slate-900 px-5 py-3 text-white font-semibold">
            <span class="text-lg">02</span>
            Filières Lycée Qualifiant
          </div>
          <ul class="mt-8 space-y-4 text-slate-700">
            <li v-for="item in filieres.lycee" :key="item" class="flex items-start gap-4">
              <span class="mt-1 h-2.5 w-2.5 rounded-full bg-slate-900"></span>
              <span>{{ item }}</span>
            </li>
          </ul>
        </div>
      </div>
    </Section>

    <Section title="Ce qui distingue nos programmes" subtitle="Des parcours modernes, exigeants et bienveillants, pensés pour l’épanouissement scolaire.">
      <div class="rounded-[36px] border border-slate-200 bg-white p-10 shadow-soft">
        <p class="text-lg leading-8 text-slate-600">
          Nos programmes accompagnent les élèves dans un environnement serein et structuré. À chaque cycle correspond une progression claire, des objectifs pédagogiques affirmés et un suivi attentif.
        </p>
        <div class="mt-8 grid gap-4 sm:grid-cols-2">
          <div v-for="item in strengths" :key="item.title" class="rounded-[28px] border border-slate-200 bg-slate-50 p-6">
            <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-2xl shadow-sm">
              {{ item.icon }}
            </div>
            <h4 class="mt-4 text-lg font-semibold text-slate-900">{{ item.title }}</h4>
            <p class="mt-2 text-slate-600">{{ item.description }}</p>
          </div>
        </div>
      </div>
    </Section>
  </div>
</template>

