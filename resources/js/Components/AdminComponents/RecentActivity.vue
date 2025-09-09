<script setup lang="ts">
import { ref } from 'vue'
import {
  UserPlus,
  UserMinus,
  FileText,
  CreditCard,
  MessageSquare
} from 'lucide-vue-next'

const activities = ref([
  { id: 1, type: 'user_registered', title: 'Nouvel utilisateur inscrit', description: 'Marie Dubois a créé un compte', time: '5 min', icon: UserPlus },
  { id: 2, type: 'subscription_upgraded', title: 'Abonnement mis à niveau', description: 'Jean Martin est passé au plan Premium', time: '12 min', icon: CreditCard },
  { id: 3, type: 'lawyer_joined', title: 'Nouvel avocat', description: 'Maître Sophie Bernard a rejoint la plateforme', time: '1h', icon: UserPlus },
  { id: 4, type: 'document_uploaded', title: 'Document téléchargé', description: 'Contrat de vente uploadé par Pierre Legrand', time: '2h', icon: FileText },
  { id: 5, type: 'chat_consultation', title: 'Consultation chatbot', description: '45 nouvelles questions traitées', time: '3h', icon: MessageSquare },
  { id: 6, type: 'user_blocked', title: 'Utilisateur bloqué', description: 'Compte de Paul Durand suspendu', time: '4h', icon: UserMinus }
])

const getActivityColor = (type: string) => {
  switch (type) {
    case 'user_registered':
    case 'lawyer_joined': return 'bg-green-100 text-green-600'
    case 'user_blocked': return 'bg-red-100 text-red-600'
    case 'subscription_upgraded': return 'bg-yellow-100 text-yellow-600'
    default: return 'bg-blue-100 text-blue-600'
  }
}
</script>

<template>
  <div class="p-6 space-y-6 bg-white shadow dark:bg-neutral-800 rounded-xl">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Activité récente</h3>
      <button class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Voir tout</button>
    </div>

    <!-- Activity list -->
    <div class="space-y-4">
      <div
        v-for="activity in activities"
        :key="activity.id"
        class="flex items-start gap-4 p-3 transition rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-700"
      >
        <!-- Icon -->
        <div :class="`flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center ${getActivityColor(activity.type)}`">
          <component :is="activity.icon" class="w-5 h-5" />
        </div>

        <!-- Content -->
        <div class="flex items-start justify-between flex-1 gap-2">
          <div>
            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ activity.title }}</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ activity.description }}</p>
          </div>
          <span class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">{{ activity.time }}</span>
        </div>
      </div>
    </div>
  </div>
</template>
