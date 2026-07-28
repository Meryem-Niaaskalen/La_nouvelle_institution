<script setup>
import { Section, Card, Input, Button } from '@/components'
</script>

<template>
  <div class="bg-gray-50">
    <Section title="Contactez-nous" subtitle="Nous sommes à votre écoute pour toutes vos questions.">
      <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
        <Card title="Informations de contact" description="Une équipe disponible et à l’écoute des familles et des partenaires." :hoverable="true">
          <div class="mt-6 space-y-3 text-sm text-gray-700">
            <p><strong>Adresse :</strong> 25 Rue Adawha El Fath 3, Casablanca, Maroc</p>
            <p><strong>Téléphone :</strong> 05228-75634</p>
            <p><strong>Email :</strong> gsni2527@gmail.com</p>
            <p><strong>Facebook :</strong> <a href="https://web.facebook.com/profile.php?id=100056328531139&sk=photos" target="_blank" rel="noopener">Visiter la page</a></p>
          </div>
          <div class="mt-6 overflow-hidden rounded-2xl border border-gray-200">
            <iframe
              title="Carte de l’établissement"
              class="h-64 w-full"
              loading="lazy"
              allowfullscreen
              referrerpolicy="no-referrer-when-downgrade"
              src="https://www.google.com/maps?q=25+Rue+Adawha+El+Fath+3,+Casablanca,+Morocco&output=embed"
            />
          </div>
        </Card>

        <Card title="Écrivez-nous" description="Envoyez-nous un message et nous vous répondrons rapidement." :hoverable="true">
          <form class="mt-6 space-y-4">
            <Input label="Nom" placeholder="Votre nom" />
            <Input label="Email" type="email" placeholder="Votre email" />
            <Input label="Sujet" placeholder="Sujet" />
            <label class="block text-sm font-semibold text-gray-900">
              Message
              <textarea rows="4" class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 focus:border-primary-500 focus:outline-none" placeholder="Votre message..." />
            </label>
            <Button label="Envoyer le message" class="w-full" />
          </form>
        </Card>
      </div>
    </Section>
  </div>
</template>
