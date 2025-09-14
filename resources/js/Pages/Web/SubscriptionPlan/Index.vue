<template>
  <WebLayout>
    <ServicesSection :subscriptionPlans="subscriptionPlans" />
  </WebLayout>
</template>

<script setup>
import { ref } from "vue";

import WebLayout from "@/Layouts/WebLayout.vue";
import ServicesSection from "@/Components/WebComponents/ServicesSection.vue";

const message = ref("");
const showChat = ref(false);

const props = defineProps({
  subscriptionPlans: {
    type: Array,
    default: () => [],
  }
})
</script>
