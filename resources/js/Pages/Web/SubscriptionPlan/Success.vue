<template>
  <WebLayout>
    <section class="flex flex-col items-center justify-center min-h-[50vh] px-4 text-center">
      <h1 class="text-3xl font-bold text-green-600">🎉 Paiement réussi !</h1>
      <p class="mt-4 text-gray-700">
        Merci {{ customer.name ?? 'cher utilisateur' }}, votre paiement a été confirmé.
      </p>
       <p class="mt-2 text-sm text-gray-500">Plan : {{ plan.name }} ({{ plan.price_cents }}$) activer avec successe.</p>
      <a href="/" class="mt-3 text-sm text-muted-foreground hover:underline">
        Retour à l’accueil
      </a>
    </section>
  </WebLayout>
</template>

<script setup>
import { ref } from "vue";

import WebLayout from "@/Layouts/WebLayout.vue";

defineProps({
  customer: Object,
  plan: Object,
});
</script>
