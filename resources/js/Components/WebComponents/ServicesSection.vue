<template>
  <section id="services" class="py-20 bg-gradient-to-br">
    <div class="container px-4 mx-auto">
      <div class="mb-16 text-center">
        <h2 class="mb-4 text-3xl font-bold font-heading lg:text-4xl text-foreground">
          Soutenez notre travail
        </h2>
        <p class="max-w-2xl mx-auto text-xl font-body text-muted-foreground">
          Aidez-nous à créer un service libre qui rend l'accès à l'information juridique plus facile
          et contribuez au développement de notre IA.
        </p>
      </div>

      <div class="grid max-w-5xl gap-8 mx-auto md:grid-cols-3">
        <div
          v-for="(tier, index) in subscriptionPlans"
          :key="index"
          :class="[
            'relative bg-card border rounded-lg p-6 shadow-sm transition-all duration-300 hover:shadow-lg',
            tier.popular ? 'ring-2 ring-primary scale-105 shadow-lg' : 'border-border hover:border-primary/50'
          ]"
        >
          <!-- Badge -->
          <div v-if="tier.badge" class="absolute z-10 transform -translate-x-1/2 -top-3 left-1/2">
            <div
              class="flex items-center px-3 py-1 text-sm font-medium rounded-full shadow-md bg-primary text-primary-foreground"
            >
              <Star class="w-3 h-3 mr-1 fill-current" />
              {{ tier.badge }}
            </div>
          </div>

          <!-- Header -->
          <header class="pb-6 text-center">
            <div class="mb-3 text-xl font-semibold font-heading text-foreground">{{ tier.name }}</div>
            <div class="mb-4">
              <span class="text-4xl font-bold font-heading text-primary">{{ tier.price_cents }}</span>
              <span
                v-if="tier.price !== 'Gratuit' && tier.price !== 'Parlons-en'"
                class="text-lg text-muted-foreground"
              >/mois</span>
            </div>
            <div class="leading-relaxed font-body text-muted-foreground">{{ tier.description }}</div>
          </header>

          <!-- Content -->
          <div class="pt-0">
            <ul class="mb-8 space-y-4">
              <li
                v-for="(feature, idx) in tier.features"
                :key="idx"
                class="flex items-start gap-3 text-sm"
              >
                <Check class="h-5 w-5 text-primary mt-0.5 flex-shrink-0" />
                <span class="leading-relaxed text-foreground">{{ feature }}</span>
              </li>
            </ul>

            <!-- Button -->
            <button
              :disabled="loading"
              @click="handleCheckout(tier.id)"
              :class="[
                'w-full py-3 px-4 rounded-lg font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2',
                tier.buttonVariant === 'default'
                  ? 'bg-primary text-primary-foreground hover:bg-primary/90 shadow-sm hover:shadow-md'
                  : 'bg-transparent border-2 border-primary text-primary hover:bg-primary hover:text-primary-foreground'
              ]"
            >
              {{ loading ? 'Redirection...' : tier.buttonText }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Check, Star } from "lucide-vue-next";
import { useForm, router, usePage } from "@inertiajs/vue3";
import axios from "axios";
import { ref } from "vue";

const page = usePage();

const props = defineProps({
  subscriptionPlans: {
    type: Array,
    default: () => [],
  },
});

const loading = ref(false);

const handleCheckout = async (planId) => {
  if (!page.props.auth.user) {
    router.visit(route("login"));
    return;
  }

  loading.value = true;

  try {
    const response = await axios.post(route("checkout"), {
      plan_id: planId,
    });

    if (response.data && response.data.url) {
      window.location.href = response.data.url;
    } else {
      console.error("Réponse inattendue du serveur :", response.data);
      alert("Impossible de récupérer le lien de paiement. Veuillez réessayer.");
    }
  } catch (error) {
    console.error("Erreur lors du paiement :", error.response?.data || error.message);
    alert(
      error.response?.data?.message ||
        "Une erreur est survenue pendant le paiement. Veuillez réessayer plus tard."
    );
  } finally {
    loading.value = false;
  }
};
</script>
