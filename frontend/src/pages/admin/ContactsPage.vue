<template>
  <section class="space-y-8 max-w-7xl mx-auto">
    <AdminPageHeader title="Contacts" subtitle="Gérez les informations de contact affichées sur le site." />

    <div v-if="statusMessage" class="rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700 shadow-sm">
      {{ statusMessage }}
    </div>

    <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
      <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 class="text-lg font-semibold text-slate-900">Détails de contact</h2>
            <p class="mt-2 text-sm text-slate-500">Mettez à jour les coordonnées visibles sur le site.</p>
          </div>
          <div class="flex flex-wrap gap-3">
            <button
              type="button"
              class="rounded-full bg-primary-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-600"
              @click="loadSettings"
            >
              Rafraîchir
            </button>
          </div>
        </div>

        <div class="mt-8 space-y-5">
          <Input v-model="contactForm.address" label="Adresse" placeholder="Adresse de l’école" />
          <Input v-model="contactForm.phone" label="Téléphone principal" placeholder="+212 ..." />
          <Input v-model="contactForm.phone_secondary" label="Téléphone secondaire" placeholder="+212 ..." />
          <Input v-model="contactForm.phone_tertiary" label="Téléphone supplémentaire" placeholder="+212 ..." />
          <Input v-model="contactForm.email" label="Email" placeholder="contact@ecole.ma" />
          <Input v-model="contactForm.facebook" label="Facebook" placeholder="https://..." />

          <div class="flex flex-wrap items-center gap-3 pt-3">
            <button
              type="button"
              class="rounded-full bg-primary-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-600"
              @click="handleSaveClick"
            >
              Enregistrer
            </button>
            <button
              type="button"
              class="rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-primary-300 hover:text-primary-700"
              @click="resetContactForm"
            >
              Annuler
            </button>
          </div>
        </div>
      </div>

      <aside class="rounded-3xl border border-slate-200 bg-slate-50 p-6 text-slate-900 shadow-sm">
        <div class="space-y-4">
          <div class="flex items-center gap-3 rounded-3xl bg-white px-4 py-3 shadow-sm">
            <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-primary-500 text-lg text-white">☎</span>
            <div>
              <p class="text-sm uppercase tracking-[0.25em] text-primary-700">Vue rapide</p>
              <p class="mt-1 text-lg font-semibold text-slate-900">Coordonnées publiques</p>
            </div>
          </div>

          <div class="space-y-3 rounded-3xl border border-slate-200 bg-slate-50 p-5">
            <div>
              <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Adresse</p>
              <p class="mt-2 text-sm text-slate-700">{{ contactForm.address || 'Non défini' }}</p>
            </div>
            <div>
              <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Téléphone principal</p>
              <p class="mt-2 text-sm text-slate-700">{{ contactForm.phone || 'Non défini' }}</p>
            </div>
            <div>
              <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Téléphone secondaire</p>
              <p class="mt-2 text-sm text-slate-700">{{ contactForm.phone_secondary || 'Non défini' }}</p>
            </div>
            <div>
              <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Téléphone supplémentaire</p>
              <p class="mt-2 text-sm text-slate-700">{{ contactForm.phone_tertiary || 'Non défini' }}</p>
            </div>
            <div>
              <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Email</p>
              <p class="mt-2 text-sm text-slate-700">{{ contactForm.email || 'Non défini' }}</p>
            </div>
            <div>
              <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Facebook</p>
              <p class="mt-2 text-sm text-slate-700 break-all">{{ contactForm.facebook || 'Non défini' }}</p>
            </div>
          </div>

          <p class="text-sm leading-6 text-slate-400">Les informations mises à jour seront immédiatement utilisées sur le site public, avec un style professionnel et un accès simplifié aux coordonnées importantes.</p>
        </div>
      </aside>
    </div>

    <Modal v-model="confirmSaveModalOpen" title="Enregistrer les modifications ?">
      <p class="text-sm leading-6 text-slate-600">
        Vous avez modifié les coordonnées de contact. Voulez-vous enregistrer ces changements ?
      </p>

      <template #footer>
        <button type="button" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50" @click="confirmSaveModalOpen = false">
          Annuler
        </button>
        <button type="button" class="rounded-full bg-primary-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-600" @click="confirmSaveContact">
          Oui, enregistrer
        </button>
      </template>
    </Modal>
  </section>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue'
import { Input, Modal } from '@/components/admin'
import { getPublicSettings, updateSetting } from '@/services/api/school'
import AdminPageHeader from '@/components/admin.js'

const settings = ref({})
const contactForm = reactive({ address: '', phone: '', phone_secondary: '', phone_tertiary: '', email: '', facebook: '' })
const statusMessage = ref('')
const confirmSaveModalOpen = ref(false)

const getFormSnapshot = () => ({
  address: contactForm.address || '',
  phone: contactForm.phone || '',
  phone_secondary: contactForm.phone_secondary || '',
  phone_tertiary: contactForm.phone_tertiary || '',
  email: contactForm.email || '',
  facebook: contactForm.facebook || '',
})

const hasUnsavedChanges = computed(() => {
  const current = getFormSnapshot()
  const original = {
    address: settings.value.school_address || '',
    phone: settings.value.school_phone || '',
    phone_secondary: settings.value.school_phone_secondary || '',
    phone_tertiary: settings.value.school_phone_tertiary || '',
    email: settings.value.school_email || '',
    facebook: settings.value.school_facebook || '',
  }

  return JSON.stringify(current) !== JSON.stringify(original)
})

const loadSettings = async () => {
  try {
    const publicResponse = await getPublicSettings()
    const publicData = publicResponse?.data?.data || {}

    settings.value = publicData

    contactForm.address = publicData.school_address || ''
    contactForm.phone = publicData.school_phone || ''
    contactForm.phone_secondary = publicData.school_phone_secondary || ''
    contactForm.phone_tertiary = publicData.school_phone_tertiary || ''
    contactForm.email = publicData.school_email || ''
    contactForm.facebook = publicData.school_facebook || ''
  } catch (error) {
    console.warn('Unable to load contact settings', error)
    settings.value = {}
  }
}

const resetContactForm = () => {
  contactForm.address = settings.value.school_address || ''
  contactForm.phone = settings.value.school_phone || ''
  contactForm.phone_secondary = settings.value.school_phone_secondary || ''
  contactForm.phone_tertiary = settings.value.school_phone_tertiary || ''
  contactForm.email = settings.value.school_email || ''
  contactForm.facebook = settings.value.school_facebook || ''
  confirmSaveModalOpen.value = false
  statusMessage.value = ''
}

const handleSaveClick = () => {
  if (!hasUnsavedChanges.value) {
    saveContactInfo()
    return
  }

  confirmSaveModalOpen.value = true
}

const confirmSaveContact = async () => {
  confirmSaveModalOpen.value = false
  await saveContactInfo()
}

const saveContactInfo = async () => {
  try {
    await updateSetting('school_address', { value: contactForm.address })
    await updateSetting('school_phone', { value: contactForm.phone })
    await updateSetting('school_phone_secondary', { value: contactForm.phone_secondary })
    await updateSetting('school_phone_tertiary', { value: contactForm.phone_tertiary })
    await updateSetting('school_email', { value: contactForm.email })
    await updateSetting('school_facebook', { value: contactForm.facebook })

    statusMessage.value = 'Informations de contact mises à jour.'
    await loadSettings()
  } catch (error) {
    console.warn('Unable to save contact info', error)
    const errorMessage =
      error?.response?.data?.message ||
      error?.response?.data?.errors?.value?.[0] ||
      error?.message ||
      'Impossible de sauvegarder les informations de contact.'
    statusMessage.value = errorMessage
  }
}

onMounted(loadSettings)
</script>
