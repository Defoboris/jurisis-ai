<template>
  <aside
    class="fixed inset-y-0 left-0 z-30 flex flex-col transition-transform duration-300 ease-in-out transform bg-white border-r border-gray-200 w-72 lg:translate-x-0 lg:static"
    :class="{ '-translate-x-full': !sidebarOpen }"
  >
    <!-- Header -->
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
      <div class="flex items-center gap-2">
        <h2 class="text-xl font-bold text-primary">Jurisis</h2>
        <span class="bg-primary text-white px-2 py-0.5 rounded text-xs font-semibold uppercase">Admin</span>
      </div>
      <button
        class="p-2 text-gray-500 rounded lg:hidden hover:bg-gray-100"
        @click="$emit('close')"
      >
        <X class="w-6 h-6" />
      </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-4 overflow-y-auto">
      <ul class="space-y-1">
        <li v-for="item in menuItems" :key="item.id">
          <button
            class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 transition"
            :class="currentPage === item.id ? 'bg-primary text-white hover:bg-indigo-700' : ''"
            @click="$emit('pageChange', item.id)"
          >
            <component :is="item.icon" class="w-5 h-5" />
            <span class="font-medium">{{ item.label }}</span>
          </button>
        </li>
      </ul>
    </nav>

    <!-- Footer -->
    <div class="px-6 py-4 border-t border-gray-200">
      <div class="flex items-center gap-3">
        <div class="flex items-center justify-center w-10 h-10 text-sm font-semibold text-white rounded-full bg-primary">
          SA
        </div>
        <div>
          <div class="text-sm font-semibold">Super Admin</div>
          <div class="text-xs text-gray-500">Administrateur</div>
        </div>
      </div>
    </div>
  </aside>
</template>
<script setup lang="ts">
import { 
  X,
  Home,
  Users,
  UserRound,
  CreditCard,
  MessageSquare,
  BarChart3
} from 'lucide-vue-next'
import { usePage } from '@inertiajs/vue3'

interface Props {
  currentPage: string
  sidebarOpen: boolean
}

defineProps<Props>()
const emit = defineEmits<{
  pageChange: [page: string]
  close: []
}>()

const menuItems = [
  { id: 'dashboard', label: 'Tableau de bord', icon: Home },
  { id: 'users', label: 'Utilisateurs', icon: Users },
  { id: 'lawyers', label: 'Avocats', icon: UserRound },
  { id: 'subscriptions', label: 'Abonnements', icon: CreditCard },
  { id: 'chatbot', label: 'Chatbot', icon: MessageSquare },
  { id: 'analytics', label: 'Analytiques', icon: BarChart3 }
]
</script>
