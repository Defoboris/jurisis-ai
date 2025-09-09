<script setup>
import { ref } from "vue";
import { MessageSquare, Settings, BarChart2, BookOpen } from "lucide-vue-next";

import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import ChatbotStats from "@/Components/AdminComponents/ChatbotStats.vue";
import ChatbotConfig from "@/Components/AdminComponents/ChatbotConfig.vue";
import ChatbotTraining from "@/Components/AdminComponents/ChatbotTraining.vue";

const activeTab = ref("stats");

const chatbotStats = ref({
  totalQuestions: 15647,
  todayQuestions: 234,
  averageRating: 4.2,
  responseTime: '1.2s',
  satisfactionRate: '87%',
  popularTopics: [
    { topic: 'Droit immobilier', count: 3421, percentage: 22 },
    { topic: 'Droit du travail', count: 2856, percentage: 18 },
    { topic: 'Droit de la famille', count: 2134, percentage: 14 },
    { topic: 'Droit des affaires', count: 1987, percentage: 13 },
    { topic: 'Droit pénal', count: 1543, percentage: 10 }
  ]
})

const tabs = [
  { id: "stats", label: "Statistiques", icon: BarChart2 },
  { id: "config", label: "Configuration", icon: Settings },
  { id: "training", label: "Formation", icon: BookOpen },
];

const recentQuestions = ref([
  {
    id: 1,
    question: 'Quels sont mes droits en cas de licenciement ?',
    category: 'Droit du travail',
    timestamp: '2 min',
    rating: 4,
    answered: true
  },
  {
    id: 2,
    question: 'Comment établir un contrat de vente immobilière ?',
    category: 'Droit immobilier', 
    timestamp: '5 min',
    rating: 5,
    answered: true
  },
  {
    id: 3,
    question: 'Procédure de divorce par consentement mutuel',
    category: 'Droit de la famille',
    timestamp: '8 min',
    rating: 3,
    answered: true
  }
])
</script>

<template>
  <AdminLayout>
    <div class="flex flex-col min-h-screen gap-8 p-6 bg-gray-50 dark:bg-gray-900">
    <!-- Page header -->
    <div
      class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center"
    >
      <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
          Gestion du chatbot
        </h1>
        <p class="mt-1 text-gray-500 dark:text-gray-400">
          Configurer et optimiser l'assistant IA juridique
        </p>
      </div>
      <div
        class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
      >
        <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
        <span class="text-sm font-medium text-green-600 dark:text-green-400"
          >En ligne</span
        >
      </div>
    </div>

    <!-- Tab navigation -->
    <div
      class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
    >
      <nav class="flex flex-col sm:flex-row">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          @click="activeTab = tab.id"
          :class="[
            'flex items-center gap-2 px-4 py-2 text-sm font-medium transition-colors rounded-lg m-1',
            activeTab === tab.id
              ? 'bg-primary text-white'
              : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700',
          ]"
        >
          <component :is="tab.icon" class="w-5 h-5" />
          {{ tab.label }}
        </button>
      </nav>
    </div>

    <!-- Tab content -->
    <div>
      <div v-show="activeTab === 'stats'" class="animate-fade-in">
        <ChatbotStats
          :stats="chatbotStats"
          :recent-questions="recentQuestions"
          class="p-6 bg-white rounded-lg shadow dark:bg-gray-800"
        />
      </div>
      <div v-show="activeTab === 'config'" class="animate-fade-in">
        <ChatbotConfig
          class="p-6 bg-white rounded-lg shadow dark:bg-gray-800"
        />
      </div>
      <div v-show="activeTab === 'training'" class="animate-fade-in">
        <ChatbotTraining
          class="p-6 bg-white rounded-lg shadow dark:bg-gray-800"
        />
      </div>
    </div>
  </div>
  </AdminLayout>
</template>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(8px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-in {
  animation: fade-in 0.2s ease-in-out;
}
</style>
