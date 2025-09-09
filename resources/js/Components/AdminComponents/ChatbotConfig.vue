<script setup>
import { ref } from 'vue'

const config = ref({
  name: 'Jurisis AI',
  welcomeMessage: "Bonjour ! Je suis votre assistant juridique AI. Comment puis-je vous aider aujourd'hui ?",
  maxResponseLength: 500,
  responseStyle: 'professional',
  enabledDomains: {
    immobilier: true,
    travail: true,
    famille: true,
    affaires: true,
    penal: false,
    civil: true,
    fiscal: true,
    commercial: true
  },
  confidenceThreshold: 0.8,
  fallbackToHuman: true,
  collectUserFeedback: true,
  learningMode: true
})

const responseStyles = [
  { value: 'professional', label: 'Professionnel' },
  { value: 'friendly', label: 'Amical' },
  { value: 'formal', label: 'Formel' }
]

const saveConfig = () => {
  console.log('Saving chatbot config:', config.value)
}
</script>

<template>
  <div class="p-6 space-y-8 bg-gray-50 dark:bg-gray-900">
    <!-- Basic Settings -->
    <div class="p-6 space-y-6 bg-white shadow-md dark:bg-gray-800 rounded-2xl">
      <h2 class="pb-2 mb-4 text-xl font-bold text-gray-900 border-b dark:text-white">Configuration de base</h2>
      
      <div class="space-y-4">
        <div>
          <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Nom du chatbot</label>
          <input v-model="config.name" type="text" placeholder="Jurisis AI"
                 class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white"/>
        </div>

        <div>
          <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Message d'accueil</label>
          <textarea v-model="config.welcomeMessage" rows="3"
                    placeholder="Message affiché lors du premier contact"
                    class="w-full px-4 py-2 border rounded-lg resize-y focus:ring-2 focus:ring-green-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div>
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Style de réponse</label>
            <select v-model="config.responseStyle"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <option v-for="style in responseStyles" :key="style.value" :value="style.value">{{ style.label }}</option>
            </select>
          </div>

          <div>
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Longueur max des réponses</label>
            <input v-model.number="config.maxResponseLength" type="number" min="100" max="1000" step="50"
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white"/>
          </div>
        </div>
      </div>
    </div>

    <!-- Legal Domains -->
    <div class="p-6 space-y-4 bg-white shadow-md dark:bg-gray-800 rounded-2xl">
      <h2 class="pb-2 mb-4 text-xl font-bold text-gray-900 border-b dark:text-white">Domaines juridiques activés</h2>
      <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
        <label v-for="(enabled, domain) in config.enabledDomains" :key="domain"
               class="flex items-center gap-2 p-3 transition border rounded-lg cursor-pointer hover:bg-blue-50 dark:hover:bg-green-900">
          <input type="checkbox" v-model="config.enabledDomains[domain]" class="w-5 h-5 border-gray-400 rounded text-primary"/>
          <span class="text-gray-700 capitalize dark:text-gray-300">{{ domain }}</span>
        </label>
      </div>
    </div>

    <!-- Advanced Settings -->
    <div class="p-6 space-y-4 bg-white shadow-md dark:bg-gray-800 rounded-2xl">
      <h2 class="pb-2 mb-4 text-xl font-bold text-gray-900 border-b dark:text-white">Paramètres avancés</h2>
      
      <div>
        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Seuil de confiance ({{ config.confidenceThreshold }})</label>
        <input type="range" v-model.number="config.confidenceThreshold" min="0.5" max="1" step="0.1"
               class="w-full h-2 bg-gray-200 rounded-lg accent-primary"/>
        <div class="flex justify-between mt-1 text-sm text-gray-500 dark:text-gray-400">
          <span>0.5</span>
          <span>Plus strict</span>
          <span>1.0</span>
        </div>
      </div>

      <div class="flex flex-col space-y-2 md:flex-row md:space-x-6 md:space-y-0">
        <label class="inline-flex items-center gap-2">
          <input type="checkbox" v-model="config.fallbackToHuman" class="w-5 h-5 border-gray-400 rounded text-primary"/>
          <span class="text-gray-700 dark:text-gray-300">Rediriger vers un humain si confiance faible</span>
        </label>

        <label class="inline-flex items-center gap-2">
          <input type="checkbox" v-model="config.collectUserFeedback" class="w-5 h-5 border-gray-400 rounded text-primary"/>
          <span class="text-gray-700 dark:text-gray-300">Collecter les retours utilisateur</span>
        </label>

        <label class="inline-flex items-center gap-2">
          <input type="checkbox" v-model="config.learningMode" class="w-5 h-5 border-gray-400 rounded text-primary"/>
          <span class="text-gray-700 dark:text-gray-300">Mode apprentissage activé</span>
        </label>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col justify-end gap-4 md:flex-row">
      <button type="button"
              class="px-6 py-2 text-gray-700 transition border border-gray-300 rounded-lg dark:border-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
        Réinitialiser
      </button>
      <button type="submit" @click="saveConfig"
              class="px-6 py-2 text-white transition rounded-lg bg-primary hover:bg-green-700">
        Sauvegarder les modifications
      </button>
    </div>
  </div>
</template>
