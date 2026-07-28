<script setup>
import { ref, onMounted, computed } from 'vue'
import {
  Hero,
  Section,
  Card,
  Button,
  StatsCounter,
  GalleryGrid,
  Timeline,
  Badge,
} from '@/components'
import { useGSAP } from '@/useGSAP'
import {
  getPrograms,
  getFeaturedActivities,
  getTeachers,
  getGalleryCategories,
  getGalleryImages,
  getTestimonials,
} from '@/services/api/school'

// GSAP animations
const { slideUp, stagger, scrollTriggerFadeIn } = useGSAP()

// Data
const programs = ref([])
const activities = ref([])
const teachers = ref([])
const galleryCategories = ref([])
const galleryImages = ref([])
const testimonials = ref([])
const loading = ref(true)

// About timeline
const aboutTimeline = [
  {
    id: 1,
    year: '1997',
    icon: '🏫',
    title: 'Création de l\'établissement',
    description: 'Fondation de La nouvelle institution avec une vision d\'excellence éducative',
    items: ['5 classes', '50 étudiants', 'Équipe pédagogique initiale'],
  },
  {
    id: 2,
    year: '2005',
    icon: '🎓',
    title: 'Plus de 25 ans d\'expérience',
    description: 'Des générations d\'élèves formées et diplômées',
    items: ['Taux de réussite élevé', 'Reconnaissance académique', 'Développement des programmes'],
  },
  {
    id: 3,
    year: '2024',
    icon: '📚',
    title: 'Enseignement moderne',
    description: 'Outils numériques, équipe pédagogique engagée',
    items: ['Infrastructure moderne', 'Salles informatiques', 'Plateforme e-learning', '100% connectivité'],
  },
]

// School life categories
const schoolLifeCategories = [
  { id: 1, title: 'Sports', icon: '⚽', color: 'primary' },
  { id: 2, title: 'Culture', icon: '🎭', color: 'info' },
  { id: 3, title: 'Science', icon: '🔬', color: 'success' },
  { id: 4, title: 'Clubs', icon: '👥', color: 'warning' },
  { id: 5, title: 'Voyages', icon: '✈️', color: 'error' },
  { id: 6, title: 'Activités', icon: '🎨', color: 'info' },
]

// Statistics
const stats = computed(() => [
  { id: 1, icon: '👥', value: 500, label: 'Étudiants', suffix: '+' },
  { id: 2, icon: '👨‍🏫', value: 25, label: 'Enseignants' },
  { id: 3, icon: '🎓', value: 1200, label: 'Diplômés', suffix: '+' },
  { id: 4, icon: '📚', value: 25, label: 'Années', suffix: '+' },
])

// Fetch data
const fetchData = async () => {
  try {
    loading.value = true

    // Fetch all data in parallel
    const [programsRes, activitiesRes, teachersRes, galleryCatsRes, testimonialsRes] =
      await Promise.all([
        getPrograms(),
        getFeaturedActivities(),
        getTeachers(),
        getGalleryCategories(),
        getTestimonials(),
      ])

    programs.value = programsRes.data.data || []
    activities.value = activitiesRes.data.data || []
    teachers.value = teachersRes.data.data || []
    galleryCategories.value = galleryCatsRes.data.data || []
    testimonials.value = testimonialsRes.data.data || []

    // Fetch gallery images for first category
    if (galleryCategories.value.length > 0) {
      const imagesRes = await getGalleryImages(galleryCategories.value[0].id)
      galleryImages.value = imagesRes.data.data || []
    }
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
  }, 100)
})
</script>

<template>
  <!-- Hero Section -->
  <Hero
    title="La nouvelle institution"
    subtitle="Depuis 1997"
    description="Excellence en éducation • Enseignement moderne • Équipe engagée"
    logo="/images/logo-school-3.png"
    backgroundImage="/images/school-front-3.jpg"
    :showScrollIndicator="true"
  >
    <template #actions>
      <Button size="lg" label="Découvrir nos programmes" @click="$router.push('/programmes')" />
      <Button
        size="lg"
        variant="outline"
        label="Nous contacter"
        @click="$router.push('/contact')"
      />
    </template>
  </Hero>

  <!-- About Section with Timeline -->
  <Section title="Notre Histoire" subtitle="Plus de 25 ans d'excellence éducative">
    <Timeline :timelineItems="aboutTimeline" />
  </Section>

  <!-- Academic Programs Section -->
  <Section
    title="Programmes Académiques"
    subtitle="Explorez nos cursus d'enseignement modernes et complets"
  >
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      <Card
        v-for="program in programs.slice(0, 4)"
        :key="program.id"
        class="program-card"
        :title="program.name"
        :description="program.description"
        :hoverable="true"
        badge="Programme"
      >
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

  <!-- School Life Section -->
  <Section title="Vie Scolaire" subtitle="Découvrez toutes nos activités et clubs" :dark="true">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <Card
        v-for="category in schoolLifeCategories"
        :key="category.id"
        :title="category.title"
        :badge="category.icon"
        :hoverable="true"
        :clickable="true"
      >
        <p class="text-sm text-gray-600">Explorez notre vie scolaire riche et dynamique</p>
      </Card>
    </div>
  </Section>

  <!-- Latest Activities Section -->
  <Section
    title="Dernières Activités"
    subtitle="Suivez les événements récents de notre établissement"
  >
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <Card
        v-for="activity in activities.slice(0, 6)"
        :key="activity.id"
        class="activity-card"
        :title="activity.title"
        :description="activity.description"
        :image="activity.image_url || 'https://via.placeholder.com/400x300'"
        :hoverable="true"
      >
        <div class="flex items-center gap-2 text-sm text-gray-500">
          <span>📅</span>
          <span>{{ new Date(activity.activity_date).toLocaleDateString('fr-FR') }}</span>
        </div>
        <template #footer>
          <Button
            size="sm"
            variant="ghost"
            label="Voir plus sur Facebook"
            @click="window.open('https://facebook.com/nouvelle-institution')"
          />
        </template>
      </Card>
    </div>
  </Section>

  <!-- Teachers Section -->
  <Section
    title="Notre Équipe Pédagogique"
    subtitle="Enseignants expérimentés et passionnés"
    :dark="true"
  >
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <Card
        v-for="teacher in teachers.slice(0, 6)"
        :key="teacher.id"
        class="teacher-card"
        :title="teacher.name"
        :description="teacher.specialization"
        :image="teacher.photo_url || 'https://via.placeholder.com/400x300'"
        :hoverable="true"
        badge="Enseignant"
      />
    </div>
  </Section>

  <!-- Gallery Section -->
  <Section
    title="Galerie Photos"
    subtitle="Découvrez nos installations et événements"
  >
    <GalleryGrid
      v-if="galleryImages.length > 0"
      :items="galleryImages"
      :categories="galleryCategories.map((c) => c.name)"
    />
    <div v-else class="text-center py-12">
      <p class="text-gray-500">La galerie sera disponible prochainement</p>
    </div>
  </Section>

  <!-- Statistics Section -->
  <Section
    title="Nos Chiffres"
    subtitle="L'impact de La nouvelle institution"
    :dark="true"
  >
    <StatsCounter :stats="stats" />
  </Section>

  <!-- Testimonials Section -->
  <Section
    title="Témoignages"
    subtitle="Ce que disent nos étudiants et parents"
  >
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <Card
        v-for="testimonial in testimonials.slice(0, 3)"
        :key="testimonial.id"
        :title="testimonial.author"
        :description="testimonial.role || 'Parent'"
        :hoverable="true"
        variant="outlined"
      >
        <p class="italic text-gray-700 mb-4">{{ testimonial.content }}</p>
        <div class="flex gap-1">
          <span v-for="i in 5" :key="i">⭐</span>
        </div>
      </Card>
    </div>
  </Section>

  <!-- Call to Action Section -->
  <Section
    title="Rejoignez-nous"
    subtitle="Commencez une expérience éducative exceptionnelle"
    :dark="true"
  >
    <div class="flex flex-col md:flex-row gap-6 justify-center items-center">
      <Button
        size="lg"
        label="Demande d'admission"
        @click="$router.push('/admissions')"
      />
      <Button
        size="lg"
        variant="outline"
        label="Télécharger le prospectus"
      />
    </div>
  </Section>
</template>

<style scoped>
.program-card,
.activity-card,
.teacher-card {
  animation: slideUp 0.6s ease-out both;
}
</style>
