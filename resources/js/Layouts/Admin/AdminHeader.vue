<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3"
import { Menu, Bell } from "lucide-vue-next"

import Dropdown from "@/Components/Dropdown.vue"
import DropdownLink from "@/Components/DropdownLink.vue"

const page = usePage();

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

        <Dropdown class="flex items-center" align="right" width="48">
          <template #trigger>
            <div
            class="flex items-center justify-center w-8 h-8 text-xs font-semibold text-white rounded-full bg-primary"
          >
            SA
          </div>
          </template>
          <template #content>
            <DropdownLink :href="route('logout')" method="post" as="button">
              Se déconnecter
            </DropdownLink>
          </template>
        </Dropdown>
      </div>
    </div>
  </header>
</template>
