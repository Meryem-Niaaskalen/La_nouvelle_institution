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
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-300">
          <div class="flex items-center gap-4">
            <p class="text-sm">&copy; {{ currentYear }} <span class="font-semibold">La nouvelle institution</span>. Tous droits réservés.</p>
            <span class="hidden sm:inline-block h-4 w-px bg-gray-700 mx-3" aria-hidden="true"></span>
            <div class="hidden sm:flex items-center gap-4 text-sm">
              <a href="#" class="hover:text-primary-500">Conditions d'utilisation</a>
              <a href="#" class="hover:text-primary-500">Politique de confidentialité</a>
              <a href="#" class="hover:text-primary-500">Mentions légales</a>
            </div>
          </div>

          <div class="flex items-center gap-4 mt-4 md:mt-0">
            <a href="https://web.facebook.com/profile.php?id=100056328531139&sk=photos" target="_blank" aria-label="Facebook" class="hover:text-primary-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12.07C22 6.48 17.52 2 11.93 2S2 6.48 2 12.07C2 17.08 5.66 21.18 10.44 21.95v-6.99H8.08v-2.9h2.36V9.41c0-2.33 1.38-3.62 3.5-3.62.99 0 2.03.18 2.03.18v2.23h-1.14c-1.13 0-1.48.7-1.48 1.42v1.7h2.52l-.4 2.9h-2.12V21.95C18.34 21.18 22 17.08 22 12.07z"/></svg>
            </a>
            <a href="#" aria-label="Instagram" class="hover:text-primary-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm10 2c1.66 0 3 1.34 3 3v10c0 1.66-1.34 3-3 3H7c-1.66 0-3-1.34-3-3V7c0-1.66 1.34-3 3-3h10zM12 7a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6zm4.5-3a1.5 1.5 0 11.001 3.001A1.5 1.5 0 0116.5 6z"/></svg>
            </a>
            <a href="#" aria-label="YouTube" class="hover:text-primary-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.5 6.2s-.2-1.6-.8-2.3c-.8-.9-1.7-.9-2.1-1-3-.2-7.5-.2-7.5-.2h-.1s-4.5 0-7.5.2c-.4.1-1.3.1-2.1 1C.7 4.6.5 6.2.5 6.2S.2 8 .2 9.8v4.4c0 1.8.3 3.6.3 3.6s.2 1.6.8 2.3c.8.9 1.8.9 2.3 1 1.7.1 7.1.2 7.1.2s4.4 0 7.4-.2c.4-.1 1.3-.1 2.1-1 .6-.7.8-2.3.8-2.3s.3-1.8.3-3.6V9.8c0-1.8-.3-3.6-.3-3.6zM9.8 15.1V8.9l6.1 3.1-6.1 3.1z"/></svg>
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

