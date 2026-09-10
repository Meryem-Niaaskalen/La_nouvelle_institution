<script setup>
import { Section, Card, Badge } from '@/components'

const values = [
  {
    icon: '🏆',
    title: 'Excellence académique',
    description: 'Un encadrement exigeant et des parcours pédagogiques conçus pour former des leaders confiants et curieux.',
  },
  {
    icon: '✨',
    title: 'Pédagogie innovante',
    description: 'Des classes interactives, des outils digitaux et des projets ancrés dans les enjeux du monde contemporain.',
  },
  {
    icon: '🌱',
    title: 'Épanouissement humain',
    description: 'Une communauté bienveillante, ouverte et inclusive où chaque élève est encouragé à s’exprimer et à grandir.',
  },
]

const stats = [
  { id: 1, label: 'Années d’expérience', value: '25+', accent: 'bg-sky-50 text-sky-700' },
  { id: 2, label: 'Élèves accompagnés', value: '500+', accent: 'bg-emerald-50 text-emerald-700' },
  { id: 3, label: 'Enseignants qualifiés', value: '35', accent: 'bg-violet-50 text-violet-700' },
  { id: 4, label: 'Programmes certifiés', value: '12', accent: 'bg-amber-50 text-amber-700' },
]

</script>

<template>
  <div class="bg-slate-50">
    <Section
      title="À propos de La nouvelle institution"
      subtitle="Un établissement de référence, conjuguant exigence éducative, innovation et bienveillance depuis plus de 25 ans."
    >
      <div class="grid grid-cols-1 gap-10 lg:grid-cols-[1.25fr_0.75fr] items-start">
        <div class="rounded-[36px] border border-slate-200 bg-white p-12 shadow-large">
          <Badge label="Notre identité" class="mb-6" />
          <h2 class="text-3xl sm:text-4xl font-semibold text-slate-900 mb-5">Une pédagogie exigeante, une expérience humaine chaleureuse.</h2>
          <p class="text-lg leading-8 text-slate-700 mb-6">
            La nouvelle institution incarne une vision éducative moderne : excellence académique,
            accompagnement personnalisé et développement global de chaque élève.
          </p>
          <p class="text-lg leading-8 text-slate-700">
            Nous mettons en œuvre des parcours structurés et innovants pour préparer des jeunes responsables,
            curieux et résilients, capables de réussir dans un monde en constante évolution.
          </p>
        </div>

        <div class="flex items-center justify-center">
          <div class="w-full max-w-md rounded-2xl border border-orange-100 bg-white p-8 shadow-large flex flex-col items-center text-center overflow-hidden">
            <img src="/images/logo-school-3.png" alt="Logo La nouvelle institution" class="h-44 w-44 rounded-full border border-white/20 bg-white object-contain p-2 shadow-sm" />

            <h3 class="mt-6 text-2xl sm:text-3xl font-extrabold text-slate-900">La nouvelle institution</h3>

            <div class="mt-3 mb-3 w-14 h-1 rounded bg-orange-400"></div>

            <p class="text-sm text-slate-500">Exigence éducative <span class="mx-2 text-orange-400">•</span> Innovation <span class="mx-2 text-orange-400">•</span> Bienveillance</p>

            <div class="mt-6 w-full">
              <svg viewBox="0 0 1440 120" class="w-full" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                  <linearGradient id="g1" x1="0%" x2="100%" y1="0%" y2="0%">
                    <stop offset="0%" stop-color="#fff7f2" />
                    <stop offset="100%" stop-color="#ffd0a0" />
                  </linearGradient>
                </defs>
                <path d="M0,40 C200,120 400,0 720,60 C1040,120 1240,20 1440,80 L1440,120 L0,120 Z" fill="url(#g1)" />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </Section>

    <Section title="Mission & vision" subtitle="Une éducation construite autour de valeurs fortes et d’une ambition collective.">
      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div
          v-for="value in values"
          :key="value.title"
          class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-soft transition hover:shadow-medium"
        >
          <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl text-slate-800">
            {{ value.icon }}
          </div>
          <h3 class="text-xl font-semibold text-slate-900 mb-3">{{ value.title }}</h3>
          <p class="text-slate-600 leading-7">{{ value.description }}</p>
        </div>
      </div>

      <div class="mt-10 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-large">
          <Badge label="Mission" class="mb-4" />
          <h3 class="text-2xl font-semibold text-slate-900 mb-3">Former des citoyens responsables et performants.</h3>
          <p class="text-slate-600 leading-7">
            Nous accompagnons chaque élève dans un parcours exigeant et bienveillant, en développant ses compétences intellectuelles,
            sociales et émotionnelles pour qu’il gagne en autonomie et en assurance.
          </p>
        </div>

        <div class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-large">
          <Badge label="Vision" class="mb-4" />
          <h3 class="text-2xl font-semibold text-slate-900 mb-3">Construire une école agile, innovante et durable.</h3>
          <p class="text-slate-600 leading-7">
            Notre vision repose sur une pédagogie moderne, l’intégration du numérique et la valorisation du rapport humain,
            pour offrir un cadre sécurisé propice à l’épanouissement de chacun.
          </p>
        </div>
      </div>
    </Section>
  </div>
</template>

