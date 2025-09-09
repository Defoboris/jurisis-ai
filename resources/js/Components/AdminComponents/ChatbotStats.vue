<script setup>
const props = defineProps({
  stats: Object,
  recentQuestions: Array
})

const getRatingStars = (rating) => Array(5).fill(0).map((_, i) => i < rating)
</script>

<template>
  <div class="flex flex-col gap-8">
    <!-- Overview Stats -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
      <div class="p-6 transition bg-white shadow dark:bg-gray-800 rounded-xl hover:shadow-lg">
        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.totalQuestions.toLocaleString() }}</div>
        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">Questions totales</div>
      </div>
      <div class="p-6 transition bg-white shadow dark:bg-gray-800 rounded-xl hover:shadow-lg">
        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.todayQuestions }}</div>
        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">Questions aujourd'hui</div>
      </div>
      <div class="p-6 transition bg-white shadow dark:bg-gray-800 rounded-xl hover:shadow-lg">
        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.averageRating }}/5</div>
        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">Note moyenne</div>
      </div>
      <div class="p-6 transition bg-white shadow dark:bg-gray-800 rounded-xl hover:shadow-lg">
        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.responseTime }}</div>
        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">Temps de réponse</div>
      </div>
      <div class="p-6 transition bg-white shadow dark:bg-gray-800 rounded-xl hover:shadow-lg">
        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.satisfactionRate }}</div>
        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">Taux de satisfaction</div>
      </div>
    </div>

    <!-- Content Section -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
      <!-- Popular Topics -->
      <div class="p-6 bg-white shadow dark:bg-gray-800 rounded-xl">
        <h4 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Sujets populaires</h4>
        <div class="space-y-4">
          <div v-for="topic in stats.popularTopics" :key="topic.topic">
            <div class="flex items-center justify-between mb-1">
              <span class="font-medium text-gray-800 dark:text-gray-200">{{ topic.topic }}</span>
              <span class="text-sm text-gray-500 dark:text-gray-400">{{ topic.count.toLocaleString() }} questions</span>
            </div>
            <div class="w-full h-3 overflow-hidden bg-gray-200 rounded-full dark:bg-gray-700">
              <div
                class="h-3 rounded-full bg-primary"
                :style="{ width: topic.percentage + '%' }"
              ></div>
            </div>
            <div class="mt-1 text-sm font-medium text-right text-gray-700 dark:text-gray-300">{{ topic.percentage }}%</div>
          </div>
        </div>
      </div>

      <!-- Recent Questions -->
      <div class="p-6 bg-white shadow dark:bg-gray-800 rounded-xl">
        <h4 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Questions récentes</h4>
        <div class="space-y-4">
          <div
            v-for="question in recentQuestions"
            :key="question.id"
            class="flex items-start justify-between p-4 transition rounded-lg bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800"
          >
            <div class="flex-1">
              <p class="font-medium text-gray-900 dark:text-white">{{ question.question }}</p>
              <div class="flex items-center gap-2 mt-1">
                <span class="text-xs px-2 py-0.5 bg-blue-100 dark:bg-green-800 text-primary dark:text-blue-200 rounded-full">{{ question.category }}</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">{{ question.timestamp }}</span>
              </div>
            </div>
            <div class="flex items-center gap-0.5">
              <span
                v-for="(filled, index) in getRatingStars(question.rating)"
                :key="index"
                class="text-yellow-400 dark:text-yellow-300"
              >★</span>
              <span v-for="(_, index) in 5 - question.rating" :key="'empty' + index" class="text-gray-300 dark:text-gray-600">★</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
