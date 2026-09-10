<template>
  <section class="mx-auto max-w-6xl space-y-7 text-sm">
    <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
      <div>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Actualités</h1>
        <p class="mt-2 text-sm text-slate-500">Gérez et publiez les actualités de l'établissement.</p>
      </div>
      <button type="button" class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-600" @click="openModal()">
        <Plus :size="17" stroke-width="2.5" /> Créer une actualité
      </button>
    </div>

    <div v-if="statusMessage" class="rounded-3xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">{{ statusMessage }}</div>

    <div v-if="loading" class="rounded-3xl border border-slate-200 bg-white p-10 text-center text-sm text-slate-500">Chargement des affiches...</div>
    <div v-else-if="!actualities.length" class="rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center text-sm text-slate-500">
      Aucune affiche pour le moment. Ajoutez la première sortie scolaire.
    </div>
    <div v-else class="relative">
      <div ref="actualitiesScroll" class="actualities-carousel flex snap-x snap-mandatory gap-5 overflow-x-auto px-1 pb-4 sm:px-2">
      <article v-for="actuality in actualities" :key="actuality.id" class="grid min-w-full snap-center overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-shadow hover:shadow-md lg:grid-cols-[42%_58%]">
        <div class="flex min-h-[22rem] items-center justify-center bg-slate-100 p-6 md:min-h-[30rem] lg:min-h-[32rem] lg:p-8">
          <img :src="actuality.image_url || '/images/school-front.jpg'" :alt="actuality.title" class="max-h-[36rem] w-full object-contain" />
        </div>
        <div class="flex min-w-0 flex-col justify-center gap-6 p-6 md:p-10 lg:p-12">
          <div class="flex flex-wrap items-center gap-3">
            <p class="text-xs font-bold uppercase tracking-[0.25em] text-primary-600">{{ actuality.category || 'Actualité' }}</p>
            <span v-if="actuality.is_pinned" class="inline-flex items-center gap-1.5 rounded-full border border-primary-200 bg-orange-50 px-3 py-1 text-xs font-semibold text-primary-700"><Pin :size="13" /> Épinglée</span>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700"><CheckCircle2 :size="13" /> {{ actuality.is_visible ? 'Visible' : 'Masquée' }}</span>
          </div>
          <div>
            <div class="min-w-0">
              <h2 class="text-2xl font-bold leading-tight text-slate-900 md:text-3xl">{{ actuality.title }}</h2>
            </div>
          </div>
          <div class="flex items-center gap-2 text-sm font-medium text-slate-500"><CalendarDays :size="17" /> {{ formatPublishedAt(actuality.created_at) }}</div>
          <p v-if="actuality.description" class="max-w-xl text-sm leading-7 text-slate-600">{{ actuality.description }}</p>
          <div class="grid gap-3 border-y border-slate-100 bg-slate-50/70 p-4 sm:grid-cols-2">
            <div class="flex items-center gap-3"><Eye :size="17" class="text-slate-500" /><span class="text-xs text-slate-500">Statut<br /><strong class="text-slate-700">{{ actuality.is_visible ? 'Visible sur le site' : 'Masquée du site' }}</strong></span></div>
            <div class="flex items-center gap-3"><Pin :size="17" class="text-slate-500" /><span class="text-xs text-slate-500">Épinglage<br /><strong class="text-slate-700">{{ actuality.is_pinned ? 'Oui' : 'Non' }}</strong></span></div>
          </div>
          <div class="flex flex-wrap gap-3">
            <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-amber-300 px-4 py-2.5 text-xs font-semibold text-amber-800 hover:bg-amber-50 disabled:cursor-not-allowed disabled:opacity-60" :disabled="pinningId === actuality.id" @click="togglePinned(actuality)"><Pin :size="15" /> {{ pinningId === actuality.id ? 'Mise à jour...' : actuality.is_pinned ? 'Désépingler' : 'Épingler' }}</button>
            <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50" @click="openModal(actuality)"><Pencil :size="15" /> Modifier</button>
            <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-red-300 px-4 py-2.5 text-xs font-semibold text-red-600 hover:bg-red-50" @click="removeActuality(actuality)"><Trash2 :size="15" /> Supprimer</button>
          </div>
        </div>
      </article>
      </div>
      <div v-if="actualities.length > 1" class="pointer-events-none absolute inset-y-0 left-0 right-0 flex items-center justify-between px-0.5 sm:px-1">
        <button type="button" aria-label="Actualité précédente" class="pointer-events-auto flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-lg transition hover:border-primary-300 hover:text-primary-600" @click="scrollActuality(-1)"><ChevronLeft :size="20" /></button>
        <button type="button" aria-label="Actualité suivante" class="pointer-events-auto flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-lg transition hover:border-primary-300 hover:text-primary-600" @click="scrollActuality(1)"><ChevronRight :size="20" /></button>
      </div>
      <p v-if="actualities.length > 1" class="mt-2 text-center text-xs font-medium text-slate-500">{{ actualities.length }} actualités</p>
    </div>

    <Modal v-model="modalOpen" :title="form.id ? 'Modifier l’affiche' : 'Nouvelle affiche'">
      <form class="space-y-4" @submit.prevent="save">
        <Input v-model="form.title" label="Titre" placeholder="Ex. Sortie scolaire à Ifrane" required />
        <label class="block text-sm font-semibold text-slate-900">
          Catégorie
          <select v-model="form.category" class="mt-2 block w-full rounded-[20px] border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-normal text-slate-700">
            <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
          </select>
        </label>
        <label class="block text-sm font-semibold text-slate-900">
          Affiche
          <input type="file" accept="image/*" :required="!form.id" class="mt-2 block w-full rounded-[20px] border border-slate-200 bg-slate-50 px-4 py-3" @change="handleFile" />
        </label>
        <label class="block text-sm font-semibold text-slate-900">
          Description (optionnelle)
          <textarea v-model="form.description" rows="3" class="mt-2 block w-full rounded-[20px] border border-slate-200 bg-slate-50 px-4 py-3 text-sm" placeholder="Informations complémentaires"></textarea>
        </label>
        <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
          <input v-model="form.is_visible" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-500" /> Visible sur le site
        </label>
        <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
          <input v-model="form.is_pinned" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-500" /> Épingler en haut des actualités
        </label>
        <div class="flex justify-end gap-2 pt-4">
          <button type="button" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700" @click="modalOpen = false">Annuler</button>
          <button type="submit" class="rounded-full bg-primary-500 px-4 py-2 text-sm font-semibold text-white disabled:opacity-60" :disabled="saving">{{ saving ? 'Enregistrement...' : 'Enregistrer' }}</button>
        </div>
      </form>
    </Modal>
  </section>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue'
import { CalendarDays, CheckCircle2, ChevronLeft, ChevronRight, Eye, Pencil, Pin, Plus, Trash2 } from 'lucide-vue-next'
import { Input, Modal } from '@/components/admin'
import { createAdminActuality, deleteAdminActuality, getAdminActualities, updateAdminActuality } from '@/services/api/admin'

const actualities = ref([])
const loading = ref(true)
const saving = ref(false)
const modalOpen = ref(false)
const statusMessage = ref('')
const pinningId = ref(null)
const actualitiesScroll = ref(null)
const categories = ['Événements', 'Annonces', 'Vie scolaire', 'Activités']
const form = reactive({ id: null, title: '', category: 'Annonces', description: '', image_file: null, is_visible: true, is_pinned: false })

const load = async () => {
  loading.value = true
  actualities.value = await getAdminActualities()
  loading.value = false
}

const openModal = (actuality = null) => {
  Object.assign(form, { id: actuality?.id || null, title: actuality?.title || '', category: actuality?.category || 'Annonces', description: actuality?.description || '', image_file: null, is_visible: actuality ? Boolean(actuality.is_visible) : true, is_pinned: actuality ? Boolean(actuality.is_pinned) : false })
  modalOpen.value = true
}

const handleFile = (event) => { form.image_file = event.target.files?.[0] || null }

const scrollActuality = (direction) => {
  actualitiesScroll.value?.scrollBy({ left: direction * actualitiesScroll.value.clientWidth, behavior: 'smooth' })
}

const formatPublishedAt = (value) => {
  if (!value) return 'date inconnue'
  const date = new Date(value)
  if (Number.isNaN(date.getTime())) return 'date inconnue'
  return new Intl.DateTimeFormat('fr-FR', { dateStyle: 'medium', timeStyle: 'short' }).format(date)
}

const togglePinned = async (actuality) => {
  pinningId.value = actuality.id
  const payload = new FormData()
  payload.append('is_pinned', actuality.is_pinned ? '0' : '1')
  try {
    const updated = await updateAdminActuality(actuality.id, payload)
    actualities.value = actualities.value.map((item) => item.id === updated.id ? updated : item)
    actualities.value.sort((first, second) => Number(second.is_pinned) - Number(first.is_pinned))
    statusMessage.value = updated.is_pinned ? 'Affiche épinglée en haut.' : 'Affiche désépinglée.'
  } catch (error) {
    console.warn('Actuality pin toggle error', error)
    statusMessage.value = 'Impossible de modifier l’épinglage.'
  } finally { pinningId.value = null }
}

const save = async () => {
  saving.value = true
  const payload = new FormData()
  payload.append('title', form.title)
  payload.append('category', form.category)
  payload.append('description', form.description || '')
  payload.append('is_visible', form.is_visible ? '1' : '0')
  payload.append('is_pinned', form.is_pinned ? '1' : '0')
  if (form.image_file) payload.append('image_file', form.image_file)
  try {
    const saved = form.id ? await updateAdminActuality(form.id, payload) : await createAdminActuality(payload)
    if (form.id) actualities.value = actualities.value.map((item) => item.id === saved.id ? saved : item)
    else actualities.value.unshift(saved)
    actualities.value.sort((first, second) => Number(second.is_pinned) - Number(first.is_pinned))
    statusMessage.value = form.id ? 'Affiche mise à jour.' : 'Affiche ajoutée.'
    modalOpen.value = false
  } catch (error) {
    console.warn('Actuality save error', error)
    statusMessage.value = 'Impossible de sauvegarder l’affiche.'
  } finally { saving.value = false }
}

const removeActuality = async (actuality) => {
  if (!confirm(`Supprimer l’affiche « ${actuality.title} » ?`)) return
  try {
    await deleteAdminActuality(actuality.id)
    actualities.value = actualities.value.filter((item) => item.id !== actuality.id)
    statusMessage.value = 'Affiche supprimée.'
  } catch (error) {
    console.warn('Actuality delete error', error)
    statusMessage.value = 'Impossible de supprimer l’affiche.'
  }
}

onMounted(load)
</script>

<style scoped>
.actualities-carousel {
  scrollbar-width: thin;
  scrollbar-color: rgb(249 115 22 / 0.85) rgb(241 245 249);
}

.actualities-carousel::-webkit-scrollbar {
  height: 7px;
}

.actualities-carousel::-webkit-scrollbar-track {
  border-radius: 999px;
  background: rgb(241 245 249);
}

.actualities-carousel::-webkit-scrollbar-thumb {
  border: 2px solid rgb(241 245 249);
  border-radius: 999px;
  background: rgb(249 115 22 / 0.85);
}
</style>
