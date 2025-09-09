<script setup lang="ts">
import { Filter } from 'lucide-vue-next'

interface FilterOption {
  value: string
  label: string
}

interface Props {
  modelValue: string
  options: FilterOption[]
}

defineProps<Props>()
const emit = defineEmits<{
  'update:modelValue': (value: string) => void
}>()

const updateValue = (event: Event) => {
  const target = event.target as HTMLSelectElement
//   emit('update:modelValue', target)
}
</script>

<template>
  <div class="w-full max-w-xs">
    <div class="relative w-full">
      <Filter class="absolute w-5 h-5 text-gray-400 -translate-y-1/2 pointer-events-none left-3 top-1/2" />
      <select
        :value="modelValue"
        @change="updateValue"
        class="block w-full py-2 pl-10 pr-4 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg appearance-none dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-blue-400"
      >
        <option
          v-for="option in options"
          :key="option.value"
          :value="option.value"
        >
          {{ option.label }}
        </option>
      </select>
      <!-- Optional: dropdown arrow icon -->
      <svg class="absolute w-4 h-4 text-gray-400 -translate-y-1/2 pointer-events-none right-3 top-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </div>
  </div>
</template>
