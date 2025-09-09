<script setup lang="ts">
import { computed } from 'vue'
import {
  Users,
  UserRound,
  CreditCard,
  Banknote,
  BarChart3,
  TrendingUp,
  TrendingDown
} from 'lucide-vue-next'

interface Props {
  title: string
  value: string
  change: string
  trend: 'up' | 'down'
  icon: string
}

const props = defineProps<Props>()

const iconComponent = computed(() => {
  switch (props.icon) {
    case 'users': return UserRound
    case 'lawyers': return Users
    case 'subscriptions': return CreditCard
    case 'revenue': return Banknote
    default: return BarChart3
  }
})

const trendIcon = computed(() => props.trend === 'up' ? TrendingUp : TrendingDown)
</script>

<template>
  <div class="flex flex-col gap-4 p-6 transition bg-white shadow dark:bg-neutral-800 rounded-xl hover:shadow-lg">
    <!-- Header: Icon + Trend -->
    <div class="flex items-start justify-between">
      <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg dark:bg-blue-900">
        <component :is="iconComponent" class="w-6 h-6 text-blue-600 dark:text-blue-300"/>
      </div>

      <div :class="props.trend === 'up' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'" 
           class="flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full">
        <component :is="trendIcon" class="w-3 h-3"/>
        {{ props.change }}
      </div>
    </div>

    <!-- Content: Title + Value -->
    <div class="flex flex-col gap-1">
      <span class="text-sm text-gray-500 dark:text-gray-400">{{ props.title }}</span>
      <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ props.value }}</span>
    </div>
  </div>
</template>
