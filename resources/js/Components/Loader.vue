<template>
    <div v-if="isLoading" class="fixed inset-0 z-50 flex items-center justify-center bg-white bg-opacity-75">
      <div class="w-16 h-16 border-4 border-blue-500 rounded-full border-t-transparent animate-spin"></div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const isLoading = ref(false);
  
  const startLoading = () => {
    isLoading.value = true;
  };
  
  const stopLoading = () => {
    isLoading.value = false;
  };
  
  defineExpose({ startLoading, stopLoading });
  </script>