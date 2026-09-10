<template>
  <div class="overflow-hidden bg-[#fbfcfe] text-slate-900">
    <section class="relative px-5 pb-12 pt-14 sm:px-8 sm:pt-20 lg:pb-16 lg:pt-24">
      <div class="pointer-events-none absolute left-[7%] top-20 hidden grid-cols-4 gap-2 opacity-60 sm:grid">
        <span v-for="dot in 12" :key="dot" class="h-1 w-1 rounded-full bg-orange-300"></span>
      </div>
      <div class="pointer-events-none absolute -right-20 top-16 h-48 w-48 rounded-full border border-orange-200/70 sm:h-64 sm:w-64"></div>
      <div class="pointer-events-none absolute -right-8 top-28 h-24 w-24 rounded-full border border-orange-300/80 sm:h-28 sm:w-28"></div>
      <div class="relative mx-auto max-w-4xl text-center">
        <p class="text-xs font-bold uppercase tracking-[0.34em] text-primary-600">Actualités</p>
        <h1 class="mx-auto mt-5 max-w-3xl text-3xl font-extrabold leading-tight tracking-tight text-slate-900 sm:text-4xl lg:text-5xl">
          Les dernières nouvelles de<br class="hidden sm:block" /> La Nouvelle Institution
        </h1>
        <p class="mx-auto mt-5 max-w-xl text-sm leading-7 text-slate-500 sm:text-base">
          Découvrez les événements, annonces et moments forts<br class="hidden sm:block" /> de notre établissement.
        </p>
        <div class="mx-auto mt-7 h-1 w-10 rounded-full bg-primary-500"></div>
      </div>
    </section>

    <main class="mx-auto max-w-7xl px-5 pb-16 sm:px-8 lg:pb-24">
      <div v-if="loading" class="rounded-[20px] border border-slate-200 bg-white p-12 text-center text-sm text-slate-500 shadow-sm">Chargement des actualités...</div>
      <div v-else-if="!actualities.length" class="rounded-[20px] border border-dashed border-slate-300 bg-white p-12 text-center text-sm text-slate-500 shadow-sm">Les prochaines actualités seront bientôt disponibles.</div>

      <template v-else>
        <article class="group grid min-w-0 overflow-hidden rounded-[20px] border border-slate-200/80 bg-white shadow-[0_18px_50px_rgba(15,23,42,0.08)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_24px_60px_rgba(15,23,42,0.12)] lg:grid-cols-[48%_52%]">
          <div class="flex min-h-[19rem] min-w-0 items-center justify-center bg-slate-100 p-5 sm:min-h-[27rem] sm:p-8 lg:min-h-[clamp(32rem,68vh,42rem)] lg:p-10">
            <img :src="featured.image_url || '/images/school-front.jpg'" :alt="featured.title" class="max-h-full w-full object-contain transition duration-500 group-hover:scale-[1.015]" />
          </div>
          <div class="flex min-w-0 flex-col justify-center p-7 sm:p-10 lg:p-16">
            <div class="flex flex-wrap items-center gap-3">
              <span v-if="featured.is_pinned" class="rounded-full border border-primary-400 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-primary-700">À la une</span>
              <span v-else class="rounded-full border border-slate-200 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">{{ featured.category }}</span>
            </div>
            <h2 class="mt-5 text-2xl font-bold leading-tight text-slate-900 sm:text-3xl">{{ featured.title }}</h2>
            <div class="mt-5 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs font-medium text-slate-500">
              <span class="inline-flex items-center gap-2"><CalendarDays :size="15" stroke-width="1.8" />{{ formatDateOnly(featured.created_at) }}</span>
              <span class="hidden h-4 w-px bg-slate-200 sm:block"></span>
              <span class="inline-flex items-center gap-2"><Newspaper :size="15" stroke-width="1.8" />{{ featured.category }}</span>
            </div>
            <p v-if="featured.description" class="mt-6 max-w-xl text-sm leading-7 text-slate-600">{{ featured.description }}</p>
            <button type="button" class="mt-8 inline-flex w-fit items-center gap-2 rounded-lg bg-primary-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-600" @click="openArticle(featured)">
              Lire l’article <ArrowRight :size="17" stroke-width="2.2" />
            </button>
          </div>
        </article>

        <section id="toutes-les-actualites" class="mt-16 scroll-mt-24">
          <div class="flex flex-col gap-5 border-b border-slate-200 pb-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
              <h2 class="text-2xl font-bold text-slate-900">Toutes les actualités</h2>
              <div class="mt-3 h-1 w-9 rounded-full bg-primary-500"></div>
            </div>
            <div class="-mx-1 flex gap-2 overflow-x-auto px-1 pb-1 scrollbar-none">
              <button v-for="category in categories" :key="category" type="button" class="shrink-0 rounded-full border px-4 py-2 text-xs font-semibold transition" :class="activeCategory === category ? 'border-primary-500 bg-primary-500 text-white shadow-sm' : 'border-slate-200 bg-white text-slate-600 hover:border-primary-300 hover:text-primary-700'" @click="activeCategory = category">
                {{ category }}
              </button>
            </div>
          </div>

          <div v-if="filteredActualities.length" class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <article v-for="actuality in filteredActualities" :key="actuality.id" class="group overflow-hidden rounded-[18px] border border-slate-200/80 bg-white shadow-[0_10px_30px_rgba(15,23,42,0.06)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_38px_rgba(15,23,42,0.1)]">
              <div class="flex aspect-[4/3] items-center justify-center overflow-hidden bg-slate-100 p-5">
                <img :src="actuality.image_url || '/images/school-front.jpg'" :alt="actuality.title" class="h-full w-full object-contain transition duration-500 group-hover:scale-[1.025]" loading="lazy" />
              </div>
              <div class="p-5">
                <span class="inline-flex rounded-full bg-orange-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-primary-700">{{ actuality.category }}</span>
                <h3 class="mt-4 line-clamp-2 text-lg font-bold leading-snug text-slate-900">{{ actuality.title }}</h3>
                <p class="mt-3 inline-flex items-center gap-2 text-xs font-medium text-slate-500"><CalendarDays :size="14" stroke-width="1.8" />{{ formatDateOnly(actuality.created_at) }}</p>
                <p v-if="actuality.description" class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600">{{ actuality.description }}</p>
                <button type="button" class="mt-5 inline-flex items-center gap-2 text-xs font-bold text-primary-600 transition hover:text-primary-800" @click="openArticle(actuality)">Lire la suite <ArrowRight :size="15" stroke-width="2.2" /></button>
              </div>
            </article>
          </div>
          <p v-else class="mt-8 rounded-2xl border border-dashed border-slate-200 bg-white p-8 text-center text-sm text-slate-500">Aucune autre actualité dans cette catégorie.</p>
        </section>

        <section class="mt-16 grid gap-7 rounded-[20px] border border-orange-100 bg-[#fff8f0] p-6 sm:p-8 lg:grid-cols-[1fr_auto] lg:items-center lg:p-10">
          <div class="flex items-start gap-5">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-primary-500 text-white shadow-sm"><Bell :size="27" stroke-width="1.7" /></div>
            <div>
              <h2 class="text-xl font-bold text-slate-900">Ne manquez rien de notre actualité !</h2>
              <p class="mt-2 max-w-xl text-sm leading-6 text-slate-600">Suivez-nous sur nos réseaux sociaux pour rester informé de toutes nos nouveautés.</p>
              <a href="https://web.facebook.com/profile.php?id=100056328531139&sk=photos" target="_blank" rel="noopener" class="mt-5 inline-flex items-center gap-2 rounded-lg bg-primary-500 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-primary-600">Nous suivre <ArrowRight :size="15" /></a>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-3 sm:gap-4">
            <a href="https://web.facebook.com/profile.php?id=100056328531139&sk=photos" target="_blank" rel="noopener" class="flex min-w-[5.5rem] flex-col items-center gap-2 rounded-xl bg-white px-3 py-4 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"><Facebook :size="21" class="text-[#1877f2]" /><span class="text-xs font-bold text-slate-800">Facebook</span><span class="hidden text-[10px] text-slate-500 sm:block">La nouvelle institution</span></a>
            <a href="https://www.instagram.com/la_nouvelleinstitution" target="_blank" rel="noopener" class="flex min-w-[5.5rem] flex-col items-center gap-2 rounded-xl bg-white px-3 py-4 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"><Instagram :size="21" class="text-[#e4405f]" /><span class="text-xs font-bold text-slate-800">Instagram</span><span class="hidden text-[10px] text-slate-500 sm:block">@lanouvelleinstitution</span></a>
          </div>
        </section>
      </template>
    </main>

    <Teleport to="body">
      <Transition name="article-modal">
        <div v-if="selectedArticle" tabindex="-1" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4 backdrop-blur-sm sm:p-6" role="dialog" aria-modal="true" :aria-label="selectedArticle.title" @click.self="closeArticle" @keydown.esc="closeArticle">
          <article class="relative grid max-h-[92vh] w-full max-w-5xl overflow-y-auto rounded-2xl bg-white shadow-2xl lg:grid-cols-[42%_58%]">
            <button type="button" aria-label="Fermer l’article" class="absolute right-4 top-4 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-white/90 text-xl text-slate-600 shadow-sm transition hover:bg-white hover:text-slate-900" @click="closeArticle">&times;</button>
            <div class="flex min-h-[22rem] items-center justify-center bg-slate-100 p-6 sm:min-h-[30rem] lg:min-h-[36rem] lg:p-10">
              <img :src="selectedArticle.image_url || '/images/school-front.jpg'" :alt="selectedArticle.title" class="max-h-[34rem] w-full object-contain" />
            </div>
            <div class="flex flex-col justify-center p-7 sm:p-10 lg:p-14">
              <div class="flex flex-wrap items-center gap-3">
                <span class="rounded-full bg-orange-50 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-primary-700">{{ selectedArticle.category }}</span>
                <span v-if="selectedArticle.is_pinned" class="rounded-full border border-primary-300 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-primary-700">À la une</span>
              </div>
              <h2 class="mt-5 text-2xl font-bold leading-tight text-slate-900 sm:text-3xl">{{ selectedArticle.title }}</h2>
              <p class="mt-5 inline-flex items-center gap-2 text-sm font-medium text-slate-500"><CalendarDays :size="16" stroke-width="1.8" />Publié le {{ formatPublishedAt(selectedArticle.created_at) }}</p>
              <div class="mt-7 h-px w-full bg-slate-100"></div>
              <p class="mt-7 whitespace-pre-line text-sm leading-7 text-slate-600">{{ selectedArticle.description || 'Aucun contenu supplémentaire pour cette actualité.' }}</p>
            </div>
          </article>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue'
import { ArrowRight, Bell, CalendarDays, Facebook, Instagram, Newspaper } from 'lucide-vue-next'
import { getActualities } from '@/services/api/school'

const actualities = ref([])
const loading = ref(true)
const activeCategory = ref('Toutes')
const selectedArticle = ref(null)
const categories = ['Toutes', 'Événements', 'Annonces', 'Vie scolaire', 'Activités']

const formatDateOnly = (value) => {
  if (!value) return 'Date inconnue'
  const date = new Date(value)
  if (Number.isNaN(date.getTime())) return 'Date inconnue'
  return new Intl.DateTimeFormat('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }).format(date)
}

const formatPublishedAt = (value) => {
  if (!value) return 'date inconnue'
  const date = new Date(value)
  if (Number.isNaN(date.getTime())) return 'date inconnue'
  return new Intl.DateTimeFormat('fr-FR', { dateStyle: 'medium', timeStyle: 'short' }).format(date)
}

const enrichedActualities = computed(() => actualities.value.map((actuality) => ({ ...actuality, category: actuality.category || 'Annonces' })))
const featured = computed(() => enrichedActualities.value.find((actuality) => actuality.is_pinned) || enrichedActualities.value[0] || {})
const filteredActualities = computed(() => enrichedActualities.value.filter((actuality) => {
  if (activeCategory.value === 'Toutes') {
    return true
  }
  return actuality.category === activeCategory.value
}))

const openArticle = (actuality) => {
  selectedArticle.value = actuality
}

const closeArticle = () => {
  selectedArticle.value = null
}

watch(selectedArticle, (article) => {
  document.body.style.overflow = article ? 'hidden' : ''
})

onMounted(async () => {
  try { actualities.value = await getActualities() }
  catch (error) { console.warn('Unable to load actualities', error) }
  finally { loading.value = false }
})

onBeforeUnmount(() => {
  document.body.style.overflow = ''
})
</script>
