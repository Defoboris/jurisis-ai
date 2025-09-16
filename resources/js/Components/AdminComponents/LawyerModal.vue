<template>
  <div
    class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-auto bg-black/50"
  >
    <div
      class="w-full max-w-3xl bg-white shadow-lg dark:bg-gray-800 rounded-2xl animate-scaleIn"
    >
      <!-- Header -->
      <div
        class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700"
      >
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
          {{ title }}
        </h3>
        <button
          type="button"
          @click="$emit('cancel')"
          class="p-2 transition rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
        >
          <X class="w-5 h-5 text-gray-600 dark:text-gray-300" />
        </button>
      </div>

      <!-- Form Content -->
      <form
        @submit.prevent="handleSubmit"
        class="p-6 space-y-6 max-h-[70vh] overflow-y-auto"
      >
        <!-- Personal Info -->
        <div class="grid gap-6 md:grid-cols-2">
          <div class="space-y-4">
            <h4
              class="pb-1 font-semibold text-gray-800 border-b border-green-500 dark:text-gray-100"
            >
              Informations personnelles
            </h4>
            <div class="flex flex-col gap-1">
              <label
                class="text-sm font-medium text-gray-700 dark:text-gray-300"
                >Utilisateur *</label
              >
              <select v-model="formData.user_id" required class="input-field">
                <option value="">Sélectionner l'utilisateur</option>
                <option
                  v-for="user in props.users"
                  :key="user"
                  :value="user.id"
                >
                  {{ user.name }} "{{ user.email }}"
                </option>
              </select>
            </div>
            <div class="flex flex-col gap-1">
              <label
                class="text-sm font-medium text-gray-700 dark:text-gray-300"
                >Photo de profile</label
              >
              <input
                v-model="formData.profile"
                type="text"
                placeholder="photo de profile"
                class="input-field"
              />
            </div>
            <div class="flex flex-col gap-1">
              <label
                class="text-sm font-medium text-gray-700 dark:text-gray-300"
                >Video
              </label>
              <input
                v-model="formData.vidio_url"
                type="text"
                class="input-field"
              />
            </div>
            <div class="grid gap-4 md:grid-cols-2">
              <div class="flex flex-col gap-1">
                <label
                  class="text-sm font-medium text-gray-700 dark:text-gray-300"
                  >Matricule
                </label>
                <input
                  v-model="formData.bar_id"
                  type="tel"
                  placeholder="XXXX XXXX"
                  class="input-field"
                />
              </div>
              <div class="flex flex-col gap-1">
                <label
                  class="text-sm font-medium text-gray-700 dark:text-gray-300"
                  >Expérience (années)</label
                >
                <input
                  v-model="formData.experience"
                  type="number"
                  placeholder="5"
                  min="0"
                  class="input-field"
                />
              </div>
            </div>
          </div>

          <!-- Professional Info -->
          <div class="space-y-4">
            <h4
              class="pb-1 font-semibold text-gray-800 border-b border-green-500 dark:text-gray-100"
            >
              Informations professionnelles
            </h4>
            <div class="flex flex-col gap-1">
              <label
                class="text-sm font-medium text-gray-700 dark:text-gray-300"
                >Spécialité *</label
              >
              <select v-model="formData.specialty" required class="input-field">
                <option value="">Sélectionner une spécialité</option>
                <option
                  v-for="specialty in specialties"
                  :key="specialty"
                  :value="specialty"
                >
                  {{ specialty }}
                </option>
              </select>
            </div>
            <div class="flex flex-col gap-1">
              <label
                class="text-sm font-medium text-gray-700 dark:text-gray-300"
                >Cabinet/Firm *</label
              >
              <input
                v-model="formData.firm_name"
                type="text"
                placeholder="Cabinet Dupont & Associés"
                required
                class="input-field"
              />
            </div>
            <div class="flex flex-col gap-1">
              <label
                class="text-sm font-medium text-gray-700 dark:text-gray-300"
                >Adresse</label
              >
              <input
                v-model="formData.office_address"
                type="text"
                placeholder="123 Rue de la Justice, 75001 Paris"
                class="input-field"
              />
            </div>
            <div class="grid gap-4 md:grid-cols-2">
              <div class="flex flex-col gap-1">
                <label
                  class="text-sm font-medium text-gray-700 dark:text-gray-300"
                  >Rating
                </label>
                <input
                  v-model="formData.review"
                  type="number"
                  placeholder="5"
                  required
                  min="0"
                  class="input-field"
                />
              </div>
              <div class="flex flex-col gap-1">
                <label
                  class="text-sm font-medium text-gray-700 dark:text-gray-300"
                  >Langues</label
                >
                <input
                  v-model="formData.languages"
                  type="text"
                  placeholder="Français, Anglais"
                  class="input-field"
                />
              </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
              <div class="flex flex-col gap-1">
                <label
                  class="text-sm font-medium text-gray-700 dark:text-gray-300"
                  >Status</label
                >
                <select v-model="formData.status" required class="input-field">
                  <option value="">Sélectionner le status</option>
                  <option value="actif">Actif</option>
                  <option value="bloqué">Bloqué</option>
                  <option value="en attente">En attente</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- Bio -->
        <div class="space-y-2">
          <h4
            class="pb-1 font-semibold text-gray-800 border-b border-green-500 dark:text-gray-100"
          >
            Biographie
          </h4>
          <textarea
            v-model="formData.bio"
            rows="4"
            cols="50"
            placeholder="Décrivez l'expérience et les domaines d'expertise..."
            class="resize-y input-field"
          />
        </div>
        <div class="space-y-2">
          <h4
            class="pb-1 font-semibold text-gray-800 border-b border-green-500 dark:text-gray-100"
          >
            Note de moderation
          </h4>
          <textarea
            v-model="formData.moderation_notes"
            rows="4"
            cols="50"
            placeholder="..."
            class="resize-y input-field"
          />
        </div>
        <!-- Actions -->
        <div class="flex flex-col justify-end gap-3 mt-4 md:flex-row">
          <button type="button" @click="$emit('cancel')" class="btn-outline">
            Annuler
          </button>
          <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { X } from "lucide-vue-next";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  title: String,
  lawyer: Object,
  users: Array,
});

const emit = defineEmits(["save", "cancel"]);

const formData = ref({
  id: props.lawyer?.id || "",
  user_id: props.lawyer?.user_id || "",
  profile: props.lawyer?.profile || "",
  specialty: props.lawyer?.specialty || "",
  firm_name: props.lawyer?.firm_name || "",
  status: props.lawyer?.status || "",
  office_address: props.lawyer?.office_address || "",
  bar_id: props.lawyer?.bar_id || "",
  bio: props.lawyer?.bio || "",
  vidio_url: props.lawyer?.vidio_url || "",
  moderation_notes: props.lawyer?.moderation_notes || "",
  experience: props.lawyer?.experience || "",
  review: props.lawyer?.review || "",
});

const specialties = [
  "Droit des affaires",
  "Droit immobilier",
  "Droit de la famille",
  "Droit du travail",
  "Droit pénal",
  "Droit civil",
  "Droit fiscal",
  "Droit commercial",
];

const handleSubmit = () => emit("save", formData.value);
</script>


<style scoped>
.input-field {
  padding: 0.5rem 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  background-color: white;
  color: #111827;
  font-size: 0.875rem;
  transition: all 0.2s;
}

.input-field:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
}

.btn-primary {
  padding: 0.5rem 1rem;
  background-color: #3b82f6;
  color: white;
  font-weight: 500;
  border-radius: 0.5rem;
  transition: all 0.2s;
}
.btn-primary:hover {
  background-color: #0d0da5;
}

.btn-outline {
  padding: 0.5rem 1rem;
  border: 1px solid #d1d5db;
  color: #374151;
  border-radius: 0.5rem;
  transition: all 0.2s;
}
.btn-outline:hover {
  background-color: #f3f4f6;
}

.animate-scaleIn {
  animation: scaleIn 200ms ease-out;
}
@keyframes scaleIn {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>
