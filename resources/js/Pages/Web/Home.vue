<template>
  <WebLayout>
    <section
      class="relative py-20 overflow-hidden lg:py-32 bg-gradient-to-br from-background via-muted/30 to-background dark:from-background/20 dark:via-muted/50 dark:to-background/20"
    >
      <div class="container relative px-4 mx-auto">
        <div class="max-w-4xl mx-auto mb-16 text-center">
          <h1
            class="mb-6 text-4xl font-bold leading-tight font-heading lg:text-6xl text-foreground dark:text-foreground/90"
          >
            L'IA Qui facilite <br />
            <span class="text-primary dark:text-primary/80">l'information juridique</span>
          </h1>

          <p
            class="max-w-2xl mx-auto mb-8 text-xl leading-relaxed font-body text-muted-foreground dark:text-muted-foreground/80"
          >
            Jurisis est une plateforme d'IA qui fournit des réponses juridiques
            contextualisées via un chat intelligent. Obtenez des conseils
            juridiques instantanés et fiables.
          </p>

          <div class="flex flex-col justify-center gap-4 mb-12 sm:flex-row">
            <Link
              :href="route('chat')"
              @click="showChat = true"
              class="inline-flex items-center justify-center h-12 px-8 text-lg font-medium transition-colors rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-primary text-primary-foreground hover:bg-primary/90 dark:bg-primary/80 dark:text-primary-foreground/90 dark:hover:bg-primary/70"
            >
              Parler à Jurisis
              <ArrowRight class="w-5 h-5 ml-2" />
            </Link>

            <Link
              :href="route('lawyers')"
              class="inline-flex items-center justify-center h-12 px-8 text-lg font-medium transition-colors bg-transparent border rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 border-input hover:bg-accent hover:text-accent-foreground dark:border-muted-foreground dark:hover:bg-accent/80 dark:hover:text-accent-foreground/90"
            >
              Parler à un expert
            </Link>
          </div>
        </div>

        <div class="max-w-2xl mx-auto">
          <div
            class="border rounded-lg shadow-sm bg-card/80 backdrop-blur text-card-foreground dark:bg-card/20 dark:text-card-foreground/90"
          >
            <div class="p-6">
              <div class="flex items-center gap-3 mb-4">
                <Bot class="w-6 h-6 text-primary dark:text-primary/80" />
                <span class="text-lg font-semibold font-heading dark:text-foreground/90">
                  Je m'appelle Jurisis, comment puis-je vous aider?
                </span>
              </div>

              <div class="p-4 mb-4 rounded-lg bg-primary/10 dark:bg-primary/20">
                <p class="mb-3 text-sm text-muted-foreground dark:text-muted-foreground/70">
                  En utilisant ce chatbot, vous acceptez l'enregistrement et le
                  traitement de vos données par notre site web et les services
                  externes qu'il pourrait utiliser (LLMs, bases de données
                  vectorielles, etc.).
                </p>
                <Link
                  :href="route('login')"
                  class="inline-flex items-center justify-center h-8 px-3 text-xs font-medium transition-colors bg-transparent border rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 border-input hover:bg-accent hover:text-accent-foreground dark:border-muted-foreground dark:hover:bg-accent/80 dark:hover:text-accent-foreground/90"
                >
                  Je comprends
                </Link>
              </div>

              <div class="flex gap-2">
                <input
                  v-model="message"
                  placeholder="Écrivez votre message..."
                  class="flex flex-1 w-full h-10 px-3 py-2 text-sm border rounded-md border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-background/20 dark:border-muted-foreground dark:text-foreground/90 dark:placeholder:text-muted-foreground/70"
                />
                <Link
                  :href="route('chat')"
                  class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium transition-colors rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 dark:bg-primary/80 dark:text-primary-foreground/90 dark:hover:bg-primary/70"
                >
                  <Send class="w-4 h-4" />
              </Link>
              </div>

              <p class="mt-3 text-xs text-center text-muted-foreground dark:text-muted-foreground/70">
                L'IA peut se tromper. Pensez à vérifier les informations
                importantes. Les conversations peuvent être utilisées à des fins
                d'assurance qualité.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <ServicesSection />
    <About />
    <ContactSection />
  </WebLayout>
</template>

<script setup>
import { ref } from "vue";
import { ArrowRight, Bot, Send } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";

import WebLayout from "@/Layouts/WebLayout.vue";
import ServicesSection from "@/Components/WebComponents/ServicesSection.vue";
import About from "@/Components/WebComponents/About.vue";
import ContactSection from "@/Components/WebComponents/ContactSection.vue";

const message = ref("");
const showChat = ref(false);
</script>
