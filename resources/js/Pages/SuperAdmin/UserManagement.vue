<template>
  <AdminLayout>
    <div class="flex flex-col gap-8">

      <!-- Header -->
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-50">Gestion des utilisateurs</h1>
          <p class="text-sm text-gray-500 dark:text-gray-400">
            Gérer tous les utilisateurs de la plateforme
          </p>
        </div>
      </div>

      <!-- Filters + Search -->
      <div class="flex flex-col gap-4 md:flex-row md:items-center">
        <!-- Search -->
        <div class="relative flex-1 max-w-md">
          <Search class="absolute w-4 h-4 text-gray-400 -translate-y-1/2 left-3 top-1/2" />
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Rechercher par nom ou email..."
            class="w-full py-2 pr-3 text-sm bg-white border border-gray-200 rounded-lg pl-9 dark:border-gray-700 dark:bg-gray-700 focus:ring-1 focus:ring-green-400 focus:outline-none"
          />
        </div>

        <!-- Filters -->
        <!-- <FilterBar
          v-model="selectedFilter"
          :options="filterOptions"
          :icon-component="Filter"
        /> -->
      </div>

      <!-- Table -->
      <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-900 dark:border-gray-700">
        <DataTable
          :data="filteredUsers"
          :columns="columns"
          :tableUse="'users'"
          @edit="handleUnblockUser"
          @action="handleBlockUser"
        />
      </div>
      
      <!-- Modal -->
      <ActionModal
        v-if="showBlockModal"
        title="Bloquer l'utilisateur"
        :message="`Êtes-vous sûr de vouloir bloquer ${selectedUser?.name} ? Cette action peut être annulée.`"
        confirm-text="Bloquer"
        cancel-text="Annuler"
        type="destructive"
        @confirm="confirmBlockUser"
        @cancel="showBlockModal = false"
      />
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Search, Filter } from 'lucide-vue-next'
import { toast } from "vue3-toastify";
import { useForm } from "@inertiajs/vue3";

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import FilterBar from '@/Components/AdminComponents/FilterBar.vue'
import DataTable from '@/Components/AdminComponents/DataTable.vue'
import ActionModal from '@/Components/AdminComponents/ActionModal.vue'

// -------------------
// Reactive Variables
// -------------------
const searchQuery = ref('')
const selectedFilter = ref('all')
const showBlockModal = ref(false)
const selectedUser = ref(null)
const apiKey = ref("sk_live_1234abcd5678efgh9012xyz") // Replace with your real API key
const showApiKey = ref(false)

// -------------------
// Props
// -------------------
const props = defineProps({
  users: {
    type: Array,
    required: true,
  }
})

// -------------------
// Computed Users (Search + Filter)
// -------------------
const filteredUsers = computed(() => {
  const query = searchQuery.value.trim().toLowerCase()
  const filter = selectedFilter.value

  return props.users.filter((user) => {
    // ---- SEARCH ----
    const matchesSearch =
      !query ||
      user.name?.toLowerCase().includes(query) ||
      user.email?.toLowerCase().includes(query)

    // ---- FILTER ----
    const matchesFilter =
      filter === 'all' ||
      (filter === 'Inactif' && user.status === 'Inactif') ||
      (filter === 'Actif' && user.status === 'Actif')

    return matchesSearch && matchesFilter
  })
})

// -------------------
// Table Columns
// -------------------
const columns = [
  { key: 'name', label: 'Nom', sortable: true },
  { key: 'email', label: 'Email', sortable: true },
  { key: 'role', label: 'Rôle', sortable: false },
  { key: 'status', label: 'Statut', sortable: true },
  { key: 'joinDate', label: "Date d'inscription", sortable: true },
  { key: 'actions', label: 'Actions', sortable: false }
]

// -------------------
// Filters Options
// -------------------
const filterOptions = [
  { value: 'all', label: 'Tous les utilisateurs' },
  { value: 'Actif', label: 'Actifs' },
  { value: 'Inactif', label: 'Inactif' },
]

// -------------------
// API Key Copy Function
// -------------------
const copyApiKey = async () => {
  await navigator.clipboard.writeText(apiKey.value);
  toast.success("API key copied!", {
    autoClose: 2000,
    position: "top-right",
  });
};

// -------------------
// Modal Actions
// -------------------
const handleBlockUser = (user) => {
  selectedUser.value = user;
  showBlockModal.value = true
}

const confirmBlockUser = () => {
  if (selectedUser.value) {
    const tempForm = useForm(selectedUser.value)

    tempForm.put(route('super-admin.users.block', { user: selectedUser.value.id }), {
      onSuccess: () => {
        toast.success("Utilisateur bloqué avec succès", {
          autoClose: 3000,
          position: "top-right",
        });
        showBlockModal.value = false;
      },
      onError: () => {
        toast.error("Erreur lors du blocage de l'utilisateur", {
          autoClose: 3000,
          position: "top-right",
        });
        console.log("Validation failed", tempForm.errors);
      },
    });
  }
  showBlockModal.value = false
  selectedUser.value = null
}

const handleUnblockUser = (user) => {
  if (user) {
    const tempForm = useForm(user)

    tempForm.put(route('super-admin.users.unblock', { user: user.id }), {
      onSuccess: () => {
        toast.success("Utilisateur débloqué avec succès", {
          autoClose: 3000,
          position: "top-right",
        });
      },
      onError: () => {
        toast.error("Erreur lors du déblocage de l'utilisateur", {
          autoClose: 3000,
          position: "top-right",
        });
        console.log("Validation failed", tempForm.errors);
      },
    });
  }
}
</script>
