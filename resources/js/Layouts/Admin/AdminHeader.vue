<script setup lang="ts">
import { Link } from "@inertiajs/vue3"
import { Menu, Bell } from "lucide-vue-next"

defineEmits<{
  toggleSidebar: []
}>()
</script>

<template>
  <header class="z-10 flex items-center h-16 px-4 bg-white border-b border-gray-200 lg:px-6">
    <div class="flex items-center w-full gap-4">
      <!-- Mobile menu button -->
      <button
        class="p-2 text-gray-600 rounded hover:bg-gray-100 lg:hidden"
        @click="$emit('toggleSidebar')"
      >
        <Menu class="w-6 h-6" />
      </button>

      <!-- Right side actions -->
      <div class="flex items-center justify-end w-full gap-4">
        <Link href="/" class="relative p-2 text-gray-600 rounded hover:bg-gray-100">
          <Bell class="w-5 h-5" />
          <span
            class="absolute -top-0.5 -right-0.5 bg-red-600 text-white text-xs font-semibold px-1.5 py-0.5 rounded-full"
          >
            3
          </span>
        </Link>

        <div class="flex items-center">
          <div
            class="flex items-center justify-center w-8 h-8 text-xs font-semibold text-white rounded-full bg-primary"
          >
            SA
          </div>
        </div>
      </div>
    </div>
  </header>
</template>
