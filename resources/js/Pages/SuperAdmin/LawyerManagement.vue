<template>
  <AdminLayout>
    <div class="lawyer-management">
      <!-- Page header -->
      <div class="page-header">
        <div>
          <h1 class="page-title">Gestion des avocats</h1>
          <p class="page-subtitle">
            Gérer les profils et informations des avocats
          </p>
        </div>
        <button class="flex items-center gap-3 px-6 py-2 text-white transition rounded-lg bg-primary hover:bg-green-700" @click="handleAddLawyer">
          <Plus class="w-4 h-4" />
          Ajouter avocat
        </button>
      </div>

      <!-- Filters and search -->
      <div class="filters-section">
        <div class="search-bar">
          <div class="search-wrapper">
            <Search class="search-icon" />
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Rechercher par nom, cabinet ou spécialité..."
              class="search-input"
            />
          </div>
        </div>

        <FilterBar
          v-model="selectedFilter"
          :options="filterOptions"
          icon-component="FunnelIcon"
        />
      </div>

      <!-- Lawyers table -->
      <div class="table-container">
        <DataTable
          :data="props.lawyers.data"
          :columns="columns"
          @action="handleBlockLawyer"
        />
      </div>

      <!-- Add lawyer modal -->
      <LawyerModal
        v-if="showAddModal"
        title="Ajouter un nouvel avocat"
        @save="handleSaveLawyer"
        @cancel="showAddModal = false"
      />
      <!-- Block lawyer modal -->
      <ActionModal
        v-if="showBlockModal"
        title="Bloquer l'avocat"
        :message="`Êtes-vous sûr de vouloir bloquer ${selectedLawyer?.name} ? Cette action empêchera l'avocat d'accéder à son compte.`"
        confirm-text="Bloquer"
        cancel-text="Annuler"
        type="destructive"
        @confirm="confirmBlockLawyer"
        @cancel="showBlockModal = false"
      />
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from "vue";

import {
  Search, // MagnifyingGlassIcon
  Plus, // PlusIcon
} from "lucide-vue-next";
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import DataTable from "@/Components/AdminComponents/DataTable.vue";
import ActionModal from "@/Components/AdminComponents/ActionModal.vue";
import LawyerModal from "@/Components/AdminComponents/LawyerModal.vue";

const searchQuery = ref("");
const selectedFilter = ref("all");
const showAddModal = ref(false);
const showBlockModal = ref(false);
const selectedLawyer = ref(null);

const props = defineProps({
  lawyers: {
    type: Array,
    required: true,
  }
});

const lawyers = ref([
  {
    id: 1,
    name: "Maître Sophie Bernard",
    email: "sophie.bernard@cabinet-bernard.fr",
    specialty: "Droit des affaires",
    firm: "Cabinet Bernard & Associés",
    status: "Actif",
    clients: 45,
    rating: 4.8,
    joinDate: "12/12/2023",
  },
  {
    id: 2,
    name: "Maître Paul Durand",
    email: "paul.durand@durand-avocat.fr",
    specialty: "Droit immobilier",
    firm: "Durand Avocats",
    status: "Actif",
    clients: 32,
    rating: 4.6,
    joinDate: "08/11/2023",
  },
  {
    id: 3,
    name: "Maître Anne Moreau",
    email: "anne.moreau@moreau-droit.fr",
    specialty: "Droit de la famille",
    firm: "Moreau & Partners",
    status: "En attente",
    clients: 0,
    rating: 0,
    joinDate: "20/01/2024",
  },
]);

const columns = [
  { key: "name", label: "Nom", sortable: true },
  { key: "email", label: "Email", sortable: true },
  { key: "specialty", label: "Spécialité", sortable: true },
  { key: "firm_name", label: "Cabinet", sortable: true },
  { key: "status", label: "Statut", sortable: true },
  { key: "clients", label: "Clients", sortable: true },
  { key: "moderation_notes", label: "Note", sortable: true },
  { key: "actions", label: "Actions", sortable: false },
];

const filterOptions = [
  { value: "all", label: "Tous les avocats" },
  { value: "active", label: "Actifs" },
  { value: "pending", label: "En attente" },
  { value: "blocked", label: "Bloqués" },
  { value: "business", label: "Droit des affaires" },
  { value: "family", label: "Droit de la famille" },
];

const handleAddLawyer = () => {
  showAddModal.value = true;
};

const handleBlockLawyer = (lawyer) => {
  selectedLawyer.value = lawyer;
  showBlockModal.value = true;
};

const confirmBlockLawyer = () => {
  if (selectedLawyer.value) {
    console.log("Blocking lawyer:", selectedLawyer.value);
  }
  showBlockModal.value = false;
  selectedLawyer.value = null;
};

const handleSaveLawyer = (lawyerData) => {
  console.log("Saving lawyer:", lawyerData);
  showAddModal.value = false;
};
</script>

<style scoped>
.lawyer-management {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
}

.page-title {
  font-size: 2rem;
  font-weight: 700;
  color: var(--foreground);
  margin-bottom: 0.5rem;
}

.page-subtitle {
  color: var(--muted-foreground);
  font-size: 1rem;
}

.filters-section {
  display: flex;
  gap: 1rem;
  align-items: center;
  flex-wrap: wrap;
}

.search-bar {
  flex: 1;
  max-width: 24rem;
}

.search-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.search-icon {
  position: absolute;
  left: 0.75rem;
  height: 1rem;
  width: 1rem;
  color: var(--muted-foreground);
  pointer-events: none;
}

.search-input {
  width: 100%;
  padding: 0.625rem 0.75rem 0.625rem 2.5rem;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  background-color: var(--input);
  font-size: 0.875rem;
  transition: border-color 150ms ease-in-out;
}

.search-input:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 2px var(--ring);
}

.table-container {
  background-color: var(--card);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  overflow: hidden;
}

@media (max-width: 768px) {
  .page-header {
    flex-direction: column;
    align-items: stretch;
  }

  .filters-section {
    flex-direction: column;
    align-items: stretch;
  }

  .search-bar {
    max-width: none;
  }
}
</style>