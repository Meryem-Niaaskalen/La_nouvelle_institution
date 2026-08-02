<script setup>
import { ref } from 'vue'
import { Section, Card, Input, Button } from '@/components'

const contactForm = ref({
  name: '',
  email: '',
  subject: '',
  message: '',
})

const submitted = ref(false)

const submitContact = () => {
  submitted.value = true
}
</script>

<template>
  <div class="bg-slate-50">
    <Section title="Contactez-nous" subtitle="Notre équipe est prête à répondre à vos questions et à accompagner vos démarches.">
      <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] items-start">
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
              <p class="mt-3 text-base font-semibold text-slate-900">25 Rue Adawha El Fath 3, Casablanca</p>
            </div>
            <div class="rounded-[28px] bg-slate-50 p-6">
              <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Téléphone</p>
              <p class="mt-3 text-base font-semibold text-slate-900">05228-75634</p>
            </div>
          </div>

          <div class="mt-8 grid gap-4 sm:grid-cols-2">
            <div class="rounded-[28px] bg-slate-50 p-6">
              <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Email</p>
              <p class="mt-3 text-base font-semibold text-slate-900">gsni2527@gmail.com</p>
            </div>
            <div class="rounded-[28px] bg-slate-50 p-6">
              <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Facebook</p>
              <a href="https://web.facebook.com/profile.php?id=100056328531139&sk=photos" target="_blank" rel="noopener" class="mt-3 inline-block text-base font-semibold text-primary-700 hover:text-primary-800">
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
              src="https://www.google.com/maps?q=25+Rue+Adawha+El+Fath+3,+Casablanca,+Morocco&output=embed"
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
            <Button type="submit" label="Envoyer le message" class="w-full" />
            <p v-if="submitted" class="text-sm text-emerald-600">Merci, votre message a bien été envoyé.</p>
          </form>
        </Card>
      </div>
    </Section>
  </div>
</template>
