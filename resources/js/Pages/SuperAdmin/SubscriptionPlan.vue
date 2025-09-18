```vue
<template>
  <AdminLayout>
    <section id="services" class="bg-gradient-to-br">
      <div class="container px-4 mx-auto">
        <div class="mb-16 text-center">
          <h2
            class="mb-4 text-3xl font-bold font-heading lg:text-4xl text-foreground"
          >
            Gérer les formules d’abonnement
          </h2>
          <p class="max-w-2xl mx-auto text-xl font-body text-muted-foreground">
            Vous pouvez modifier ici les 3 plans d’abonnement disponibles.
          </p>
        </div>

        <!-- FORM -->
        <form
          @submit.prevent="submitForm"
          class="grid max-w-5xl gap-8 mx-auto md:grid-cols-3"
        >
          <div
            v-for="tier in form.plans"
            :key="tier.id"
            class="relative p-6 border rounded-lg shadow-sm bg-card"
          >
            <!-- Name -->
            <div class="mb-4">
              <label class="block mb-1 text-sm font-medium text-foreground"
                >Nom du plan</label
              >
              <input
                v-model="tier.name"
                type="text"
                class="w-full px-3 py-2 border rounded-md focus:ring-primary focus:border-primary"
              />
            </div>

            <!-- Price -->
            <div class="mb-4">
              <label class="block mb-1 text-sm font-medium text-foreground"
                >Prix (€/mois)</label
              >
              <input
                v-model="tier.price_cents"
                type="number"
                min="0"
                class="w-full px-3 py-2 border rounded-md focus:ring-primary focus:border-primary"
              />
            </div>

            <!-- Description -->
            <div class="mb-4">
              <label class="block mb-1 text-sm font-medium text-foreground"
                >Description</label
              >
              <textarea
                v-model="tier.description"
                rows="2"
                class="w-full px-3 py-2 border rounded-md focus:ring-primary focus:border-primary"
              ></textarea>
            </div>

            <!-- Features -->
            <div class="mb-4">
              <label class="block mb-1 text-sm font-medium text-foreground"
                >Fonctionnalités (séparées par des virgules)</label
              >
              <input
                v-model="tier.featuresString"
                type="text"
                placeholder="Ex: Support 24/7, Assistance juridique, Tableau de bord"
                class="w-full px-3 py-2 border rounded-md focus:ring-primary focus:border-primary"
              />
            </div>
          </div>

          <!-- Submit button (full width under the grid) -->
          <div class="mt-8 text-center col-span-full">
            <button
              type="submit"
              class="px-6 py-3 font-medium rounded-lg bg-primary text-primary-foreground hover:bg-primary/90"
              :disabled="form.processing"
            >
              Sauvegarder les modifications
            </button>
          </div>
        </form>
      </div>
    </section>
  </AdminLayout>
</template>
<script setup>
import { useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";

const props = defineProps({
  subscriptionPlans: {
    type: Array,
    default: () => [],
  },
});

// Convert DB features array into editable string
const normalizedPlans = props.subscriptionPlans.map((plan) => ({
  ...plan,
  featuresString: plan.features?.join(", ") || "",
}));

const form = useForm({
  plans: normalizedPlans,
});

const submitForm = () => {
  // Prepare payload: convert featuresString → array
  const payload = {
    plans: form.plans.map((plan) => ({
      id: plan.id,
      name: plan.name,
      price_cents: plan.price_cents,
      description: plan.description || "",
      features: plan.featuresString
        ? plan.featuresString
            .split(",")
            .map((f) => f.trim())
            .filter(Boolean)
        : plan.features || [],
    })),
  };

  console.log("Payload sent to backend:", payload);

  // Use form.post for your POST route
  form.post(route("super-admin.subscriptions.update", payload), {
    onSuccess: () => {
      toast.success("Formules d'abonnement mises à jour avec succès", {
        autoClose: 3000,
        position: "top-right",
      });
    },
    onError: (errors) => {
      console.log("Validation failed", errors);
      toast.error(
        "Une erreur s'est produite lors de la mise à jour des formules d'abonnement",
        {
          autoClose: 3000,
          position: "top-right",
        }
      );
    },
  });
};
</script>
