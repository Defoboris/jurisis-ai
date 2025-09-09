<template>
  <div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <AdminSidebar 
      :current-page="currentPage"
      :sidebar-open="sidebarOpen"
      @page-change="handlePageChange"
      @close="sidebarOpen = false"
    />

    <!-- Main content -->
    <div class="flex flex-col flex-1 overflow-hidden">
      <!-- Header -->
      <AdminHeader @toggle-sidebar="sidebarOpen = !sidebarOpen" />

      <!-- Scrollable main area -->
      <main class="flex-1 p-6 overflow-y-auto lg:p-8">
        <slot />
      </main>
    </div>

    <!-- Mobile backdrop -->
    <div 
      v-if="sidebarOpen" 
      class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden"
      @click="sidebarOpen = false"
    ></div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AdminSidebar from './AdminSidebar.vue'
import AdminHeader from './AdminHeader.vue'

const page = usePage()
const sidebarOpen = ref(false)
const currentComponent = computed(() => page.props.component)

const handlePageChange = (page) => {
  emit("pageChange", page)
  sidebarOpen.value = false
}
</script>
