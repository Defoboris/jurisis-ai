<template>
    <WebLayout>
        <section class="flex flex-col items-center justify-center min-h-[50vh] px-4 text-center">
            <h1 class="text-3xl font-bold text-red-600">❌ Paiement annulé</h1>
            <p class="mt-4 text-gray-700">
                Votre paiement n’a pas été complété. Si vous avez rencontré un problème, vous pouvez réessayer.
            </p>

            <button @click="$inertia.visit(route('subscriptions-plans'))"
                class="px-6 py-3 mt-6 font-medium transition rounded-lg shadow bg-primary text-primary-foreground hover:bg-primary/90">
                Réessayer le paiement
            </button>

            <a href="/" class="mt-3 text-sm text-muted-foreground hover:underline">
                Retour à l’accueil
            </a>
        </section>
    </WebLayout>
</template>

<script setup>
import { ref } from "vue";

import WebLayout from "@/Layouts/WebLayout.vue";


</script>
