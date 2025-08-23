<template>
  <div class="bg-gray-300">
    <Header />
    <main>
      <slot />
    </main>
    <Footer />
  </div>
</template>

<script setup>
import Header from "@/Components/WebComponents/Header.vue";
import Footer from "@/Components/WebComponents/Footer.vue";
</script>

<style scoped>
</style>