<template>
    <section id="about" class="py-20">
      <div class="container px-4 mx-auto">
        <div class="grid items-center gap-16 mb-20 lg:grid-cols-2">
          <div>
            <div
              class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80 mb-4"
            >
              Intelligence Artificielle Juridique
            </div>
            <h2
              class="mb-6 text-3xl font-bold font-heading lg:text-4xl text-foreground"
            >
              Vous souhaitez échanger directement avec un expert ?
            </h2>
            <p
              class="mb-6 text-lg leading-relaxed font-body text-muted-foreground"
            >
              Notre plateforme d'IA révolutionne l'accès à l'information
              juridique en combinant intelligence artificielle avancée et
              expertise humaine. Obtenez des réponses précises et
              contextualisées à vos questions juridiques en temps réel.
            </p>
            <p
              class="mb-8 text-lg leading-relaxed font-body text-muted-foreground"
            >
              Jurisis analyse votre situation, comprend le contexte et vous
              fournit des conseils adaptés au droit belge et français,
              disponible 24h/24 et 7j/7.
            </p>

            <div class="grid grid-cols-2 gap-6">
              <div
                v-for="(stat, index) in stats"
                :key="index"
                class="flex items-center gap-3"
              >
                <div class="p-2 rounded-lg bg-primary/10">
                  <component :is="stat.icon" class="w-5 h-5 text-primary" />
                </div>
                <div>
                  <div class="text-2xl font-bold font-heading text-foreground">
                    {{ stat.value }}
                  </div>
                  <div class="text-sm text-muted-foreground">
                    {{ stat.label }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="relative">
            <img
              src="/ai-legal-consultation-interface.png"
              alt="Interface de consultation juridique IA"
              class="w-full h-auto rounded-lg shadow-lg"
            />
          </div>
        </div>

        <div class="max-w-3xl mx-auto">
          <h3 class="mb-8 text-2xl font-bold text-center font-heading">FAQ</h3>
          <div class="space-y-4">
            <div
              v-for="(item, index) in faqItems"
              :key="index"
              class="border rounded-lg border-border"
            >
              <button
                @click="toggleFaq(index)"
                class="flex items-center justify-between w-full px-6 py-4 text-left transition-colors font-heading hover:bg-accent/50"
              >
                <span>{{ item.question }}</span>
                <ChevronDown
                  :class="['h-4 w-4 transition-transform',{ 'rotate-180': openFaq === index }]"
                />
              </button>
              <div
                v-show="openFaq === index"
                class="px-6 pb-4 leading-relaxed font-body text-muted-foreground"
              >
                {{ item.answer }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</template>

<script setup>
import { ref } from "vue";
import { Bot, Users, Clock, Award, ChevronDown } from "lucide-vue-next";

const openFaq = ref(null);

const stats = [
  { icon: Bot, value: "IA", label: "Assistance juridique" },
  { icon: Users, value: "24/7", label: "Disponibilité" },
  { icon: Clock, value: "Instant", label: "Réponses rapides" },
  { icon: Award, value: "Expert", label: "Conseils fiables" },
];

const faqItems = [
  {
    question:
      "Quelles sont les différences entre Jurisis, ChatGPT et les autres IA ?",
    answer:
      "Jurisis est spécialement conçu pour le droit belge et français, avec une base de connaissances juridiques spécialisée. Contrairement aux IA généralistes comme ChatGPT, nous nous concentrons exclusivement sur l'information juridique contextuelle et fiable.",
  },
  {
    question: "Les réponses fournies par Jurisis sont-elles toujours fiables ?",
    answer:
      "Bien que Jurisis soit entraîné sur des sources juridiques fiables, il peut parfois se tromper. Nous recommandons toujours de vérifier les informations importantes et de consulter un professionnel pour des cas complexes.",
  },
  {
    question:
      "Jurisis respecte-t-elle la confidentialité des données personnelles ?",
    answer:
      "Oui, nous respectons strictement la confidentialité de vos données. Toutes les conversations sont chiffrées et nous ne partageons jamais vos informations personnelles avec des tiers.",
  },
  {
    question: "Pourquoi une contribution payante sur un tarif avec Jurisis ?",
    answer:
      "Les contributions nous permettent de maintenir et d'améliorer continuellement notre service, d'investir dans la recherche et développement, et de garantir la qualité de nos réponses juridiques.",
  },
];

const toggleFaq = (index) => {
  openFaq.value = openFaq.value === index ? null : index;
};
</script>