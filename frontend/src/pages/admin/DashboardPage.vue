<template>
  <section class="mx-auto max-w-7xl space-y-6">
    <AdminPageHeader title="Tableau de bord" subtitle="Aperçu de l’activité et des indicateurs de l’établissement." />

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_8px_24px_rgba(15,23,42,0.04)] sm:p-6">
      <div>
        <h2 class="font-serif text-xl font-bold text-slate-900">Résumé rapide</h2>
        <p class="mt-1 text-xs text-slate-500">Indicateurs clés à vue d’ensemble.</p>
      </div>
      <div class="mt-6 grid gap-4 md:grid-cols-3">
        <div v-for="stat in summaryStats" :key="stat.label" class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
          <div class="flex items-center gap-3"><span :class="['flex h-10 w-10 items-center justify-center rounded-full', stat.iconBg]"><component :is="stat.icon" :size="19" /></span><p class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-500">{{ stat.label }}</p></div>
          <p class="mt-3 text-3xl font-bold text-slate-900">{{ stat.value }}</p>
          <span class="mt-3 inline-flex rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700">{{ stat.change }}</span>
          <p class="mt-2 text-[11px] text-slate-500">vs 7 derniers jours</p>
        </div>
      </div>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_8px_24px_rgba(15,23,42,0.04)] sm:p-6">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div><h2 class="font-serif text-lg font-bold text-slate-900">Activité des messages</h2><p class="mt-1 text-xs text-slate-500">Analyse des messages reçus sur les 7 derniers jours.</p></div>
        <span class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-600">7 derniers jours</span>
      </div>
      <div class="mt-6 grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-center">
        <div class="space-y-3">
          <div v-for="day in messagesTimeline" :key="day.date" class="grid grid-cols-[2rem_1fr_1.5rem] items-center gap-3 text-xs text-slate-500">
            <span>{{ day.label }}</span><div class="h-1.5 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-primary-500 transition-all" :style="{ width: `${day.barWidth}%` }"></div></div><span class="text-right">{{ day.value }}</span>
          </div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-5">
          <div class="flex items-center gap-3"><span class="flex h-9 w-9 items-center justify-center rounded-full bg-orange-50 text-primary-500"><TrendingUp :size="18" /></span><h3 class="text-sm font-bold text-slate-900">Tendance des messages</h3></div>
          <p class="mt-7 text-3xl font-bold text-slate-900">{{ dashboardData.messages_last_7_days ?? 0 }}</p><p class="mt-1 text-xs text-slate-500">Total sur 7 derniers jours</p>
          <span class="mt-5 inline-flex rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700">↑ {{ dashboardData.messages_last_7_days ? '100%' : '0%' }} <span class="ml-1 font-normal text-slate-500">vs période précédente</span></span>
        </div>
      </div>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_8px_24px_rgba(15,23,42,0.04)] sm:p-6">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between"><div><h2 class="font-serif text-lg font-bold text-slate-900">Évolution quotidienne des messages</h2><p class="mt-1 text-xs text-slate-500">Suivi détaillé de l’évolution sur la période sélectionnée.</p></div><span class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-600">7 derniers jours</span></div>
      <div class="mt-5 overflow-hidden rounded-xl bg-white">
          <svg viewBox="0 0 320 110" class="h-28 w-full">
            <defs>
              <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="rgba(249, 115, 22, 0.22)" />
                <stop offset="100%" stop-color="rgba(249, 115, 22, 0)" />
              </linearGradient>
            </defs>
            <g opacity="0.35">
              <line x1="16" y1="22" x2="304" y2="22" stroke="#cbd5e1" stroke-width="1" />
              <line x1="16" y1="46" x2="304" y2="46" stroke="#cbd5e1" stroke-width="1" />
              <line x1="16" y1="70" x2="304" y2="70" stroke="#cbd5e1" stroke-width="1" />
              <line x1="16" y1="94" x2="304" y2="94" stroke="#cbd5e1" stroke-width="1" />
            </g>
            <line x1="16" y1="94" x2="304" y2="94" stroke="#94a3b8" stroke-width="1.5" />
            <text x="18" y="18" class="text-[10px] fill-slate-500">{{ chartMax }}</text>
            <text x="18" y="68" class="text-[10px] fill-slate-500">{{ chartMid }}</text>
            <text x="18" y="108" class="text-[10px] fill-slate-500">0</text>
            <path
              v-if="chartPoints"
              :d="`M ${chartPoints}`"
              fill="none"
              stroke="#f97316"
              stroke-width="3"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <polyline
              v-if="chartPoints"
              :points="chartPoints"
              fill="none"
              stroke="rgba(249, 115, 22, 0.55)"
              stroke-width="12"
              stroke-linecap="round"
              stroke-linejoin="round"
              opacity="0.18"
            />
            <path
              v-if="chartPoints"
              :d="chartAreaPath"
              fill="url(#chartGradient)"
              opacity="0.9"
            />
            <g>
              <circle
                v-for="(point, index) in chartPointArray"
                :key="index"
                :cx="point.x"
                :cy="point.y"
                r="4"
                fill="#f97316"
                stroke="#fff"
                stroke-width="2"
              >
                <title>{{ point.label }} : {{ point.value }}</title>
              </circle>
            </g>
            <g>
              <text
                v-for="(point, index) in chartPointArray"
                :key="`label-${index}`"
                :x="point.x"
                y="108"
                class="text-[9px] fill-slate-500"
                text-anchor="middle"
              >
                {{ point.label }}
              </text>
            </g>
          </svg>
        </div>
    </section>
  </section>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { Eye, Image, Mail, TrendingUp } from 'lucide-vue-next'
import { getAdminDashboard } from '@/services/api/admin'
import AdminPageHeader from '@/components/admin.js'

const dashboardData = ref({})
const messagesByDay = ref([])

const summaryStats = computed(() => [
  { label: 'Messages au total', value: dashboardData.value.messages_total ?? 0, change: '↑ 100%', icon: Mail, iconBg: 'bg-orange-50 text-primary-500' },
  { label: 'Messages non lus', value: dashboardData.value.messages_unread ?? 0, change: '↑ 100%', icon: Eye, iconBg: 'bg-blue-50 text-blue-600' },
  { label: 'Images de galerie', value: dashboardData.value.gallery_images_total ?? 0, change: '↑ 22%', icon: Image, iconBg: 'bg-emerald-50 text-emerald-600' },
])

const messagesTimeline = computed(() => {
  const values = messagesByDay.value || []
  const maxValue = Math.max(...values.map((item) => item.value), 1)
  const dayLabels = { Mon: 'Lun', Tue: 'Mar', Wed: 'Mer', Thu: 'Jeu', Fri: 'Ven', Sat: 'Sam', Sun: 'Dim' }
  return values.map((item) => ({
    ...item,
    label: dayLabels[item.label] || item.label,
    barWidth: Math.round((item.value / maxValue) * 100),
  }))
})

const chartPointArray = computed(() => {
  const points = messagesTimeline.value
  if (!points.length) return []

  const xStep = 288 / Math.max(points.length - 1, 1)
  const maxValue = Math.max(...points.map((item) => item.value), 1)

  return points.map((item, index) => ({
    x: Math.round(16 + index * xStep),
    y: 94 - Math.round((item.value / maxValue) * 80),
    label: item.label,
    value: item.value,
  }))
})

const chartPoints = computed(() => {
  return chartPointArray.value.map((point) => `${point.x},${point.y}`).join(' ')
})

const chartAreaPath = computed(() => {
  const points = chartPointArray.value
  if (!points.length) return ''
  const line = points.map((point) => `${point.x},${point.y}`).join(' ')
  return `M ${points[0].x},${points[0].y} L ${line} L ${points[points.length - 1].x},94 L ${points[0].x},94 Z`
})

const chartMax = computed(() => {
  const maxValue = Math.max(...messagesTimeline.value.map((item) => item.value), 1)
  return Math.ceil(maxValue / 10) * 10
})

const chartMid = computed(() => {
  return Math.round((chartMax.value || 0) / 2)
})

const loadDashboard = async () => {
  try {
    const data = await getAdminDashboard()
    dashboardData.value = data
    messagesByDay.value = data.messages_by_day ?? []
  } catch (error) {
    console.warn('Unable to load dashboard data', error)
  }
}

onMounted(loadDashboard)
</script>
