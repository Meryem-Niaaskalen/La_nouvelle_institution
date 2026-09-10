<template>
  <section class="space-y-8 max-w-4xl mx-auto">
    <AdminPageHeader title="Galerie" subtitle="Gérez les catégories et les images de la galerie.">
      <template #actions>
        <button
          type="button"
          class="rounded-full bg-primary-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-600"
          @click="openCategoryModal()"
        >
          Nouvelle catégorie
        </button>
        <button
          type="button"
          class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300"
          @click="openImageModal()"
          :disabled="!selectedCategory"
        >
          Ajouter une image
        </button>
      </template>
    </AdminPageHeader>

    <div v-if="statusMessage" class="rounded-3xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
      {{ statusMessage }}
    </div>

    <div class="space-y-6">
      <section class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gradient-to-br from-primary-600 to-primary-400 text-white shadow-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <rect x="3" y="3" width="7" height="7" rx="1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></rect>
                <rect x="14" y="3" width="7" height="7" rx="1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></rect>
                <rect x="14" y="14" width="7" height="7" rx="1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></rect>
                <rect x="3" y="14" width="7" height="7" rx="1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></rect>
              </svg>
            </span>
            <div>
              <h2 class="text-2xl md:text-3xl font-bold leading-tight text-slate-900">Catégories
                <span class="ml-3 inline-block rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">{{ categories.length }} {{ categories.length === 1 ? 'catégorie' : 'catégories' }}</span>
              </h2>
              <p class="mt-1 text-sm text-slate-500">Sélectionnez une catégorie pour afficher ses images.</p>
            </div>
          </div>
        </div>
        <div class="mt-4 border-t border-slate-100" />

        <div class="mt-5">
          <!-- Mobile: horizontal scroll with snap -->
          <div class="relative" @mouseenter="isHovered = true" @mouseleave="isHovered = false">
            <div class="category-scroll overflow-x-auto pb-3" ref="categoriesScroll">
              <div class="inline-flex gap-2 min-w-max snap-x snap-mandatory whitespace-nowrap">
                <button
                  v-for="category in categories"
                  :key="category.id"
                  type="button"
                  class="min-w-[10rem] sm:min-w-[12rem] md:min-w-[14rem] snap-start rounded-3xl border p-3 text-left transition hover:border-primary-300 hover:bg-primary-50"
                  :class="selectedCategory?.id === category.id ? 'border-primary-500 bg-primary-50 ring-1 ring-primary-200' : 'border-slate-200 bg-white'"
                  @click="selectCategory(category)"
                  :ref="el => (categoryEls[category.id] = el)"
                >
                <div class="flex items-center justify-between gap-4">
                  <div>
                    <p class="font-semibold text-slate-900">{{ category.name }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ category.slug }}</p>
                  </div>
                  <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                    {{ category.is_visible ? 'Visible' : 'Masquée' }}
                  </span>
                </div>
                <div v-if="selectedCategory?.id === category.id" class="mt-3 h-1 rounded-full bg-primary-500"></div>
                <p class="mt-3 text-sm text-slate-600 line-clamp-2">{{ category.description || 'Aucune description' }}</p>
                <div class="mt-4 flex flex-wrap gap-2">
                  <button
                    type="button"
                    class="rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:border-slate-300"
                    @click.stop.prevent="editCategory(category)"
                  >
                    Modifier
                  </button>
                  <button
                    type="button"
                    class="rounded-full border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-100"
                    @click.stop.prevent="deleteCategory(category.id)"
                  >
                    Supprimer
                  </button>
                </div>
              </button>
              </div>
            </div>

            <!-- Carousel controls -->
            <div v-if="categoriesScroll && categoriesScroll.clientWidth < categoriesScroll.scrollWidth" class="absolute left-2 top-1/2 -translate-y-1/2 transition-opacity duration-200" :class="{ 'opacity-0': isHovered === false }">
              <button type="button" aria-label="Catégorie précédente" @click.prevent="scrollPrev" class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-lg font-semibold text-slate-600 shadow-md transition hover:border-primary-300 hover:text-primary-600">
                ‹
              </button>
            </div>
            <div v-if="categoriesScroll && categoriesScroll.clientWidth < categoriesScroll.scrollWidth" class="absolute right-2 top-1/2 -translate-y-1/2 transition-opacity duration-200" :class="{ 'opacity-0': isHovered === false }">
              <button type="button" aria-label="Catégorie suivante" @click.prevent="scrollNext" class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-lg font-semibold text-slate-600 shadow-md transition hover:border-primary-300 hover:text-primary-600">
                ›
              </button>
            </div>
          </div>

          <!-- Desktop: grid layout that wraps into rows -->
          <div class="hidden">
            <button
              v-for="category in categories"
              :key="category.id + '-grid'"
              type="button"
              class="w-full rounded-3xl border p-4 text-left transition hover:border-primary-300 hover:bg-primary-50"
              :class="selectedCategory?.id === category.id ? 'border-primary-500 bg-primary-50 ring-1 ring-primary-200' : 'border-slate-200 bg-white'"
              @click="selectCategory(category)"
            >
              <div class="flex items-center justify-between gap-4">
                <div>
                  <p class="font-semibold text-slate-900">{{ category.name }}</p>
                  <p class="mt-1 text-sm text-slate-500">{{ category.slug }}</p>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                  {{ category.is_visible ? 'Visible' : 'Masquée' }}
                </span>
              </div>
              <div v-if="selectedCategory?.id === category.id" class="mt-3 h-1 rounded-full bg-primary-500"></div>
              <p class="mt-3 text-sm text-slate-600 line-clamp-2">{{ category.description || 'Aucune description' }}</p>
              <div class="mt-4 flex flex-wrap gap-2">
                <button
                  type="button"
                  class="rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:border-slate-300"
                  @click.stop.prevent="editCategory(category)"
                >
                  Modifier
                </button>
                <button
                  type="button"
                  class="rounded-full border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-100"
                  @click.stop.prevent="deleteCategory(category.id)"
                >
                  Supprimer
                </button>
              </div>
            </button>
          </div>

          <div v-if="!categories.length" class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-500">
            Aucune catégorie pour le moment. Commencez par en créer une.
          </div>
        </div>
      </section>

      <section class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
          <div>
            <h2 class="text-lg font-semibold text-slate-900">Images</h2>
            <p class="mt-1 text-sm text-slate-500">
              {{ selectedCategory ? `Images dans ${selectedCategory.name}` : 'Sélectionnez une catégorie pour afficher ses images.' }}
            </p>
          </div>
          <div class="flex items-center gap-3">
            <span v-if="selectedCategory" class="rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-700">
              {{ selectedCategory.images?.length ?? 0 }} image{{ selectedCategory?.images?.length > 1 ? 's' : '' }}
            </span>
          </div>
        </div>

        <div v-if="!selectedCategory" class="mt-5 rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center text-sm text-slate-500">
          Sélectionnez une catégorie à gauche pour gérer les images.
        </div>

        <div v-else class="mt-5 grid gap-4 sm:grid-cols-2">
          <div
            v-for="image in selectedCategory.images"
            :key="image.id"
            class="rounded-3xl border border-slate-200 bg-slate-50 overflow-hidden shadow-sm"
          >
              <div class="relative aspect-[4/3] bg-slate-100 flex items-center justify-center overflow-hidden">
              <img
                :src="image.thumbnail_url || image.image_url || image.image || '/images/school-front.jpg'"
                :alt="image.title || 'Image de galerie'"
                class="max-h-full max-w-full object-contain"
              />
              <div class="absolute right-3 top-3 flex gap-2">
                <button
                  type="button"
                  class="rounded-full bg-white/80 p-2 text-xs text-slate-700 shadow-sm hover:bg-white"
                  @click.stop.prevent="editImage(image)"
                  title="Modifier"
                >
                  ✎
                </button>
                <button
                  type="button"
                  class="rounded-full bg-red-50 p-2 text-xs text-red-600 shadow-sm hover:bg-red-100"
                  @click.stop.prevent="deleteImage(image.id)"
                  title="Supprimer"
                >
                  🗑
                </button>
              </div>
            </div>
            <div class="p-4">
              <div class="flex items-start justify-between gap-3">
                <div>
                  <p class="text-sm text-slate-500 line-clamp-2">{{ image.description || 'Aucune description' }}</p>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                  {{ image.is_visible ? 'Visible' : 'Masquée' }}
                </span>
              </div>

              <div class="mt-4 flex flex-wrap gap-2">
                <button
                  type="button"
                  class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-sm font-semibold text-primary-700 transition hover:border-primary-300 hover:bg-primary-50"
                  @click="editImage(image)"
                >
                  Modifier
                </button>
                <button
                  type="button"
                  class="rounded-full border border-red-200 bg-red-50 px-3 py-1.5 text-sm font-semibold text-red-600 transition hover:bg-red-100"
                  @click="deleteImage(image.id)"
                >
                  Supprimer
                </button>
              </div>
            </div>
          </div>

          <div v-if="selectedCategory.images.length === 0" class="rounded-3xl border-dashed border border-slate-200 bg-slate-50 p-8 text-center text-sm text-slate-500">
            Cette catégorie ne contient encore aucune image.
          </div>
        </div>
      </section>
    </div>

    <Modal v-model="deleteCategoryModalOpen" title="Supprimer la catégorie">
      <div class="space-y-5">
        <div class="flex items-start gap-4 rounded-2xl border border-red-100 bg-red-50 p-4">
          <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008M10.29 3.86 2.82 17.25A1.5 1.5 0 0 0 4.13 19.5h15.74a1.5 1.5 0 0 0 1.31-2.25L13.71 3.86a1.5 1.5 0 0 0-2.62 0Z" />
            </svg>
          </span>
          <div>
            <p class="font-semibold text-slate-900">Cette action est définitive</p>
            <p class="mt-1 text-sm leading-6 text-red-700">La catégorie <strong>{{ categoryToDelete?.name }}</strong> et toutes ses images seront supprimées.</p>
          </div>
        </div>
        <p class="text-sm text-slate-500">Vérifiez que vous n’avez plus besoin de ces contenus avant de continuer.</p>
      </div>

      <template #footer>
        <button type="button" class="rounded-full border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50" @click="deleteCategoryModalOpen = false">
          Annuler
        </button>
        <button type="button" class="rounded-full bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60" :disabled="deletingCategory" @click="confirmDeleteCategory">
          {{ deletingCategory ? 'Suppression...' : 'Supprimer la catégorie' }}
        </button>
      </template>
    </Modal>

    <Modal v-model="categoryModalOpen" :title="categoryForm.id ? 'Modifier la catégorie' : 'Nouvelle catégorie'">
      <form class="space-y-4" @submit.prevent="saveCategory">
        <Input v-model="categoryForm.name" label="Nom" placeholder="Ex. Événements" required />
        <Input v-model="categoryForm.description" label="Description" placeholder="Description de la catégorie" />

        <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
          <input type="checkbox" v-model="categoryForm.is_visible" class="h-4 w-4 rounded border-slate-300 text-primary-500" />
          Visible sur le site
        </label>

        <div class="flex justify-end gap-2 pt-4">
          <button type="button" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700" @click="closeCategoryModal">
            Annuler
          </button>
          <button type="submit" class="rounded-full bg-primary-500 px-4 py-2 text-sm font-semibold text-white">
            {{ categoryForm.id ? 'Enregistrer' : 'Créer' }}
          </button>
        </div>
      </form>
    </Modal>

    <Modal v-model="imageModalOpen" :title="imageForm.id ? 'Modifier l’image' : 'Ajouter une image'">
      <form class="space-y-4" @submit.prevent="saveImage" enctype="multipart/form-data">
        <label class="block text-sm font-semibold text-slate-900">
          Image
          <input type="file" accept="image/*" @change="handleImageFileChange" class="mt-2 block w-full rounded-[20px] border border-slate-200 bg-slate-50 px-4 py-3" required />
        </label>
        <label class="block text-sm font-semibold text-slate-900">
          Miniature (optionnelle)
          <input type="file" accept="image/*" @change="handleThumbnailFileChange" class="mt-2 block w-full rounded-[20px] border border-slate-200 bg-slate-50 px-4 py-3" />
        </label>
        <Input v-model="imageForm.title" label="Titre" placeholder="Ex. Fête de fin d’année" />
        <Input v-model="imageForm.description" label="Description" placeholder="Description de l’image" />

        <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
          <input type="checkbox" v-model="imageForm.is_visible" class="h-4 w-4 rounded border-slate-300 text-primary-500" />
          Visible sur le site
        </label>

        <div class="flex justify-end gap-2 pt-4">
          <button type="button" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700" @click="closeImageModal">
            Annuler
          </button>
          <button type="submit" class="rounded-full bg-primary-500 px-4 py-2 text-sm font-semibold text-white">
            {{ imageForm.id ? 'Enregistrer' : 'Ajouter' }}
          </button>
        </div>
      </form>
    </Modal>
  </section>
</template>

<script setup>
import { onMounted, onBeforeUnmount, reactive, ref } from 'vue'
import { Input, Modal } from '@/components/admin'
import {
  createAdminGalleryCategory,
  createAdminGalleryImage,
  deleteAdminGalleryCategory,
  deleteAdminGalleryImage,
  getAdminGalleryCategories,
  updateAdminGalleryCategory,
  updateAdminGalleryImage,
} from '@/services/api/admin'
import AdminPageHeader from '@/components/admin.js'

const categories = ref([])
const selectedCategory = ref(null)
const statusMessage = ref('')
const categoryModalOpen = ref(false)
const imageModalOpen = ref(false)
const deleteCategoryModalOpen = ref(false)
const categoryToDelete = ref(null)
const deletingCategory = ref(false)

const categoryForm = reactive({
  id: null,
  name: '',
  slug: '',
  description: '',
  is_visible: true,
})

const imageForm = reactive({
  id: null,
  category_id: null,
  image: '',
  image_file: null,
  thumbnail: '',
  thumbnail_file: null,
  title: '',
  description: '',
  is_visible: true,
})

const loadCategories = async () => {
  try {
    const items = await getAdminGalleryCategories()
    categories.value = Array.isArray(items) ? items : []
    if (!selectedCategory.value && categories.value.length) {
      selectCategory(categories.value[0])
    } else if (selectedCategory.value) {
      const match = categories.value.find((item) => item.id === selectedCategory.value.id)
      selectedCategory.value = match || categories.value[0] || null
    }
  } catch (error) {
    console.warn('Unable to load gallery categories', error)
    categories.value = []
    selectedCategory.value = null
  }
}

const categoriesScroll = ref(null)
const categoryEls = {}
const isHovered = ref(false)
let autoplayInterval = null

const scrollPrev = () => {
  const el = categoriesScroll?.value
  if (!el) return
  el.scrollBy({ left: -Math.round(el.clientWidth * 0.7), behavior: 'smooth' })
}

const scrollNext = () => {
  const el = categoriesScroll?.value
  if (!el) return
  el.scrollBy({ left: Math.round(el.clientWidth * 0.7), behavior: 'smooth' })
}

const centerCategory = (categoryId) => {
  const el = categoryEls[categoryId]
  if (el?.scrollIntoView) {
    el.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' })
  }
}

const startAutoplay = () => {
  stopAutoplay()
  autoplayInterval = setInterval(() => {
    const el = categoriesScroll.value
    if (!isHovered.value && el && el.clientWidth < el.scrollWidth) {
      scrollNext()
    }
  }, 4000)
}

const stopAutoplay = () => {
  if (autoplayInterval) {
    clearInterval(autoplayInterval)
    autoplayInterval = null
  }
}

const selectCategory = (category) => {
  selectedCategory.value = category
  // center the selected category in the carousel if visible
  centerCategory(category.id)
}

const openCategoryModal = () => {
  Object.assign(categoryForm, {
    id: null,
    name: '',
    slug: '',
    description: '',
    is_visible: true,
  })
  categoryModalOpen.value = true
}

const editCategory = (category) => {
  Object.assign(categoryForm, {
    id: category.id,
    name: category.name,
    slug: category.slug,
    description: category.description,
    is_visible: Boolean(category.is_visible),
  })
  categoryModalOpen.value = true
}

const closeCategoryModal = () => {
  categoryModalOpen.value = false
}

const saveCategory = async () => {
  const payload = {
    name: categoryForm.name,
    description: categoryForm.description,
    is_visible: Boolean(categoryForm.is_visible),
  }

  if (categoryForm.id && categoryForm.slug) {
    payload.slug = categoryForm.slug
  }

  try {
    if (categoryForm.id) {
      const updated = await updateAdminGalleryCategory(categoryForm.id, payload)
      categories.value = categories.value.map((item) => (item.id === updated.id ? { ...item, ...updated } : item))
      if (selectedCategory.value?.id === updated.id) {
        selectedCategory.value = { ...selectedCategory.value, ...updated }
      }
      statusMessage.value = 'Catégorie mise à jour avec succès.'
    } else {
      const created = await createAdminGalleryCategory(payload)
      created.images = []
      categories.value.unshift(created)
      selectCategory(created)
      statusMessage.value = 'Catégorie créée avec succès.'
    }
    closeCategoryModal()
  } catch (error) {
    console.warn('Gallery category save error', error)
    statusMessage.value = 'Impossible de sauvegarder la catégorie.'
  }
}

const deleteCategory = (categoryId) => {
  categoryToDelete.value = categories.value.find((category) => category.id === categoryId) || null
  if (categoryToDelete.value) {
    deleteCategoryModalOpen.value = true
  }
}

const confirmDeleteCategory = async () => {
  const categoryId = categoryToDelete.value?.id
  if (!categoryId) return

  deletingCategory.value = true
  try {
    await deleteAdminGalleryCategory(categoryId)
    categories.value = categories.value.filter((item) => item.id !== categoryId)
    if (selectedCategory.value?.id === categoryId) {
      selectedCategory.value = categories.value[0] || null
    }
    statusMessage.value = 'Catégorie supprimée.'
  } catch (error) {
    console.warn('Unable to delete gallery category', error)
    statusMessage.value = 'Impossible de supprimer la catégorie.'
  } finally {
    deletingCategory.value = false
    deleteCategoryModalOpen.value = false
    categoryToDelete.value = null
  }
}

const openImageModal = () => {
  if (!selectedCategory.value) return

  Object.assign(imageForm, {
    id: null,
    category_id: selectedCategory.value.id,
    image: '',
    thumbnail: '',
    title: '',
    description: '',
    is_visible: true,
  })
  imageModalOpen.value = true
}

const editImage = (image) => {
  Object.assign(imageForm, {
    id: image.id,
    category_id: selectedCategory.value?.id || null,
    image: image.image || image.image_url || '',
    thumbnail: image.thumbnail || image.thumbnail_url || '',
    title: image.title || '',
    description: image.description || '',
    is_visible: Boolean(image.is_visible),
  })
  imageModalOpen.value = true
}

const closeImageModal = () => {
  imageModalOpen.value = false
}

const saveImage = async () => {
  if (!selectedCategory.value) return

  const payload = new FormData()
  payload.append('category_id', imageForm.category_id)
  if (imageForm.image_file) {
    payload.append('image_file', imageForm.image_file)
  }
  if (imageForm.thumbnail_file) {
    payload.append('thumbnail_file', imageForm.thumbnail_file)
  }
  payload.append('title', imageForm.title || '')
  payload.append('description', imageForm.description || '')
  payload.append('is_visible', imageForm.is_visible ? '1' : '0')

  try {
    if (imageForm.id) {
      const updated = await updateAdminGalleryImage(imageForm.id, payload)
      if (selectedCategory.value) {
        selectedCategory.value.images = selectedCategory.value.images.map((item) =>
          item.id === updated.id ? { ...item, ...updated } : item,
        )
      }
      statusMessage.value = 'Image mise à jour avec succès.'
    } else {
      const created = await createAdminGalleryImage(payload)
      if (selectedCategory.value) {
        selectedCategory.value.images = [
          ...(selectedCategory.value.images || []),
          created,
        ]
      }
      statusMessage.value = 'Image ajoutée avec succès.'
    }
    closeImageModal()
  } catch (error) {
    console.warn('Gallery image save error', error)
    statusMessage.value = 'Impossible de sauvegarder l’image.'
  }
}

const handleImageFileChange = (event) => {
  const file = event.target.files?.[0] || null
  imageForm.image_file = file
}

const handleThumbnailFileChange = (event) => {
  const file = event.target.files?.[0] || null
  imageForm.thumbnail_file = file
}

const deleteImage = async (imageId) => {
  if (!confirm('Supprimer cette image ?')) {
    return
  }

  try {
    await deleteAdminGalleryImage(imageId)
    if (selectedCategory.value) {
      selectedCategory.value.images = selectedCategory.value.images.filter((item) => item.id !== imageId)
    }
    statusMessage.value = 'Image supprimée.'
  } catch (error) {
    console.warn('Unable to delete gallery image', error)
    statusMessage.value = 'Impossible de supprimer l’image.'
  }
}

onMounted(() => {
  loadCategories()
  startAutoplay()
})

onBeforeUnmount(() => {
  stopAutoplay()
})
</script>

<style scoped>
.category-scroll {
  scrollbar-width: thin;
  scrollbar-color: rgb(249 115 22 / 0.85) rgb(241 245 249);
}

.category-scroll::-webkit-scrollbar {
  height: 7px;
}

.category-scroll::-webkit-scrollbar-track {
  border-radius: 999px;
  background: rgb(241 245 249);
}

.category-scroll::-webkit-scrollbar-thumb {
  border: 2px solid rgb(241 245 249);
  border-radius: 999px;
  background: rgb(249 115 22 / 0.85);
}

.category-scroll::-webkit-scrollbar-thumb:hover {
  background: rgb(234 88 12);
}
</style>
