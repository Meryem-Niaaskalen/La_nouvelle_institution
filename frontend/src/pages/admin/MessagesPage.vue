<template>
  <section class="mx-auto max-w-7xl space-y-5">
    <AdminPageHeader title="Messages reçus" subtitle="Consultez et gérez les demandes envoyées depuis le site." />

    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-[0_8px_24px_rgba(15,23,42,0.05)] sm:p-5">
      <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div class="flex min-w-0 flex-1 flex-col gap-3 sm:flex-row">
          <div class="relative min-w-0 flex-1"><Search :size="18" class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" /><input v-model="search" type="text" placeholder="Rechercher un nom, sujet ou email" class="w-full rounded-lg border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-primary-500" /></div>
          <button type="button" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-3 text-xs font-semibold text-slate-700 hover:border-slate-300" @click="showOnlyUnread = !showOnlyUnread"><ListFilter :size="16" />{{ showOnlyUnread ? 'Afficher tous' : 'Non lus seulement' }}</button>
          <button type="button" class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary-500 px-4 py-3 text-xs font-semibold text-white shadow-sm hover:bg-primary-600 disabled:opacity-60" @click="loadMessages(true)" :disabled="loading"><RefreshCw :size="16" :class="loading ? 'animate-spin' : ''" />Rafraîchir</button>
        </div>
        <div class="grid grid-cols-3 gap-3 xl:w-[29rem]">
          <div v-for="stat in summaryStats" :key="stat.label" class="rounded-xl border border-slate-200 bg-slate-50/60 p-3 text-center"><div class="flex items-center justify-center gap-2"><span :class="['flex h-7 w-7 items-center justify-center rounded-full', stat.iconBg]"><component :is="stat.icon" :size="14" /></span><p class="hidden text-[10px] font-bold uppercase tracking-[0.12em] text-slate-500 sm:block">{{ stat.label }}</p></div><p class="mt-2 text-2xl font-bold text-slate-900">{{ stat.value }}</p></div>
        </div>
      </div>
      <div class="mt-4 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-500"><span>{{ filteredMessages.length }} message{{ filteredMessages.length > 1 ? 's' : '' }}</span><span>Dernière mise à jour : {{ lastUpdatedText }}</span></div>
      <div v-if="newMessagesAlert" class="mt-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-xs font-medium text-green-700">{{ newMessagesAlert }}</div>
    </section>

    <div class="grid gap-5 xl:grid-cols-[1fr_1.02fr]">
      <section class="min-h-[35rem] rounded-2xl border border-slate-200 bg-white p-3 shadow-[0_8px_24px_rgba(15,23,42,0.05)] sm:p-5">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4"><h2 class="text-base font-bold text-slate-900">Boîte de réception</h2><span class="text-xs font-medium text-slate-500">Plus récents</span></div>
        <div v-if="loading" class="p-10 text-center text-sm text-slate-500">Chargement des messages...</div>
        <div v-else-if="!filteredMessages.length" class="p-10 text-center text-sm text-slate-500">Aucun message ne correspond à votre recherche.</div>
        <div v-else class="mt-4 space-y-3">
          <button v-for="message in filteredMessages" :key="message.id" type="button" class="w-full rounded-xl border p-3 text-left transition sm:p-4" :class="selectedMessage?.id === message.id ? 'border-primary-300 bg-orange-50/50 shadow-sm' : 'border-slate-200 bg-white hover:border-primary-200 hover:bg-slate-50'" @click="selectMessage(message)">
            <div class="flex items-start justify-between gap-3"><div class="flex min-w-0 items-start gap-3"><span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full" :class="message.is_read ? 'bg-slate-200' : 'bg-primary-500'"></span><div class="min-w-0"><div class="flex flex-wrap items-center gap-2"><p class="truncate text-sm font-bold text-slate-900">{{ message.name }}</p><span v-if="message.is_important" class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-amber-100 text-amber-600" title="Important"><Star :size="12" fill="currentColor" /></span></div><p class="mt-1 truncate text-xs text-slate-600">{{ message.subject }}</p></div></div><div class="flex shrink-0 flex-wrap items-center justify-end gap-2">
              <span v-if="message.is_important" class="shrink-0 rounded-full bg-amber-50 px-2 py-1 text-[10px] font-semibold text-amber-700">Important</span>
              <span v-if="!message.is_read" class="shrink-0 rounded-full bg-orange-50 px-2 py-1 text-[10px] font-semibold text-primary-700">Nouveau</span>
            </div></div>
            <p class="mt-3 line-clamp-2 pl-5 text-xs leading-5 text-slate-600 break-words">{{ message.message }}</p><div class="mt-3 flex flex-wrap justify-between gap-2 pl-5 text-[11px] text-slate-500"><span class="inline-flex items-center gap-1.5"><CalendarDays :size="13" />{{ formatDate(message.created_at) }}</span><span class="truncate max-w-[11rem]">{{ message.email }}</span></div>
          </button>
        </div>
      </section>

      <section v-if="selectedMessage" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-[0_8px_24px_rgba(15,23,42,0.05)] sm:p-6">
        <div class="flex flex-col gap-3 border-b border-slate-100 pb-5 sm:flex-row sm:items-start sm:justify-between"><div><h2 class="text-lg font-bold text-slate-900">Détail du message</h2><p class="mt-1 text-xs text-slate-500">Informations complètes et actions rapides pour gérer la conversation.</p></div><div class="flex flex-wrap items-center gap-2"><span v-if="selectedMessage.is_important" class="inline-flex items-center gap-1.5 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-[11px] font-semibold text-amber-700"><Star :size="12" fill="currentColor" />Important</span><span class="inline-flex items-center gap-1.5 rounded-lg border border-primary-200 bg-orange-50 px-3 py-2 text-[11px] font-semibold text-primary-700"><span class="h-2 w-2 rounded-full bg-primary-500"></span>{{ selectedMessage.is_read ? 'Traité' : 'À traiter' }}</span></div></div>
        <div class="divide-y divide-slate-100">
          <div class="flex gap-4 py-5"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-primary-500"><UserRound :size="19" /></span><div><p class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">Nom</p><p class="mt-2 text-sm font-semibold text-slate-900">{{ selectedMessage.name }}</p></div></div>
          <div class="flex gap-4 py-5"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><Mail :size="19" /></span><div class="min-w-0"><p class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">Email</p><a v-if="selectedMessage.email" :href="emailUrl(selectedMessage)" target="_blank" rel="noopener" class="mt-2 block break-all text-sm font-semibold text-blue-600 hover:underline">{{ selectedMessage.email }}</a><p v-else class="mt-2 text-sm text-slate-500">Non renseigné</p><a v-if="selectedMessage.email" :href="emailUrl(selectedMessage)" target="_blank" rel="noopener" class="mt-3 inline-flex items-center gap-2 rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100"><Mail :size="14" /> Envoyer un email</a></div></div>
          <div v-if="selectedMessage.phone" class="flex gap-4 py-5"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600"><Phone :size="19" /></span><div><p class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">Téléphone</p><a :href="whatsappUrl(selectedMessage.phone)" target="_blank" rel="noopener" class="mt-2 block text-sm font-semibold text-green-600 hover:underline">{{ selectedMessage.phone }} · WhatsApp</a></div></div>
          <div class="flex gap-4 py-5"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-primary-500"><FileText :size="19" /></span><div><p class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">Sujet</p><p class="mt-2 text-sm font-semibold text-slate-900">{{ selectedMessage.subject }}</p></div></div>
          <div class="flex gap-4 py-5"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-primary-500"><MessageSquare :size="19" /></span><div><p class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">Message</p><p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700">{{ selectedMessage.message }}</p></div></div>
        </div>
        <div class="flex flex-col gap-3 pt-5 sm:flex-row sm:flex-wrap"><button type="button" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary-500 px-4 py-3 text-xs font-semibold text-white hover:bg-primary-600 sm:w-auto" @click="markAsRead(selectedMessage)"><Mail :size="16" />{{ selectedMessage.is_read ? 'Marquer non lu' : 'Marquer comme lu' }}</button><button type="button" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-300 px-4 py-3 text-xs font-semibold text-slate-700 hover:bg-slate-50 sm:w-auto" @click="toggleImportant(selectedMessage)"><Star :size="16" />{{ selectedMessage.is_important ? 'Retirer important' : 'Marquer important' }}</button><button type="button" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-red-300 px-4 py-3 text-xs font-semibold text-red-600 hover:bg-red-50 sm:w-auto" @click="removeMessage(selectedMessage)"><Trash2 :size="16" />Supprimer</button></div>
      </section>
      <section v-else class="flex min-h-[35rem] items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-sm text-slate-500">Sélectionnez un message pour afficher ses détails.</section>
    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import { CalendarDays, Eye, FileText, ListFilter, Mail, MessageSquare, Phone, RefreshCw, Search, Star, Trash2, UserRound } from 'lucide-vue-next'
import { deleteAdminContactMessage, getAdminContactMessages, updateAdminContactMessage } from '@/services/api/admin'
import AdminPageHeader from '@/components/admin.js'

const loading = ref(true)
const search = ref('')
const showOnlyUnread = ref(false)
const messages = ref([])
const selectedMessage = ref(null)
const lastUpdated = ref(null)
const newMessagesAlert = ref('')
const initialLoad = ref(true)

const summaryStats = computed(() => [
  { label: 'Total', value: messages.value.length, icon: Mail, iconBg: 'bg-orange-50 text-primary-500' },
  { label: 'Non lus', value: messages.value.filter((message) => !message.is_read).length, icon: Eye, iconBg: 'bg-blue-50 text-blue-600' },
  { label: 'Importants', value: messages.value.filter((message) => message.is_important).length, icon: Star, iconBg: 'bg-indigo-50 text-indigo-700' },
])

const filteredMessages = computed(() => {
  const query = search.value.trim().toLowerCase()
  return messages.value.filter((message) => {
    const matchesUnread = showOnlyUnread.value ? !message.is_read : true
    const haystack = `${message.name} ${message.email} ${message.subject} ${message.message}`.toLowerCase()
    const matchesQuery = query ? haystack.includes(query) : true
    return matchesUnread && matchesQuery
  })
})

const formatDate = (value) => {
  if (!value) return 'Non renseigné'
  const date = new Date(value)
  return date.toLocaleString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })
}

const lastUpdatedText = computed(() => {
  if (!lastUpdated.value) return 'Jamais'
  return new Date(lastUpdated.value).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })
})

const whatsappUrl = (value) => {
  const digits = String(value || '').replace(/\D/g, '')
  if (!digits) return '#'
  const international = digits.startsWith('212') ? digits : digits.startsWith('0') ? `212${digits.slice(1)}` : digits
  return `https://wa.me/${international}`
}

const emailUrl = (message) => {
  const email = String(message?.email || '').trim()
  if (!email) return '#'
  const params = new URLSearchParams({
    view: 'cm',
    fs: '1',
    to: email,
    su: message.subject || '',
    body: message.message || '',
  })
  return `https://mail.google.com/mail/?${params.toString()}`
}

const loadMessages = async (silent = false) => {
  if (!silent) {
    loading.value = true
  }

  const previousIds = messages.value.map((message) => message.id)
  const loaded = await getAdminContactMessages()
  messages.value = Array.isArray(loaded) ? loaded : loaded?.data ?? []

  if (!selectedMessage.value && messages.value.length) {
    selectedMessage.value = messages.value[0]
  } else if (selectedMessage.value) {
    const found = messages.value.find((message) => message.id === selectedMessage.value.id)
    selectedMessage.value = found || messages.value[0] || null
  }

  if (!initialLoad.value) {
    const newCount = messages.value.filter((message) => !previousIds.includes(message.id)).length
    if (newCount > 0) {
      newMessagesAlert.value = `${newCount} nouveau${newCount > 1 ? 'x' : ''} message${newCount > 1 ? 's' : ''} reçu${newCount > 1 ? 's' : ''}`
      setTimeout(() => {
        newMessagesAlert.value = ''
      }, 5000)
    }
  }
  lastUpdated.value = Date.now()
  initialLoad.value = false
  loading.value = false
}
 
const selectMessage = (message) => {
  selectedMessage.value = message
}
const markAsRead = async (message) => {
  const nextValue = !message.is_read
  const updated = await updateAdminContactMessage(message.id, { is_read: nextValue, status: nextValue ? 'read' : 'new' })
  const index = messages.value.findIndex((item) => item.id === message.id)
  if (index !== -1) messages.value.splice(index, 1, { ...messages.value[index], ...updated })
  selectedMessage.value = messages.value[index]
}

const toggleImportant = async (message) => {
  const updated = await updateAdminContactMessage(message.id, { is_important: !message.is_important })
  const index = messages.value.findIndex((item) => item.id === message.id)
  if (index !== -1) messages.value.splice(index, 1, { ...messages.value[index], ...updated })
  selectedMessage.value = messages.value[index]
}

const removeMessage = async (message) => {
  await deleteAdminContactMessage(message.id)
  messages.value = messages.value.filter((item) => item.id !== message.id)
  selectedMessage.value = messages.value[0] ?? null
}

const handleVisibilityChange = () => {
  if (document.visibilityState === 'visible') {
    loadMessages()
  }
}

onMounted(() => {
  loadMessages()
  window.addEventListener('visibilitychange', handleVisibilityChange)
})

onUnmounted(() => {
  window.removeEventListener('visibilitychange', handleVisibilityChange)
})
</script>
