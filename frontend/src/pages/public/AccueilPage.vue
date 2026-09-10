<script setup>
import { ref, onMounted, computed } from 'vue'
import {
  Hero,
  Section,
  Card,
  Button,
  StatsCounter,
  Timeline,
  Badge,
} from '@/components'
import { useGSAP } from '@/useGSAP'
import {
  getPrograms,
  getFeaturedActivities,
  getTeachers,
  getTestimonials,
} from '@/services/api/school'

// GSAP animations
const { slideUp, stagger, scrollTriggerFadeIn } = useGSAP()

// Data
const programs = ref([])
const activities = ref([])
const teachers = ref([])
const testimonials = ref([])
const loading = ref(true)
const fallbackImage = '/images/school-facade.png'
const defaultTestimonials = [
  {
    id: 1,
    role: 'Parent',
    content: 'Une école rassurante, bien structurée et très attentive à chaque élève. Nous avons vu une vraie progression et une grande sérénité au quotidien.',
    score: 4.7,
    accent: 'border-primary-500/80 bg-primary-50/80 text-primary-900',
    label: 'Suivi pédagogique',
  },
  {
    id: 2,
    role: 'Étudiant',
    content: 'Le cadre est sérieux, l’encadrement est présent, et l’ambiance de travail est excellente. La dynamique est motivante et concrète.',
    score: 4.5,
    accent: 'border-sky-500/80 bg-sky-50/80 text-sky-900',
    label: 'Cadre motivant',
  },
  {
    id: 3,
    role: 'Parent',
    content: 'Le niveau d’organisation et le suivi pédagogique sont remarquables. L’équipe donne confiance et accompagne chaque enfant avec sérieux.',
    score: 4.8,
    accent: 'border-emerald-500/80 bg-emerald-50/80 text-emerald-900',
    label: 'Accompagnement sérieux',
  },
]

const displayedTestimonials = computed(() => testimonials.value.length > 0 ? testimonials.value : defaultTestimonials)

// About timeline
const aboutTimeline = [
  {
    id: 1,
    year: '1997',
    icon: 'school',
    period: 'Création de l’établissement',
    title: 'Une école ambitieuse voit le jour',
    description: 'L’aventure commence avec une vision claire : offrir une éducation de qualité, humaine et exigeante.',
    items: ['Projet éducatif structuré', 'Engagement du staff', 'Première dynamique scolaire'],
  },
  {
    id: 2,
    year: '2005',
    icon: 'graduation',
    period: 'Expansion pédagogique',
    title: 'Une pédagogie en expansion',
    description: 'Des générations d\'élèves formées, encadrées et préparées à réussir dans un monde en évolution.',
    items: ['Taux de réussite élevé', 'Reconnaissance académique', 'Développement des programmes'],
  },
  {
    id: 3,
    year: '2026',
    icon: 'star',
    period: 'École du futur',
    title: 'Enseignement moderne',
    description: 'Outils numériques, pédagogie innovante et environnement scolaire pensé pour la réussite de chaque élève.',
    items: ['Infrastructure moderne', 'Salles informatiques', 'Plateforme e-learning', '100% connectivité'],
  },
]

// School life categories
const schoolLifeCategories = [
  { id: 1, title: 'Sports', icon: '�', color: 'primary' },
  { id: 2, title: 'Culture', icon: '', color: 'info' },
  { id: 3, title: 'Science', icon: '', color: 'success' },
  { id: 4, title: 'Clubs', icon: '', color: 'warning' },
  { id: 5, title: 'Voyages', icon: '', color: 'error' },
  { id: 6, title: 'Activités', icon: '️', color: 'info' },
]

// Statistics
const stats = computed(() => [
  { id: 1, icon: '', value: 500, label: 'Étudiants', suffix: '+' },
  { id: 2, icon: '', value: 25, label: 'Enseignants' },
  { id: 3, icon: '️', value: 1200, label: 'Diplômés', suffix: '+' },
  { id: 4, icon: '', value: 25, label: 'Années', suffix: '+' },
])

const getProgramMeta = (name = '') => {
  const normalized = name.toLowerCase()

  if (normalized.includes('matern')) {
    return {
      icon: '',
      level: 'Maternelle',
      cardClass: 'bg-amber-50 border-amber-200',
      badgeClass: 'bg-amber-100 text-amber-700',
    }
  }

  if (normalized.includes('primaire')) {
    return {
      icon: '',
      level: 'Primaire',
      cardClass: 'bg-sky-50 border-sky-200',
      badgeClass: 'bg-sky-100 text-sky-700',
    }
  }

  if (normalized.includes('collège') || normalized.includes('college')) {
    return {
      icon: '',
      level: 'Collège',
      cardClass: 'bg-emerald-50 border-emerald-200',
      badgeClass: 'bg-emerald-100 text-emerald-700',
    }
  }

  if (normalized.includes('lycée') || normalized.includes('lycee') || normalized.includes('lyce')) {
    return {
      icon: '',
      level: 'Lycée',
      cardClass: 'bg-violet-50 border-violet-200',
      badgeClass: 'bg-violet-100 text-violet-700',
    }
  }

  return {
    icon: '',
    level: 'Programme',
    cardClass: 'bg-primary-50 border-primary-200',
    badgeClass: 'bg-primary-100 text-primary-700',
  }
}

// Fetch data
const fetchData = async () => {
  try {
    loading.value = true

    // Fetch all data in parallel
    const [programsRes, activitiesRes, teachersRes, testimonialsRes] =
      await Promise.all([
        getPrograms(),
        getFeaturedActivities(),
        getTeachers(),
        getTestimonials(),
      ])

    programs.value = programsRes.data.data || []
    activities.value = activitiesRes.data.data || []
    teachers.value = teachersRes.data.data || []
    testimonials.value = testimonialsRes.data.data || []
  } catch (error) {
    console.error('Error fetching homepage data:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchData()

  // Animate sections on mount
  setTimeout(() => {
    const cards = document.querySelectorAll('.program-card, .activity-card, .teacher-card')
    if (cards.length > 0) {
      stagger(cards, 0.6, 0.1)
    }

    // Animate hero magazine cards
    const heroCards = document.querySelectorAll('.hero-extra-card')
    if (heroCards.length > 0) {
      stagger(heroCards, 0.6, 0.08)
    }

    const heroTestimonial = document.querySelectorAll('.hero-extra-card blockquote')
    if (heroTestimonial.length > 0) {
      slideUp(heroTestimonial[0], 0.6)
    }
  }, 200)
})
</script>

<template>
  <!-- Hero Section -->
  <Hero
    logo="/images/logo-school-3.png"
    backgroundImage="/images/facade.png"
  />

  <!-- About Section -->
  <Section
    title="À propos"
    subtitle="Un cadre pédagogique moderne, rassurant et pensé pour l'épanouissement de chaque élève"
  >
    <div class="grid grid-cols-1 gap-10 lg:grid-cols-[1.05fr_0.95fr] items-center">
      <div class="space-y-6">
        <div class="inline-flex items-center gap-2 rounded-full border border-primary-200 bg-primary-50 px-4 py-2 text-sm font-semibold text-primary-700">
          <span>️</span>
          <span>Éducation de qualité • Bien-être • Réussite</span>
        </div>

        <p class="text-lg leading-8 text-gray-700">
          Depuis 1997, La nouvelle institution accompagne les enfants et adolescents dans leur parcours
          scolaire avec un encadrement de proximité, des méthodes actives et un engagement fort pour la
          réussite.
        </p>

        <div class="flex flex-wrap gap-3">
          <Badge label="Maternelle" />
          <Badge label="Primaire" />
          <Badge label="Collège" />
          <Badge label="Lycée" />
        </div>

        <div class="grid gap-4 md:grid-cols-3">
          <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
            <p class="text-2xl font-semibold text-gray-900">500+</p>
            <p class="text-sm text-gray-600">Élèves accompagnés</p>
          </div>
          <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
            <p class="text-2xl font-semibold text-gray-900">25+</p>
            <p class="text-sm text-gray-600">Années d'expérience</p>
          </div>
          <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
            <p class="text-2xl font-semibold text-gray-900">100%</p>
            <p class="text-sm text-gray-600">Accompagnement personnalisé</p>
          </div>
        </div>
      </div>

      <div class="rounded-[32px] border border-gray-200 bg-white p-3 shadow-large">
        <img
          src="/images/facade.png"
          alt="Présentation de l'établissement La nouvelle institution"
          class="h-[420px] w-full rounded-[24px] object-cover"
        />
      </div>
    </div>
  </Section>

  <Section title="Notre Histoire" subtitle="Plus de 25 ans d'excellence éducative">
    <Timeline :timelineItems="aboutTimeline" />
  </Section>

  <!-- Academic Programs Section -->
  <Section
    title="Programmes Académiques"
    subtitle="Des parcours scolaires structurés, modernes et adaptés à chaque étape"
  >
    <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] items-start">
      <div class="academic-feature-panel rounded-[28px] border border-primary-100 bg-gradient-to-br from-primary-50 via-white to-amber-50 p-8 shadow-large">
        <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 text-sm font-semibold text-primary-700 shadow-sm">
          <span></span>
          <span>Notre offre pédagogique</span>
        </div>

        <h3 class="text-3xl font-bold text-gray-900 mb-3">
          Un parcours clair de la maternelle au lycée
        </h3>

        <p class="max-w-2xl text-base leading-7 text-gray-700 mb-6">
          Chaque niveau de formation s’appuie sur un cadre rigoureux, une pédagogie active et un suivi
          attentif pour accompagner chaque élève vers la réussite.
        </p>

        <div class="grid gap-3 sm:grid-cols-3 mb-6">
          <div class="rounded-2xl bg-white p-4 shadow-soft border border-gray-200">
            <p class="text-2xl font-bold text-gray-900">4</p>
            <p class="text-sm text-gray-600">niveaux scolaires</p>
          </div>
          <div class="rounded-2xl bg-white p-4 shadow-soft border border-gray-200">
            <p class="text-2xl font-bold text-gray-900">100%</p>
            <p class="text-sm text-gray-600">suivi personnalisé</p>
          </div>
          <div class="rounded-2xl bg-white p-4 shadow-soft border border-gray-200">
            <p class="text-2xl font-bold text-gray-900">25+</p>
            <p class="text-sm text-gray-600">années d’expérience</p>
          </div>
        </div>

        <Button
          size="lg"
          variant="outline"
          label="Voir tous les programmes"
          @click="$router.push('/programmes')"
        />
      </div>

      <div class="space-y-4">
        <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-large">
          <div class="mb-5 flex items-center justify-between">
            <div>
              <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary-600">Excellence</p>
              <h4 class="mt-1 text-2xl font-bold text-gray-900">Une pédagogie de confiance</h4>
            </div>
            <div class="rounded-full bg-primary-50 px-3 py-1 text-sm font-semibold text-primary-700">Depuis 1997</div>
          </div>

          <div class="grid gap-3 sm:grid-cols-2">
            <div class="rounded-2xl bg-gray-50 p-4">
              <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">01</p>
              <p class="mt-2 text-sm font-semibold text-gray-900">Apprentissage progressif</p>
            </div>
            <div class="rounded-2xl bg-gray-50 p-4">
              <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">02</p>
              <p class="mt-2 text-sm font-semibold text-gray-900">Encadrement personnalisé</p>
            </div>
            <div class="rounded-2xl bg-gray-50 p-4 sm:col-span-2">
              <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">03</p>
              <p class="mt-2 text-sm font-semibold text-gray-900">Excellence durable</p>
              <p class="mt-2 text-sm text-gray-600">Des méthodes modernes et un environnement propice à la confiance, à l’ambition et à l’épanouissement.</p>
            </div>
          </div>

          <div class="mt-5 rounded-2xl border border-primary-100 bg-primary-50 p-4">
            <p class="text-sm leading-6 text-gray-700">
              “Une école où les enfants grandissent avec confiance, discipline et ambition.”
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <Card
        v-for="program in programs.slice(0, 4)"
        :key="program.id"
        class="program-card h-full"
        variant="outlined"
        :title="program.name"
        :description="program.description"
        :hoverable="true"
        :badge="getProgramMeta(program.name).level"
        :badgeClass="getProgramMeta(program.name).badgeClass"
        :customClass="getProgramMeta(program.name).cardClass"
      >
        <div class="mb-4 flex items-center gap-2 text-sm font-semibold text-gray-700">
          <span class="text-lg">{{ getProgramMeta(program.name).icon }}</span>
          <span>{{ getProgramMeta(program.name).level }}</span>
        </div>

        <template #footer>
          <Button
            size="sm"
            variant="ghost"
            label="Détails"
            @click="$router.push(`/programmes/${program.id}`)"
          />
        </template>
      </Card>
    </div>
  </Section>

  <!-- Testimonials Section -->
  <Section
    title="Témoignages"
    subtitle="Retours authentiques de nos familles et élèves"
  >
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <Card
        v-for="testimonial in displayedTestimonials.slice(0, 3)"
        :key="testimonial.id"
        class="testimonial-card"
        :hoverable="true"
        variant="outlined"
        :customClass="testimonial.accent"
      >
        <div class="testimonial-top mb-6 sm:mb-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <p class="text-xs uppercase tracking-[0.28em] text-orange-500">{{ testimonial.role || 'Parent' }}</p>
            <p class="mt-2 text-sm font-semibold text-slate-900">{{ testimonial.label }}</p>
          </div>
          <div class="testimonial-score-chip inline-flex items-center gap-2 rounded-full bg-orange-50 px-3 py-1 text-sm font-semibold text-orange-700 shadow-sm">
            <span class="text-orange-500">★</span>
            <span>{{ testimonial.score }}/5</span>
          </div>
        </div>
        <div class="testimonial-quote mt-6">
          <p class="text-base leading-8 text-slate-800">“{{ testimonial.content }}”</p>
        </div>
        <div class="testimonial-meta mt-6 flex items-center justify-between text-sm text-slate-500">
          <span class="italic">Avis réel</span>
          <span class="text-xs uppercase tracking-[0.18em] text-slate-400">Évaluation honnête</span>
        </div>
      </Card>
    </div>
  </Section>

  <!-- Call to Action Section -->
  <Section
    title="Rejoignez-nous"
    subtitle="Passez à l'étape suivante et rejoignez une école tournée vers l'excellence"
  >
    <div class="cta-panel mx-auto flex max-w-5xl flex-col gap-8 rounded-[32px] border border-primary-100/40 bg-white shadow-soft p-10 lg:flex-row lg:items-center lg:justify-between">
      <div class="space-y-4 text-center text-slate-900 lg:text-left">
        <p class="text-sm uppercase tracking-[0.24em] text-primary-600">Invitation spéciale</p>
        <h3 class="text-3xl font-semibold text-slate-950">Un accompagnement scolaire conçu pour la réussite</h3>
        <p class="max-w-2xl text-sm leading-7 text-slate-600">
          Rejoignez une communauté éducative engagée, où chaque élève bénéficie d’un suivi personnalisé et d’un vrai parcours de progression.
        </p>
      </div>

      <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
        <div>
          <Button
            size="lg"
            variant="primary"
            label="Demande d'admission"
            @click="$router.push('/admissions')"
            customClass="w-full sm:min-w-[220px] bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 shadow-large"
          />
          <p class="mt-3 text-xs text-slate-500">Place limitée, admission rapide recommandée.</p>
        </div>
      </div>
    </div>
  </Section>
</template>

<style scoped>
.program-card,
.activity-card,
.teacher-card {
  animation: slideUp 0.6s ease-out both;
}

.academic-feature-panel {
  position: relative;
}

.academic-feature-panel::after {
  content: '';
  position: absolute;
  inset: auto -10px -10px auto;
  width: 120px;
  height: 120px;
  border-radius: 9999px;
  background: radial-gradient(circle, rgba(245, 158, 11, 0.24), rgba(245, 158, 11, 0));
  pointer-events: none;
}

  .testimonial-card {
    min-height: auto;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 2.3rem 2.2rem 2.2rem;
    border: 1px solid rgba(148, 163, 184, 0.12);
    border-radius: 30px;
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(20px);
    box-shadow: 0 20px 46px rgba(15, 23, 42, 0.07);
    transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
  }

  .testimonial-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 26px 70px rgba(15, 23, 42, 0.1);
    background: rgba(255, 255, 255, 0.95);
  }

  .testimonial-quote {
    position: relative;
    line-height: 1.85;
    letter-spacing: 0.01em;
    color: #334155;
    margin-top: 0.75rem;
    font-size: 1.02rem;
    padding-left: 0.7rem;
  }

  .testimonial-quote::before {
    content: '“';
    position: absolute;
    top: -0.8rem;
    left: 0;
    font-size: 3.2rem;
    line-height: 1;
    color: rgba(245, 124, 0, 0.2);
    font-weight: 700;
  }

  .testimonial-meta {
    padding-top: 1rem;
  }

  .testimonial-top {
    padding-bottom: 1.25rem;
    border-bottom: 1px solid rgba(148, 163, 184, 0.12);
  }

  .testimonial-chip {
    background: rgba(248, 250, 252, 0.95);
    color: #0f172a;
  }

  .testimonial-score-chip {
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
    padding: 0.65rem 0.95rem;
  }

  .cta-panel {
    width: 100%;
  }

  @media (max-width: 768px) {
    .testimonial-top {
      flex-direction: column;
      align-items: flex-start;
      gap: 1rem;
    }

    .testimonial-meta {
      flex-direction: column;
      align-items: flex-start;
      gap: 0.85rem;
    }

    .testimonial-card {
      padding: 2rem 1.6rem;
    }

    .cta-panel {
      padding: 2rem 1.5rem;
    }
  }

  @media (max-width: 560px) {
    .testimonial-card {
      padding: 1.75rem 1.4rem;
    }

    .testimonial-quote {
      font-size: 0.96rem;
    }
  }
</style>

