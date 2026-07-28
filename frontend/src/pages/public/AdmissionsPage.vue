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
    title: '1. Prise de contact',
    description: 'Remplissez le formulaire de demande d’admission ou contactez notre secrétariat.',
  },
  {
    title: '2. Entretien',
    description: 'Un échange avec l’équipe pédagogique permet d’évaluer le projet de l’élève.',
  },
  {
    title: '3. Inscription',
    description: 'Après validation, l’inscription finale est effectuée avec les pièces justificatives.',
  },
]

const submitForm = () => {
  submitted.value = true
}
</script>

<template>
  <div class="bg-gray-50">
    <Section title="Admissions" subtitle="Rejoignez une école où chaque élève peut s’épanouir et réussir.">
      <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
        <div class="space-y-4">
          <Card v-for="step in steps" :key="step.title" :title="step.title" :description="step.description" :hoverable="true" />
        </div>

        <Card title="Demande d’admission" description="Déposez votre dossier en quelques instants." :hoverable="true">
          <form class="mt-6 space-y-4" @submit.prevent="submitForm">
            <Input v-model="form.name" label="Nom complet" placeholder="Nom et prénom" />
            <Input v-model="form.email" label="Email" type="email" placeholder="exemple@email.com" />
            <Input v-model="form.phone" label="Téléphone" placeholder="05228-75634" />
            <Input v-model="form.niveau" label="Niveau souhaité" placeholder="Seconde, Première, Terminale..." />
            <label class="block text-sm font-semibold text-gray-900">
              Message
              <textarea v-model="form.message" rows="4" class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 focus:border-primary-500 focus:outline-none" placeholder="Précisez votre demande..." />
            </label>
            <Button type="submit" label="Envoyer ma demande" class="w-full" />
            <p v-if="submitted" class="text-sm text-green-600">Merci, votre demande a bien été enregistrée.</p>
          </form>
        </Card>
      </div>
    </Section>
  </div>
</template>
