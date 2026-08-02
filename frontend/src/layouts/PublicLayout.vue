<script setup>
import { RouterView } from 'vue-router'
import { Navigation } from '@/components'
</script>

<template>
  <div class="min-h-screen flex flex-col bg-white">
    <Navigation />

    <main class="flex-1 pt-20">
      <RouterView />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 md:py-16">
      <div class="max-w-7xl mx-auto px-6 md:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
          <!-- School Info -->
          <div>
            <div class="flex items-center gap-3 mb-4">
              <img src="/images/logo-school-3.png" alt="Logo La nouvelle institution" class="h-12 w-12 rounded-full border border-white/20 bg-white object-contain p-1" />
              <div>
                <h3 class="font-bold text-lg">La nouvelle institution</h3>
                <p class="text-gray-400 text-sm">Éducation de qualité depuis 1997</p>
              </div>
            </div>
            <p class="text-gray-400 text-sm">Maternelle • Primaire • Collège • Lycée</p>
            <p class="text-gray-400 text-sm mt-2">25 Rue Adawha El Fath 3</p>
            <p class="text-gray-400 text-sm">Casablanca, Maroc</p>
          </div>

          <!-- Quick Links -->
          <div>
            <h4 class="font-semibold mb-4">Navigation</h4>
            <ul class="space-y-2 text-sm text-gray-400">
              <li><router-link to="/" class="hover:text-primary-500">Accueil</router-link></li>
              <li><router-link to="/a-propos" class="hover:text-primary-500">À propos</router-link></li>
              <li><router-link to="/programmes" class="hover:text-primary-500">Programmes</router-link></li>
              <li><router-link to="/admissions" class="hover:text-primary-500">Admissions</router-link></li>
              <li><router-link to="/galerie" class="hover:text-primary-500">Galerie</router-link></li>
            </ul>
          </div>

          <!-- Contact Info -->
          <div>
            <h4 class="font-semibold mb-4">Contact</h4>
            <ul class="space-y-2 text-sm text-gray-400">
              <li> 05228-75634</li>
              <li> gsni2527@gmail.com</li>
              <li class="mt-4">
                <a href="https://web.facebook.com/profile.php?id=100056328531139&sk=photos" target="_blank" class="hover:text-primary-500">
                  Facebook
                </a>
              </li>
            </ul>
          </div>

          <!-- Newsletter -->
          <div>
            <h4 class="font-semibold mb-4">Rester informé</h4>
            <p class="text-sm text-gray-400 mb-4">Recevez les actualités de l'école</p>
            <form class="flex gap-2">
              <input 
                type="email" 
                placeholder="Votre email" 
                class="flex-1 px-3 py-2 rounded-lg bg-gray-800 text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
              />
              <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors text-sm font-semibold">
                S'abonner
              </button>
            </form>
          </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
          <p>&copy; 2024 La nouvelle institution. Tous droits réservés.</p>
          <div class="flex gap-6 mt-4 md:mt-0">
            <a href="#" class="hover:text-primary-500">Conditions d'utilisation</a>
            <a href="#" class="hover:text-primary-500">Politique de confidentialité</a>
            <a href="#" class="hover:text-primary-500">Mentions légales</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>
:deep(nav) {
  padding-top: 0 !important;
  padding-bottom: 0 !important;
}
</style>

