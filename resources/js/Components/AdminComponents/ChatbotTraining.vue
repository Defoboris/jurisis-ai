<script setup>
import { ref } from 'vue'
import { Upload, Trash2, Pencil } from 'lucide-vue-next'

const trainingData = ref([
  { id: 1, question: 'Comment résilier un bail commercial ?', answer: 'Pour résilier un bail commercial...', category: 'Droit commercial', status: 'active', lastUpdated: '2024-01-15' },
  { id: 2, question: 'Quels sont les délais de préavis pour un licenciement ?', answer: 'Les délais de préavis varient...', category: 'Droit du travail', status: 'active', lastUpdated: '2024-01-10' },
  { id: 3, question: 'Comment calculer une pension alimentaire ?', answer: 'Le calcul de la pension alimentaire...', category: 'Droit de la famille', status: 'pending', lastUpdated: '2024-01-05' }
])

const newEntry = ref({ question: '', answer: '', category: '' })
const categories = ['Droit des affaires','Droit immobilier','Droit de la famille','Droit du travail','Droit pénal','Droit civil','Droit fiscal','Droit commercial']

const addTrainingEntry = () => {
  if (!newEntry.value.question || !newEntry.value.answer) return
  trainingData.value.unshift({ id: Date.now(), ...newEntry.value, status: 'pending', lastUpdated: new Date().toISOString().split('T')[0] })
  newEntry.value = { question: '', answer: '', category: '' }
}

const removeEntry = (id) => {
  trainingData.value = trainingData.value.filter(item => item.id !== id)
}

const getStatusBadgeClass = (status) => status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
const getStatusLabel = (status) => status === 'active' ? 'Actif' : 'En attente'
</script>

<template>
  <div class="p-6 space-y-8 bg-gray-50 dark:bg-gray-900">
    
    <!-- Add New Training Entry -->
    <div class="p-6 space-y-6 bg-white shadow-md dark:bg-gray-800 rounded-2xl">
      <h2 class="pb-2 mb-4 text-xl font-bold text-gray-900 border-b dark:text-white">Ajouter une donnée d'entraînement</h2>
      <form @submit.prevent="addTrainingEntry" class="space-y-4">
        <div class="grid gap-4 md:grid-cols-2">
          <div>
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Catégorie</label>
            <select v-model="newEntry.category" required class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-400">
              <option value="">Sélectionner</option>
              <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Question</label>
          <input v-model="newEntry.question" type="text" placeholder="Question fréquente..." required
                 class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-400"/>
        </div>

        <div>
          <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Réponse</label>
          <textarea v-model="newEntry.answer" rows="4" placeholder="Réponse détaillée..." required
                    class="w-full px-4 py-2 border rounded-lg resize-y dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-400"/>
        </div>

        <div class="flex justify-end">
          <button type="submit" class="flex items-center gap-2 px-4 py-2 text-white transition rounded-lg bg-primary hover:bg-green-700">
            <Upload class="w-4 h-4"/> Ajouter
          </button>
        </div>
      </form>
    </div>

    <!-- Existing Training Data -->
    <div class="p-6 space-y-6 bg-white shadow-md dark:bg-gray-800 rounded-2xl">
      <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
        <h2 class="pb-2 mb-0 text-xl font-bold text-gray-900 border-b dark:text-white md:mb-0">Données existantes</h2>
        <div class="flex gap-2">
          <button class="px-3 py-1 text-gray-700 border rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Importer CSV</button>
          <button class="px-3 py-1 text-gray-700 border rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Exporter</button>
        </div>
      </div>

      <div class="space-y-4">
        <div v-for="item in trainingData" :key="item.id" class="p-4 transition border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
          <div class="flex flex-col items-start justify-between gap-2 mb-2 md:items-center md:flex-row">
            <div class="flex flex-wrap items-center gap-2">
              <span class="px-2 py-1 text-sm text-green-800 bg-blue-100 rounded-lg">{{ item.category }}</span>
              <span :class="`px-2 py-1 text-sm rounded-lg ${getStatusBadgeClass(item.status)}`">{{ getStatusLabel(item.status) }}</span>
            </div>
            <div class="flex gap-2">
              <button class="p-1 rounded text-primary hover:bg-blue-100"><Pencil class="w-4 h-4"/></button>
              <button @click="removeEntry(item.id)" class="p-1 text-red-500 rounded hover:bg-red-100"><Trash2 class="w-4 h-4"/></button>
            </div>
          </div>

          <div class="space-y-1">
            <p><strong>Q:</strong> {{ item.question }}</p>
            <p><strong>R:</strong> {{ item.answer }}</p>
          </div>

          <div class="mt-2 text-sm text-right text-gray-500 dark:text-gray-400">
            Dernière modification: {{ item.lastUpdated }}
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
