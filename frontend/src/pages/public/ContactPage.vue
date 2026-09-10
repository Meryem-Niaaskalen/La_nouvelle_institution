<script setup>
import { onMounted, ref } from 'vue'
import { Section, Card, Input, Button } from '@/components'
import { getPublicSettings, sendContactMessage } from '@/services/api/school'

const contact = ref({
  address: 'Hay El Fath 3, rue 20, villa 25/27, Ain Chok, Casablanca - Maroc',
  phone: '05228-75634',
  phone_secondary: '',
  phone_tertiary: '',
  email: 'gsni2527@gmail.com',
  facebook: 'https://web.facebook.com/profile.php?id=100056328531139&sk=photos',
})

const contactForm = ref({
  name: '',
  email: '',
  subject: '',
  message: '',
})

const whatsappNumber = '212660026163'

const submitted = ref(false)
const sending = ref(false)
const error = ref('')

const getWhatsAppLink = (payload = {}) => {
  const text = [
    'Bonjour, je souhaite prendre contact avec votre établissement.',
    payload.name ? `Nom: ${payload.name}` : '',
    payload.email ? `Email: ${payload.email}` : '',
    payload.subject ? `Sujet: ${payload.subject}` : '',
    payload.message ? `Message: ${payload.message}` : '',
  ]
    .filter(Boolean)
    .join('\n')

  return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(text)}`
}

const openWhatsApp = (payload = contactForm.value) => {
  if (typeof window !== 'undefined') {
    window.open(getWhatsAppLink(payload), '_blank', 'noopener,noreferrer')
  }
}

const submitContact = async () => {
  error.value = ''
  sending.value = true
  try {
    await sendContactMessage(contactForm.value)
    openWhatsApp(contactForm.value)
    submitted.value = true
    contactForm.value = {
      name: '',
      email: '',
      subject: '',
      message: '',
    }
  } catch (err) {
    console.warn('Unable to send contact message', err)
    error.value = 'Impossible d’envoyer le message. Veuillez réessayer.'
  } finally {
    sending.value = false
  }
}

const loadContactSettings = async () => {
  try {
    const response = await getPublicSettings()
    const data = response?.data?.data ?? response?.data ?? response

    contact.value.address = data?.school_address || contact.value.address
    contact.value.phone = data?.school_phone || contact.value.phone
    contact.value.phone_secondary = data?.school_phone_secondary || ''
    contact.value.phone_tertiary = data?.school_phone_tertiary || ''
    contact.value.email = data?.school_email || contact.value.email
    contact.value.facebook = data?.school_facebook || contact.value.facebook
  } catch (err) {
    console.warn('Unable to load public contact settings', err)
    error.value = 'Impossible de charger les informations de contact. Vérifiez le backend et rechargez la page.'
  }
}

onMounted(loadContactSettings)
</script>

<template>
  <div class="bg-slate-50">
    <Section title="Contactez-nous" subtitle="Notre équipe est prête à répondre à vos questions et à accompagner vos démarches.">
      <div class="grid grid-cols-1 gap-8 lg:grid-cols-[1.05fr_0.95fr] items-start">
        <div class="rounded-[32px] border border-slate-200 bg-white p-10 shadow-large">
          <div class="inline-flex items-center gap-3 rounded-full border border-sky-200 bg-sky-50 px-4 py-2 text-sm font-semibold text-sky-700">
            Assistance dédiée
          </div>
          <h2 class="mt-6 text-4xl font-semibold text-slate-900">Une équipe disponible et à l’écoute des familles.</h2>
          <p class="mt-5 text-lg leading-8 text-slate-600">
            Contactez-nous pour obtenir des informations sur nos programmes, nos admissions ou organiser une visite.
            Nous serons heureux de vous accompagner dans votre démarche.
          </p>

          <div class="mt-10 grid gap-4 sm:grid-cols-2">
            <div class="rounded-[28px] bg-slate-50 p-6">
              <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Adresse</p>
              <p class="mt-3 text-base font-semibold text-slate-900">{{ contact.address }}</p>
            </div>
            <div class="rounded-[28px] bg-slate-50 p-6">
              <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Téléphone principal</p>
              <p class="mt-3 text-base font-semibold text-slate-900">{{ contact.phone }}</p>
            </div>
          </div>

          <div class="mt-8 grid gap-4 sm:grid-cols-2">
            <div class="rounded-[28px] bg-slate-50 p-6">
              <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Téléphone secondaire</p>
              <p class="mt-3 text-base font-semibold text-slate-900">{{ contact.phone_secondary || 'Non renseigné' }}</p>
            </div>
            <div class="rounded-[28px] bg-slate-50 p-6">
              <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Téléphone supplémentaire</p>
              <p class="mt-3 text-base font-semibold text-slate-900">{{ contact.phone_tertiary || 'Non renseigné' }}</p>
            </div>
          </div>
          <div class="mt-8 grid gap-4 sm:grid-cols-2">
            <div class="rounded-[28px] bg-slate-50 p-6">
              <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Email</p>
              <p class="mt-3 text-base font-semibold text-slate-900">{{ contact.email }}</p>
            </div>
            <div class="rounded-[28px] bg-slate-50 p-6">
              <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Facebook</p>
              <a :href="contact.facebook" target="_blank" rel="noopener" class="mt-3 inline-block text-base font-semibold text-primary-700 hover:text-primary-800">
                Visiter la page
              </a>
            </div>
          </div>

          <div class="mt-8 overflow-hidden rounded-[28px] border border-slate-200">
            <iframe
              title="Carte de l’établissement"
              class="h-72 w-full"
              loading="lazy"
              allowfullscreen
              referrerpolicy="no-referrer-when-downgrade"
              src="https://www.google.com/maps?q=33.5321934,-7.5910344&z=18&output=embed"
            />
          </div>
        </div>

        <Card title="Écrivez-nous" description="Envoyez-nous un message, nous vous répondrons dans les meilleurs délais." :hoverable="true" class="rounded-[32px] border border-slate-200 bg-white shadow-large">
          <form class="mt-6 space-y-4" @submit.prevent="submitContact">
            <div class="grid gap-4 md:grid-cols-2">
              <Input v-model="contactForm.name" label="Nom" placeholder="Votre nom" />
              <Input v-model="contactForm.email" label="Email" type="email" placeholder="Votre email" />
            </div>
            <Input v-model="contactForm.subject" label="Sujet" placeholder="Sujet" />
            <Input
              v-model="contactForm.message"
              label="Message"
              type="textarea"
              placeholder="Votre message..."
              rows="5"
            />
            <Button :disabled="sending" type="submit" label="Envoyer le message" class="w-full" />
            <p v-if="submitted" class="text-sm text-emerald-600">Merci, votre message a bien été envoyé.</p>
            <p v-if="error" class="text-sm text-red-600">{{ error }}</p>
          </form>
        </Card>
      </div>
    </Section>
  </div>
</template>
