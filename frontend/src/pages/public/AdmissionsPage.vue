<script setup>
import { ref } from 'vue'
import { Section, Input, Button, Card } from '@/components'

const form = ref({
  name: '',
  email: '',
  phone: '',
  niveau: '',
  message: '',
})

const submitted = ref(false)

const steps = [
  {
    title: 'Prise de contact',
    description: 'Remplissez le formulaire d’admission ou contactez notre secrétariat pour un premier échange.',
  },
  {
    title: 'Entretien personnalisé',
    description: 'Rencontrez notre équipe pédagogique pour définir le projet éducatif de l’élève.',
  },
  {
    title: 'Confirmation',
    description: 'Finalisez l’inscription avec les pièces justificatives et la validation administrative.',
  },
]

const submitForm = () => {
  submitted.value = true
}
</script>

<template>
  <div class="bg-slate-50">
    <Section title="Admissions" subtitle="Un parcours clair, humain et professionnel pour intégrer notre établissement.">
      <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] items-start">
        <div class="rounded-[32px] border border-slate-200 bg-white p-10 shadow-large">
          <div class="inline-flex items-center gap-3 rounded-full border border-primary-200 bg-primary-50 px-4 py-2 text-sm font-semibold text-primary-700">
            Admission 2026
          </div>
          <h2 class="mt-6 text-4xl font-semibold text-slate-900">Un dossier simple, un accompagnement sur mesure.</h2>
          <p class="mt-5 text-lg leading-8 text-slate-600">
            Notre processus d’admission est conçu pour être transparent, rapide et humain. Nous accompagnons chaque famille
            pas à pas pour garantir la meilleure orientation possible.
          </p>

          <div class="mt-10 grid gap-4 sm:grid-cols-2">
            <div class="rounded-[28px] bg-slate-50 p-6">
              <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Accompagnement</p>
              <p class="mt-3 text-2xl font-semibold text-slate-900">Personnalisé</p>
            </div>
            <div class="rounded-[28px] bg-slate-50 p-6">
              <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Découverte</p>
              <p class="mt-3 text-2xl font-semibold text-slate-900">Visite sur rendez-vous</p>
            </div>
          </div>
        </div>

        <div class="space-y-4">
          <Card
            v-for="step in steps"
            :key="step.title"
            class="rounded-[28px] border border-slate-200 bg-white shadow-soft"
            :title="step.title"
            :description="step.description"
            :hoverable="true"
          />
        </div>
      </div>

      <div class="mt-12 grid gap-8 lg:grid-cols-[1.05fr_0.95fr] items-start">
        <div class="rounded-[32px] border border-slate-200 bg-white p-10 shadow-large">
          <div class="inline-flex items-center gap-3 rounded-full bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-800">
            Pourquoi nous choisir
          </div>
          <h3 class="mt-6 text-3xl font-semibold text-slate-900">Une école exigeante, chaleureuse et tournée vers l’avenir.</h3>
          <ul class="mt-6 space-y-4 text-slate-600">
            <li class="flex gap-3">
              <span class="mt-1 h-2.5 w-2.5 rounded-full bg-primary-600"></span>
              <span>Un suivi individualisé pour chaque élève.</span>
            </li>
            <li class="flex gap-3">
              <span class="mt-1 h-2.5 w-2.5 rounded-full bg-primary-600"></span>
              <span>Des outils pédagogiques modernes et adaptés.</span>
            </li>
            <li class="flex gap-3">
              <span class="mt-1 h-2.5 w-2.5 rounded-full bg-primary-600"></span>
              <span>Une ambiance scolaire sécurisante et motivante.</span>
            </li>
          </ul>
        </div>

        <Card title="Demande d’admission" description="Soumettez votre demande en quelques minutes." :hoverable="true" class="rounded-[32px] border border-slate-200 bg-white shadow-large">
          <form class="mt-6 space-y-4" @submit.prevent="submitForm">
            <div class="grid gap-4 md:grid-cols-2">
              <Input v-model="form.name" label="Nom complet" placeholder="Nom et prénom" />
              <Input v-model="form.email" label="Email" type="email" placeholder="exemple@email.com" />
            </div>
            <div class="grid gap-4 md:grid-cols-2">
              <Input v-model="form.phone" label="Téléphone" placeholder="05228-75634" />
              <Input v-model="form.niveau" label="Niveau souhaité" placeholder="Seconde, Première, Terminale..." />
            </div>
            <Input
              v-model="form.message"
              label="Message"
              type="textarea"
              placeholder="Précisez votre demande..."
              rows="4"
            />
            <Button type="submit" label="Envoyer ma demande" class="w-full" />
            <p v-if="submitted" class="text-sm text-emerald-600">Merci, votre demande a bien été enregistrée.</p>
          </form>
        </Card>
      </div>
    </Section>
  </div>
</template>
