<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'

import {
  UserPlus,
  Plus,
  Settings,
  FileUp,
  BarChart3,
  Bell,
  Users
} from 'lucide-vue-next'

const actions = [
  { id: 'super-admin.user-management', title: 'Gestion des utilisateur', description: 'Utilisateur', icon: Users, color: 'blue' },
  { id: 'super-admin.lawyerManagement', title: 'Nouveau avocat', description: 'Enregistrer un avocat', icon: Plus, color: 'green' },
  { id: 'super-admin.chatbot-management', title: 'Configuration', description: 'Paramètres système', icon: Settings, color: 'gray' },
  { id: 'super-admin.subscriptionManagement', title: 'Gestion des abonnements', description: 'Gérer les ressources', icon: FileUp, color: 'yellow' },
  { id: 'super-admin.subscriptions', title: 'Gérer les formules d’abonnement', description: 'Formules', icon: BarChart3, color: 'teal' },
  { id: 'super-admin.chatbot-management', title: 'Notifications', description: 'Centre de notifications', icon: Bell, color: 'purple' }
]

const handleAction = (actionId: string) => {
  
}
</script>

<template>
  <div class="p-6 space-y-6 bg-white shadow dark:bg-neutral-800 rounded-xl">
    <!-- Header -->
    <div class="space-y-1">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Actions rapides</h3>
      <p class="text-sm text-gray-500 dark:text-gray-400">Tâches d'administration courantes</p>
    </div>

    <!-- Actions grid -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
      <Link
        v-for="action in actions"
        :key="action.id"
       :href="route(action.id)"
        :class="`group flex flex-col items-center p-4 bg-white dark:bg-neutral-700 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1 border border-gray-200 dark:border-neutral-600`"
      >
        <!-- Icon -->
        <div :class="`flex items-center justify-center w-12 h-12 rounded-full mb-3 bg-${action.color}-100 group-hover:bg-${action.color}-200 transition`">
          <component :is="action.icon" :class="`w-6 h-6 text-${action.color}-600 group-hover:text-${action.color}-800 transition`" />
        </div>

        <!-- Content -->
        <div class="text-center">
          <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ action.title }}</h4>
          <p class="text-xs text-gray-500 dark:text-gray-400">{{ action.description }}</p>
        </div>
      </Link>
    </div>
  </div>
</template>
