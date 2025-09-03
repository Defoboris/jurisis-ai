<template>
  <div class="admin-layout">
    <!-- Mobile backdrop -->
    <div 
      v-if="sidebarOpen" 
      class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden"
      @click="sidebarOpen = false"
    ></div>

    <!-- Sidebar -->
    <AdminSidebar 
      :current-page="currentPage"
      :sidebar-open="sidebarOpen"
      @page-change="handlePageChange"
      @close="sidebarOpen = false"
    />

    <!-- Main content -->
    <div class="main-content">
      <AdminHeader @toggle-sidebar="sidebarOpen = !sidebarOpen" />
      
      <main class="main-area">
        <slot />
      </main>
    </div>
  </div>
</template>
<script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import AdminSidebar from "./AdminSidebar.vue";
import AdminHeader from "./AdminHeader.vue";

const page = usePage();

const sidebarOpen = ref(false);
const currentComponent = computed(() => page.props.component);

const handlePageChange = (page) => {
  emit("pageChange", page);
  sidebarOpen.value = false;
};
</script>
<style scoped>
.admin-layout {
  display: flex;
  min-height: 100vh;
  background-color: var(--muted);
}

.main-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.main-area {
  flex: 1;
  padding: 1.5rem;
  overflow-y: auto;
}

@media (max-width: 1024px) {
  .main-area {
    padding: 1rem;
  }
}

@media (max-width: 768px) {
  .main-area {
    padding: 0.75rem;
  }
}
</style>