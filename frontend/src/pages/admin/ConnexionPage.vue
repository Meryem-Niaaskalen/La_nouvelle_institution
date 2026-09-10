<template>
  <section class="mx-auto flex min-h-screen max-w-lg flex-col justify-center px-4 py-10">
    <div class="rounded-[2.5rem] border border-slate-200 bg-white p-10 shadow-2xl shadow-slate-200/40">
      <div class="flex flex-col gap-4 text-center sm:flex-row sm:items-center sm:justify-between">
        <div class="mx-auto sm:mx-0">
          <img src="/images/logo-school-3.png" alt="Logo" class="mx-auto h-12 w-12 rounded-3xl bg-slate-100 p-2" />
          <h1 class="mt-5 text-3xl font-semibold tracking-tight text-slate-900">Connexion administrateur</h1>
          <p class="mt-2 text-sm leading-6 text-slate-600">Accédez au back-office en toute sécurité pour gérer l’école et les contenus.</p>
        </div>
      </div>

      <form class="mt-10 space-y-5" @submit.prevent="submitLogin">
        <div class="space-y-2">
          <label class="block text-sm font-semibold text-slate-700" for="email">Email</label>
          <input id="email" v-model="form.email" type="email" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-100" placeholder="admin@lanouvelleinstitution.ma" />
        </div>

        <div class="space-y-2">
          <label class="block text-sm font-semibold text-slate-700" for="password">Mot de passe</label>
          <input id="password" v-model="form.password" type="password" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-100" placeholder="••••••••" />
        </div>

        <p v-if="error" class="rounded-3xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ error }}</p>

        <button type="submit" class="w-full rounded-full bg-primary-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/20 transition hover:bg-primary-600">
          Se connecter
        </button>
      </form>
    </div>
  </section>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import api from '@/services/api/client'

const router = useRouter()
const route = useRoute()
const auth = useAuthStore()
const form = reactive({ email: 'admin@lanouvelleinstitution.ma', password: 'password' })
const error = ref('')

const submitLogin = async () => {
  error.value = ''
  try {
    await fetch('/sanctum/csrf-cookie', {
      credentials: 'include',
    })

    const { data } = await api.post(
      '/auth/login',
      new URLSearchParams({
        email: form.email,
        password: form.password,
      }),
      {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
      },
    )
    const token = data?.data?.token
    const user = data?.data?.user

    if (!token) {
      throw new Error('No token received')
    }

    auth.setSession(token, user)
    router.replace(route.query.redirect || '/admin')
  } catch (err) {
    error.value = err?.response?.data?.message || err?.response?.data?.errors?.email?.[0] || 'Connexion impossible.'
  }
}
</script>
