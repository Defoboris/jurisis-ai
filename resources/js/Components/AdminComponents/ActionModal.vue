<script setup lang="ts">
import { 
  X, 
  AlertTriangle, 
  Info 
} from 'lucide-vue-next'

interface Props {
  title: string
  message: string
  confirmText: string
  cancelText: string
  type?: 'default' | 'destructive'
}

withDefaults(defineProps<Props>(), {
  type: 'default'
})

defineEmits<{
  confirm: []
  cancel: []
}>()
</script>

<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
    <div 
      class="w-full max-w-lg bg-white shadow-xl rounded-2xl dark:bg-neutral-900 animate-scale-in"
    >
      <div class="p-6">
        <!-- Header -->
        <div class="flex items-start justify-between gap-4">
          <div class="flex items-start gap-4">
            <div 
              class="flex items-center justify-center w-12 h-12 rounded-full shrink-0"
              :class="type === 'destructive' 
                ? 'bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-400' 
                : 'bg-blue-100 text-blue-600 dark:bg-blue-900/40 dark:text-blue-400'"
            >
              <component
                :is="type === 'destructive' ? AlertTriangle : Info"
                class="w-6 h-6"
              />
            </div>
            <div class="flex flex-col">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ title }}
              </h3>
              <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                {{ message }}
              </p>
            </div>
          </div>
          <button 
            class="p-2 text-gray-400 rounded-md hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-neutral-800 dark:hover:text-gray-200"
            @click="$emit('cancel')"
          >
            <X class="w-5 h-5" />
          </button>
        </div>

        <!-- Actions -->
        <div class="flex flex-col-reverse gap-3 mt-6 sm:flex-row sm:justify-end">
          <button 
            class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg sm:w-auto hover:bg-gray-50 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-200 dark:hover:bg-neutral-700"
            @click="$emit('cancel')"
          >
            {{ cancelText }}
          </button>
          <button 
            class="w-full px-4 py-2 text-sm font-medium text-white rounded-lg shadow-sm sm:w-auto"
            :class="type === 'destructive' 
              ? 'bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800' 
              : 'bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800'"
            @click="$emit('confirm')"
          >
            {{ confirmText }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@keyframes scale-in {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
.animate-scale-in {
  animation: scale-in 0.2s ease-out;
}
</style>
