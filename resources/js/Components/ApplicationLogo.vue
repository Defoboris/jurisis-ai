<template>
  <div class="flex items-center gap-2">
    <Bot class="w-8 h-8 text-primary dark:text-primary/80" />
    <Link
      href="/"
      class="text-2xl font-bold transition-colors font-heading text-primary hover:text-primary/80 dark:text-primary/80 dark:hover:text-primary/60"
    >
      Jurisis
    </Link>
  </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import { Bot } from "lucide-vue-next";
</script>
