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
        <button
          class="flex items-center gap-3 px-6 py-2 text-white transition rounded-lg bg-primary hover:bg-green-700"
          @click="handleAddLawyer"
        >
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
          @edit="handleEditLawyer"
          @action="handleBlockLawyer"
        />
      </div>

      <!-- Add lawyer modal -->
      <LawyerModal
        v-if="showAddModal"
        :users="props.users.data"
        :action-type="actionType"
        :lawyer="selectedLawyer"
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
import { toast } from "vue3-toastify";
import { useForm } from "@inertiajs/vue3";

import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import DataTable from "@/Components/AdminComponents/DataTable.vue";
import ActionModal from "@/Components/AdminComponents/ActionModal.vue";
import LawyerModal from "@/Components/AdminComponents/LawyerModal.vue";

const searchQuery = ref("");
const selectedFilter = ref("all");
const showAddModal = ref(false);
const showBlockModal = ref(false);
const selectedLawyer = ref(null);
const actionType = ref("add");

const props = defineProps({
  lawyers: {
    type: Array,
    required: true,
  },
  users: {
    type: Array,
    required: true,
  },
});

const columns = [
  { key: "name", label: "Nom", sortable: true },
  { key: "email", label: "Email", sortable: true },
  { key: "specialty", label: "Spécialité", sortable: true },
  { key: "firm_name", label: "Cabinet", sortable: true },
  { key: "experience", label: "Experience", sortable: true },
  { key: "status", label: "Statut", sortable: true },
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

const handleEditLawyer = (lawyer) => {
  actionType.value = "edit";
  selectedLawyer.value = lawyer;
  showAddModal.value = true;
};

const confirmBlockLawyer = () => {
  if (selectedLawyer.value) {
    const tempForm = useForm(selectedLawyer.value);
    console.log("Blocking lawyer:", tempForm);
    tempForm.put(route('super-admin.lawyers.moderate', { lawyer: selectedLawyer.value.id, state: 'rejected' }), {
      onSuccess: () => {
        toast.success("Avocat bloqué avec succès", {
          autoClose: 3000,
          position: "top-right",
        });
        showAddModal.value = false;
      },
      onError: () => {
        toast.error("Erreur lors du blocage de l'avocat", {
          autoClose: 3000,
          position: "top-right",
        });
        console.log("Validation failed", tempForm.errors);
      },
    });

  }
  showBlockModal.value = false;
  selectedLawyer.value = null;
};

const handleSaveLawyer = (lawyerData) => {
  lawyerData.moderation_state =
    lawyerData.status === "actif"
      ? "approved"
      : lawyerData.status === "bloqué"
      ? "rejected"
      : lawyerData.status === "en attente"
      ? "pending"
      : null;
  // Merge emitted data into the form
  const tempForm = useForm(lawyerData);

  if (actionType.value === "edit" && lawyerData.id) {
    tempForm.put(route("super-admin.lawyerManagement.update", lawyerData.id), {
      onSuccess: () => {
        toast.success("Avocat mis à jour avec succès", {
          autoClose: 3000,
          position: "top-right",
        });
        showAddModal.value = false;
      },
      onError: () => {
        toast.error("Une erreur s'est produite lors de la mis à jour de l'avocat", {
          autoClose: 3000,
          position: "top-right",
        });
        console.log("Validation failed", tempForm.errors);
      },
    });
  } else {
    tempForm.post(route("super-admin.lawyerManagement.create"), {
      onSuccess: () => {
        toast.success("Avocat ajouté avec succès", {
          autoClose: 3000,
          position: "top-right",
        });
        showAddModal.value = false;
      },
      onError: () => {
        toast.error("Une erreur s'est produite lors de l'ajout de l'avocat", {
          autoClose: 3000,
          position: "top-right",
        });
        console.log("Validation failed", tempForm.errors);
      },
    });
  }
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