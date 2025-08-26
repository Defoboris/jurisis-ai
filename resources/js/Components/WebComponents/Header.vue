<template>
  <header
    class="flex justify-center sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 dark:bg-background/20 dark:supports-[backdrop-filter]:bg-background/30"
  >
    <div class="container flex items-center justify-between h-16">
      <div class="flex items-center gap-2">
        <Bot class="w-8 h-8 text-primary dark:text-primary/80" />
        <Link
          href="/"
          class="text-2xl font-bold transition-colors font-heading text-primary hover:text-primary/80 dark:text-primary/80 dark:hover:text-primary/60"
        >
          Jurisis
        </Link>
      </div>

      <nav class="items-center hidden gap-6 md:flex">
        <Link
          href="/"
          class="font-medium transition-colors text-foreground hover:text-primary dark:text-foreground/90 dark:hover:text-primary/80"
        >
          Accueil
        </Link>
        <Link
          :href="route('chat')"
          class="flex items-center gap-1 font-medium transition-colors text-foreground hover:text-primary"
        >
          <MessageSquare class="w-4 h-4" />
          Parler à Jurisis
        </Link>
        <Link
          :href="route('lawyers')"
          class="font-medium transition-colors text-foreground hover:text-primary dark:text-foreground/90 dark:hover:text-primary/80"
        >
          Avocats Experts
        </Link>
      </nav>

      <div class="flex items-center gap-4">
        <Link :href="route('dashboard')">
          <button
            class="inline-flex items-center justify-center hidden h-10 px-4 py-2 text-sm font-medium transition-colors bg-transparent border rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-accent hover:text-accent-foreground dark:border-muted-foreground dark:hover:bg-accent/80 dark:hover:text-accent-foreground/90 sm:inline-flex"
          >
            <User class="w-4 h-4 mr-2" />
            Dashboard
          </button>
        </Link>

        <Link :href="route('lawyers')">
          <button
            class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 dark:bg-primary/80 dark:text-primary-foreground/90 dark:hover:bg-primary/70"
          >
            Voir les Experts
          </button>
        </Link>

        <button
          class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium transition-colors rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/80 dark:hover:text-accent-foreground/90 md:hidden"
        >
          <Menu class="w-5 h-5" />
        </button>
      </div>
    </div>
  </header>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import { Bot, Menu, User, Settings, MessageSquare } from "lucide-vue-next";
</script>
