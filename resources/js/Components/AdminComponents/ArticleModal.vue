<template>
  <Teleport to="body">
    <Transition name="modal">
      <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div
          class="absolute inset-0 bg-black/50 backdrop-blur-sm"
          @click="handleClose"
        ></div>

        <!-- Modal -->
        <div
          class="relative w-full max-w-2xl overflow-hidden bg-white rounded-lg shadow-xl"
        >
          <!-- Header -->
          <div class="flex items-center justify-between p-6 border-b">
            <h2 class="text-2xl font-semibold text-gray-900">
              {{ isEditMode ? "Modifier l'article" : "Nouvel article" }}
            </h2>
            <button
              @click="handleClose"
              class="text-gray-400 transition-colors hover:text-gray-600"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          <!-- Form -->
          <form @submit.prevent="handleSubmit" class="p-6 space-y-6 overflow-y-auto max-h-[calc(90vh-140px)]">
            <!-- Title -->
            <div>
              <label for="title" class="block mb-2 text-sm font-medium text-gray-700">
                Titre de l'article *
              </label>
              <input
                id="title"
                v-model="formData.title"
                type="text"
                required
                class="w-full px-4 py-2 transition-all border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Entrez le titre de l'article"
              />
            </div>

            <!-- Title -->
            <div>
              <label for="content" class="block mb-2 text-sm font-medium text-gray-700">
                Content *
              </label>
              <textarea name="content" id="content" v-model="formData.content" cols="30" rows="10"></textarea>
            </div>

            <!-- Status -->
            <div>
              <label for="status" class="block mb-2 text-sm font-medium text-gray-700">
                Statut *
              </label>
              <select
                id="status"
                v-model="formData.status"
                required
                class="w-full px-4 py-2 transition-all border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="draft">Brouillon</option>
                <option value="published">Publié</option>
              </select>
            </div>

            <!-- Published Date -->
            <div>
              <label for="publishedAt" class="block mb-2 text-sm font-medium text-gray-700">
                Date de publication *
              </label>
              <input
                id="publishedAt"
                v-model="formData.publishedAt"
                type="date"
                required
                class="w-full px-4 py-2 transition-all border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>

            <!-- Stats (only in edit mode) -->
            <div v-if="isEditMode" class="grid grid-cols-3 gap-4">
              <div>
                <label for="views" class="block mb-2 text-sm font-medium text-gray-700">Vues</label>
                <input
                  id="views"
                  v-model.number="formData.views"
                  type="number"
                  min="0"
                  class="w-full px-4 py-2 transition-all border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
              </div>

              <div>
                <label for="comments" class="block mb-2 text-sm font-medium text-gray-700">Commentaires</label>
                <input
                  id="comments"
                  v-model.number="formData.comments"
                  type="number"
                  min="0"
                  class="w-full px-4 py-2 transition-all border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
              </div>

              <div>
                <label for="likes" class="block mb-2 text-sm font-medium text-gray-700">J'aime</label>
                <input
                  id="likes"
                  v-model.number="formData.likes"
                  type="number"
                  min="0"
                  class="w-full px-4 py-2 transition-all border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
              </div>
            </div>
          </form>

          <!-- Footer -->
          <div class="flex items-center justify-end gap-3 p-6 border-t bg-gray-50">
            <button
              type="button"
              @click="handleClose"
              class="px-5 py-2 font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
            >
              Annuler
            </button>
            <button
              type="submit"
              @click="handleSubmit"
              class="px-5 py-2 font-medium text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700"
            >
              {{ isEditMode ? "Mettre à jour" : "Créer" }}
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref, watch, computed } from 'vue'

const props = defineProps({
  isOpen: { type: Boolean, default: false },
  article: { type: Object, default: null }
})

const emit = defineEmits(['close', 'save'])

const isEditMode = computed(() => !!props.article)

const defaultForm = () => ({
  title: '',
  content: '',
  status: 'draft',
  publishedAt: new Date().toISOString().split('T')[0],
  views: 0,
  comments: 0,
  likes: 0
})

const formData = ref(defaultForm())

// ✅ Watch article changes to populate form
watch(
  () => props.article,
  (newArticle) => {
    if (newArticle) {
      formData.value = {
        id: newArticle.id,
        title: newArticle.title || '',
        content: newArticle.content || '',
        status: newArticle.status || 'draft',
        publishedAt: newArticle.publishedAt || new Date().toISOString().split('T')[0],
        views: newArticle.views || 0,
        comments: newArticle.comments || 0,
        likes: newArticle.likes || 0
      }
    } else {
      formData.value = defaultForm()
    }
  },
  { immediate: true }
)

const handleClose = () => {
  emit('close')
  formData.value = defaultForm() // always reset when closing
}

const handleSubmit = () => {
  emit('save', { ...formData.value })
  handleClose()
}
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}
.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
.modal-enter-active .relative,
.modal-leave-active .relative {
  transition: transform 0.3s ease;
}
.modal-enter-from .relative,
.modal-leave-to .relative {
  transform: scale(0.95);
}
</style>
