<script setup>
import { ref } from 'vue'
import { Search, Filter } from 'lucide-vue-next'

import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import FilterBar from '@/Components/AdminComponents/FilterBar.vue'
import DataTable from '@/Components/AdminComponents/DataTable.vue'
import ActionModal from '@/Components/AdminComponents/ActionModal.vue'

const searchQuery = ref('')
const selectedFilter = ref('all')
const showBlockModal = ref(false)
const selectedUser = ref(null)

const users = ref([
  {
    id: 1,
    name: 'Jean Dupont',
    email: 'jean.dupont@email.com',
    role: 'Client',
    status: 'Actif',
    subscription: 'Premium',
    joinDate: '15/01/2024',
    lastActive: '2 heures'
  },
  {
    id: 2,
    name: 'Marie Martin',
    email: 'marie.martin@email.com',
    role: 'Client',
    status: 'Actif',
    subscription: 'Standard',
    joinDate: '10/01/2024',
    lastActive: '1 jour'
  },
  {
    id: 3,
    name: 'Pierre Legrand',
    email: 'pierre.legrand@email.com',
    role: 'Client',
    status: 'Bloqué',
    subscription: 'Gratuit',
    joinDate: '05/01/2024',
    lastActive: '5 jours'
  }
])

const columns = [
  { key: 'name', label: 'Nom', sortable: true },
  { key: 'email', label: 'Email', sortable: true },
  { key: 'role', label: 'Rôle', sortable: false },
  { key: 'status', label: 'Statut', sortable: true },
  { key: 'subscription', label: 'Abonnement', sortable: true },
  { key: 'joinDate', label: "Date d'inscription", sortable: true },
  { key: 'lastActive', label: 'Dernière activité', sortable: true },
  { key: 'actions', label: 'Actions', sortable: false }
]

const filterOptions = [
  { value: 'all', label: 'Tous les utilisateurs' },
  { value: 'active', label: 'Actifs' },
  { value: 'blocked', label: 'Bloqués' },
  { value: 'premium', label: 'Premium' },
  { value: 'standard', label: 'Standard' }
]

const handleBlockUser = (user) => {
  selectedUser.value = user
  showBlockModal.value = true
}

const confirmBlockUser = () => {
  if (selectedUser.value) {
    console.log('Blocking user:', selectedUser.value)
  }
  showBlockModal.value = false
  selectedUser.value = null
}
</script>

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
        <button
          class="inline-flex items-center px-4 py-2 font-medium text-white transition rounded-lg bg-primary hover:bg-green-700"
        >
          Inviter utilisateur
        </button>
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
        <FilterBar
          v-model="selectedFilter"
          :options="filterOptions"
          :icon-component="Filter"
        />
      </div>

      <!-- Table -->
      <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-900 dark:border-gray-700">
        <DataTable
          :data="users"
          :columns="columns"
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
