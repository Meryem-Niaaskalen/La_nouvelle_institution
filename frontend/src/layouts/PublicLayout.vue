<script setup>
import { RouterView } from 'vue-router'
import { Navigation } from '@/components'

// dynamic current year for footer
const currentYear = new Date().getFullYear()
</script>

<template>
  <div class="min-h-screen flex flex-col bg-white">
    <Navigation />

    <main class="flex-1 pt-20">
      <RouterView />
    </main>

    <!-- Footer -->
    <footer class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-gray-900 to-gray-800 text-white py-12 md:py-16">
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(249,115,22,0.15),_transparent_35%)]"></div>
      <div class="relative max-w-7xl mx-auto px-6 md:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
          <!-- School Info -->
          <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
            <div class="flex items-center gap-3 mb-4">
              <img src="/images/logo-school-3.png" alt="Logo La nouvelle institution" class="h-12 w-12 rounded-full border border-white/20 bg-white object-contain p-1 shadow-lg shadow-black/20" />
              <div>
                <h3 class="font-bold text-lg text-white">La nouvelle institution</h3>
                <p class="text-gray-300 text-sm">Éducation de qualité depuis 1997</p>
              </div>
            </div>
            <p class="text-gray-300 text-sm">Maternelle • Primaire • Collège • Lycée</p>
            <p class="text-gray-300 text-sm mt-2">25 Rue Adawha El Fath 3</p>
            <p class="text-gray-300 text-sm">Casablanca, Maroc</p>
          </div>

          <!-- Quick Links -->
          <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
            <h4 class="font-semibold mb-4 text-white">Navigation</h4>
            <ul class="space-y-2 text-sm text-gray-300">
              <li><router-link to="/" class="transition-colors duration-200 hover:text-primary-500">Accueil</router-link></li>
              <li><router-link to="/a-propos" class="transition-colors duration-200 hover:text-primary-500">À propos</router-link></li>
              <li><router-link to="/programmes" class="transition-colors duration-200 hover:text-primary-500">Programmes</router-link></li>
              <li><router-link to="/admissions" class="transition-colors duration-200 hover:text-primary-500">Admissions</router-link></li>
              <li><router-link to="/galerie" class="transition-colors duration-200 hover:text-primary-500">Galerie</router-link></li>
            </ul>
          </div>

          <!-- Contact Info -->
          <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
            <h4 class="font-semibold mb-4 text-white">Contact</h4>
            <ul class="space-y-2 text-sm text-gray-300">
              <li>05228-75634</li>
              <li>gsni2527@gmail.com</li>
              <li class="mt-4 flex flex-wrap gap-3">
                <a href="https://web.facebook.com/profile.php?id=100056328531139&sk=photos" target="_blank" class="transition-colors duration-200 hover:text-primary-500">
                  Facebook
                </a>
                <a href="https://www.instagram.com/la_nouvelleinstitution?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="transition-colors duration-200 hover:text-primary-500">
                  Instagram
                </a>
              </li>
            </ul>
          </div>

          <!-- Newsletter -->
          <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
            <div class="flex flex-col items-start md:items-center text-left md:text-center">
              <h4 class="font-semibold mb-3 text-white">Rester informé</h4>
              <p class="text-sm text-gray-300 mb-4">Recevez les actualités de l'école</p>
              <form class="flex w-full max-w-sm flex-col sm:flex-row gap-2">
                <input 
                  type="email" 
                  placeholder="Votre email" 
                  class="flex-1 px-3 py-2 rounded-lg border border-white/10 bg-gray-800/80 text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                />
                <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors text-sm font-semibold shadow-lg shadow-primary-500/20">
                  S'abonner
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- Bottom Footer -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 border-t border-white/10 pt-8 text-sm text-gray-300">
          <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4 text-center sm:text-left">
            <p>&copy; {{ currentYear }} <span class="font-semibold text-white">La nouvelle institution</span>. Tous droits réservés.</p>
            <div class="flex items-center gap-4">
              <a href="#" class="transition-colors duration-200 hover:text-primary-500">Conditions d'utilisation</a>
              <a href="#" class="transition-colors duration-200 hover:text-primary-500">Politique de confidentialité</a>
              <a href="#" class="transition-colors duration-200 hover:text-primary-500">Mentions légales</a>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <a href="https://web.facebook.com/profile.php?id=100056328531139&sk=photos" target="_blank" aria-label="Facebook" class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/10 text-white transition-all hover:-translate-y-0.5 hover:bg-primary-500 hover:text-white">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12.07C22 6.48 17.52 2 11.93 2S2 6.48 2 12.07C2 17.08 5.66 21.18 10.44 21.95v-6.99H8.08v-2.9h2.36V9.41c0-2.33 1.38-3.62 3.5-3.62.99 0 2.03.18 2.03.18v2.23h-1.14c-1.13 0-1.48.7-1.48 1.42v1.7h2.52l-.4 2.9h-2.12V21.95C18.34 21.18 22 17.08 22 12.07z"/></svg>
            </a>
            <a href="https://www.instagram.com/la_nouvelleinstitution?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" aria-label="Instagram" target="_blank" class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/10 text-white transition-all hover:-translate-y-0.5 hover:bg-primary-500 hover:text-white">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm10 2c1.66 0 3 1.34 3 3v10c0 1.66-1.34 3-3 3H7c-1.66 0-3-1.34-3-3V7c0-1.66 1.34-3 3-3h10zM12 7a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6zm4.5-3a1.5 1.5 0 11.001 3.001A1.5 1.5 0 0116.5 6z"/></svg>
            </a>
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

