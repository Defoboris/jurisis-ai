<script setup>
import { Link } from "@inertiajs/vue3";
import { Bot } from "lucide-vue-next";
</script>

<template>
  <div
    class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0"
  >
    <div class="flex items-center gap-2">
      <Bot class="w-8 h-8 text-primary dark:text-primary/80" />
      <Link
        href="/"
        class="text-2xl font-bold transition-colors font-heading text-primary hover:text-primary/80 dark:text-primary/80 dark:hover:text-primary/60"
      >
        Jurisis
      </Link>
    </div>

    <div
      class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg"
    >
      <slot />
    </div>
  </div>
</template>
