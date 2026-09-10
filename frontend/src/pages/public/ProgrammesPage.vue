<script setup>
import { ArrowRight, Backpack, BookOpen, ChartNoAxesCombined, GraduationCap, School, ShieldCheck, Star, UsersRound } from 'lucide-vue-next'

const cycles = [
  {
    title: 'Maternelle',
    subtitle: 'Éveil, créativité et premières découvertes.',
    highlight: 'Un premier socle joyeux et structuré.',
    label: '01',
    border: 'border-orange-300',
    icon: School,
    accent: 'bg-orange-500 text-white',
    iconBg: 'bg-orange-50 text-orange-500',
    dot: 'bg-orange-500',
    line: 'border-orange-200',
    titleColor: 'text-slate-900',
  },
  {
    title: 'Primaire',
    subtitle: 'Bases solides et curiosité intellectuelle.',
    highlight: 'Confiance et rigueur au rythme des apprentissages.',
    label: '02',
    border: 'border-blue-300',
    icon: BookOpen,
    accent: 'bg-blue-500 text-white',
    iconBg: 'bg-blue-50 text-blue-500',
    dot: 'bg-blue-500',
    line: 'border-blue-200',
    titleColor: 'text-slate-900',
  },
  {
    title: 'Collège',
    subtitle: 'Culture générale et autonomie.',
    highlight: 'Réussite construite sur l’esprit critique et l’organisation.',
    label: '03',
    border: 'border-emerald-300',
    icon: Backpack,
    accent: 'bg-emerald-500 text-white',
    iconBg: 'bg-emerald-50 text-emerald-600',
    dot: 'bg-emerald-600',
    line: 'border-emerald-200',
    titleColor: 'text-slate-900',
  },
  {
    title: 'Lycée',
    subtitle: 'Ambition, performance et réussite.',
    highlight: 'Préparation sereine aux examens et aux choix d’orientation.',
    label: '04',
    border: 'border-slate-300',
    icon: GraduationCap,
    accent: 'bg-slate-900 text-white',
    iconBg: 'bg-indigo-50 text-indigo-900',
    dot: 'bg-indigo-900',
    line: 'border-indigo-200',
    titleColor: 'text-slate-900',
  },
]

const filieres = {
  college: [
    '1ère année collège',
    '2e année collège',
    '3e année collège',
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
    icon: School,
    iconClass: 'bg-orange-50 text-primary-500',
  },
  {
    title: 'Effectifs maîtrisés',
    description: 'Des classes à taille humaine pour un véritable suivi individuel.',
    icon: UsersRound,
    iconClass: 'bg-indigo-50 text-indigo-900',
  },
  {
    title: 'Pédagogie moderne',
    description: 'Des contenus renouvelés et des méthodes actives pour motiver les élèves.',
    icon: Star,
    iconClass: 'bg-orange-50 text-primary-500',
  },
  {
    title: 'Cadre serein',
    description: 'Un environnement sécurisé et propice à l’épanouissement scolaire.',
    icon: ShieldCheck,
    iconClass: 'bg-emerald-50 text-emerald-700',
  },
]
</script>

<template>
  <div class="bg-[#fdfcfb]">
    <section class="px-5 pb-12 pt-14 sm:px-8 sm:pb-16 sm:pt-20 lg:pt-24">
      <div class="mx-auto max-w-6xl text-center">
        <p class="text-xs font-bold uppercase tracking-[0.35em] text-primary-600">Notre parcours</p>
        <div class="mx-auto mt-3 h-0.5 w-9 bg-primary-500"></div>
        <h1 class="mt-5 font-serif text-4xl font-bold leading-tight text-slate-900 sm:text-5xl lg:text-6xl">Nos programmes</h1>
        <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-slate-600 sm:text-lg">Un parcours pensé pour accompagner chaque élève,<br class="hidden sm:block" /> de ses premières découvertes à la réussite au lycée.</p>

        <div class="relative mt-12 grid gap-6 sm:grid-cols-2 xl:grid-cols-4 xl:gap-5">
          <div class="pointer-events-none absolute left-[12%] right-[12%] top-6 hidden border-t border-slate-200 xl:block"></div>
          <div
            v-for="cycle in cycles"
            :key="cycle.title"
            class="group relative z-10 flex flex-col rounded-[18px] border border-slate-200/80 bg-white px-6 pb-7 pt-5 shadow-[0_10px_28px_rgba(15,23,42,0.06)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_35px_rgba(15,23,42,0.1)] sm:px-7"
          >
            <div class="flex items-center justify-between text-sm font-bold">
              <span :class="cycle.titleColor">{{ cycle.label }}</span>
              <span :class="['h-3.5 w-3.5 rounded-full border-4 border-white shadow-sm', cycle.dot]"></span>
            </div>
            <div class="mt-6 flex justify-center">
              <div :class="['flex h-20 w-20 items-center justify-center rounded-full', cycle.iconBg]"><component :is="cycle.icon" :size="42" :stroke-width="1.5" /></div>
            </div>
            <div class="mt-5 text-center">
              <span :class="['inline-flex rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-[0.25em]', cycle.iconBg]">
                Niveau {{ cycle.label }}
              </span>
              <h2 :class="['mt-4 font-serif text-2xl font-bold', cycle.titleColor]">{{ cycle.title }}</h2>
              <div :class="['mx-auto mt-3 h-0.5 w-7', cycle.dot]"></div>
              <p class="mx-auto mt-4 max-w-[16rem] text-sm leading-6 text-slate-600">{{ cycle.subtitle }}</p>
              <p class="mx-auto mt-3 max-w-[16rem] text-sm leading-6 text-slate-500">{{ cycle.highlight }}</p>
            </div>
          </div>
        </div>

        <div class="mx-auto mt-8 grid max-w-5xl gap-4 rounded-full border border-orange-100 bg-[#fff8f0] px-6 py-4 text-sm text-slate-700 sm:grid-cols-2 lg:grid-cols-4 lg:gap-0">
          <div class="flex items-center justify-center gap-3 border-orange-200 lg:border-r"><UsersRound :size="25" class="text-slate-900" /><span class="text-left">Accompagnement<br />personnalisé</span></div>
          <div class="flex items-center justify-center gap-3 border-orange-200 sm:border-r"><ShieldCheck :size="25" class="text-slate-900" /><span class="text-left">Encadrement bienveillant<br />et qualifié</span></div>
          <div class="flex items-center justify-center gap-3 border-orange-200 lg:border-r"><Star :size="25" class="text-slate-900" /><span class="text-left">Méthodes pédagogiques<br />innovantes</span></div>
          <div class="flex items-center justify-center gap-3"><ChartNoAxesCombined :size="25" class="text-slate-900" /><span class="text-left">Orientation et réussite<br />assurées</span></div>
        </div>
      </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 pb-20 sm:px-8">
      <div class="mb-10 text-center">
        <p class="text-xs font-bold uppercase tracking-[0.35em] text-primary-600">Nos orientations</p>
        <div class="mx-auto mt-3 h-0.5 w-9 bg-primary-500"></div>
        <h2 class="mt-4 font-serif text-4xl font-bold leading-tight text-slate-900 sm:text-5xl">Filières proposées</h2>
        <p class="mt-4 text-base text-slate-600 sm:text-lg">Des options structurées pour accompagner chaque projet.</p>
      </div>

      <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="rounded-[18px] border border-slate-200 bg-white p-6 shadow-[0_10px_28px_rgba(15,23,42,0.05)] sm:p-8">
          <div class="flex items-center justify-between gap-4 border-b border-slate-100 pb-6">
            <div class="flex items-center gap-4"><span class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-500 text-xl font-bold text-white" aria-label="Filière 01">01</span><h3 class="font-serif text-xl font-bold text-slate-900 sm:text-2xl">Filière Lycée Collégial</h3></div>
            <span class="hidden h-14 w-14 items-center justify-center rounded-full bg-orange-50 text-primary-500 sm:flex"><GraduationCap :size="29" :stroke-width="1.5" /></span>
          </div>
          <div class="mt-5 h-0.5 w-10 bg-primary-500"></div>
          <p class="mt-4 text-sm leading-6 text-slate-600">Un parcours progressif pour consolider les acquis et préparer l’orientation future.</p>
          <ul class="mt-6">
            <li v-for="(item, index) in filieres.college" :key="item" class="flex min-w-0 items-center gap-3 border-t border-slate-100 py-5 text-sm font-medium text-slate-900 sm:gap-4">
              <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-xs font-semibold text-primary-600">{{ String(index + 1).padStart(2, '0') }}</span><span class="min-w-0 flex-1 break-words">{{ item }}</span>
            </li>
          </ul>
        </div>

        <div class="rounded-[18px] border border-slate-200 bg-white p-6 shadow-[0_10px_28px_rgba(15,23,42,0.05)] sm:p-8">
          <div class="flex items-center justify-between gap-4 border-b border-slate-100 pb-6">
            <div class="flex items-center gap-4"><span class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-900 text-xl font-bold text-white" aria-label="Filière 02">02</span><h3 class="font-serif text-xl font-bold text-slate-900 sm:text-2xl">Filières Lycée Qualifiant</h3></div>
            <span class="hidden h-14 w-14 items-center justify-center rounded-full bg-indigo-50 text-indigo-900 sm:flex"><Star :size="29" :stroke-width="1.5" /></span>
          </div>
          <div class="mt-5 h-0.5 w-10 bg-slate-900"></div>
          <p class="mt-4 text-sm leading-6 text-slate-600">Des parcours spécialisés pour construire un projet d’études cohérent et ambitieux.</p>
          <ul class="mt-6">
            <li v-for="(item, index) in filieres.lycee" :key="item" class="flex min-w-0 items-center gap-3 border-t border-slate-100 py-3.5 text-sm font-medium text-slate-900 sm:gap-4">
              <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-xs font-semibold text-slate-700">{{ String(index + 1).padStart(2, '0') }}</span><span class="min-w-0 flex-1 break-words">{{ item }}</span>
            </li>
          </ul>
        </div>
      </div>

      <div class="mx-auto mt-7 flex max-w-2xl flex-col items-center justify-between gap-5 rounded-[18px] border border-slate-200 bg-white px-6 py-5 shadow-sm sm:flex-row sm:px-8">
        <div class="flex items-center gap-4"><span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-indigo-900"><GraduationCap :size="25" /></span><div><p class="font-semibold text-slate-900">Besoin d’aide pour choisir votre filière ?</p><p class="mt-1 text-xs text-slate-500">Notre équipe pédagogique est à votre écoute.</p></div></div>
        <router-link to="/contact" class="inline-flex shrink-0 items-center gap-2 text-sm font-bold text-slate-900 hover:text-primary-600">Nous contacter <ArrowRight :size="17" /></router-link>
      </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 pb-20 sm:px-8">
      <div class="mb-10 text-center"><p class="text-xs font-bold uppercase tracking-[0.3em] text-primary-600">Notre engagement</p><div class="mx-auto mt-3 h-0.5 w-9 bg-primary-500"></div><h2 class="mt-4 font-serif text-4xl font-bold leading-tight text-slate-900 sm:text-5xl">Ce qui distingue nos programmes</h2><p class="mx-auto mt-5 max-w-4xl text-base leading-7 text-slate-600 sm:text-lg">Nos programmes accompagnent les élèves dans un environnement serein et structuré.<br class="hidden sm:block" /> À chaque cycle correspond une progression claire, des objectifs pédagogiques affirmés et un suivi attentif.</p></div>
      <div class="rounded-[18px] border border-slate-200/80 bg-white p-6 shadow-[0_16px_38px_rgba(15,23,42,0.06)] sm:p-8 lg:p-10">
        <div class="grid gap-5 sm:grid-cols-2">
          <div v-for="item in strengths" :key="item.title" class="grid gap-5 rounded-2xl border border-slate-200/80 bg-white p-6 transition hover:-translate-y-0.5 hover:shadow-sm sm:grid-cols-[7.5rem_1fr] sm:items-center">
            <div :class="['flex h-24 w-24 items-center justify-center rounded-full', item.iconClass]"><component :is="item.icon" :size="47" :stroke-width="1.45" /></div>
            <div>
              <h4 class="font-serif text-xl font-bold text-slate-900">{{ item.title }}</h4>
              <div class="mt-3 h-0.5 w-9 bg-primary-500"></div>
              <p class="mt-4 text-sm leading-6 text-slate-600">{{ item.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped>
.circle-decor {
  position: absolute;
  border-radius: 9999px;
  filter: blur(50px);
  opacity: 0.35;
}
</style>


