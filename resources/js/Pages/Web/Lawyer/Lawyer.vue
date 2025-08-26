<template>
  <WebLayout>
    <div class="">

    <!-- Hero Section -->
    <section class="py-16 bg-gradient-to-br from-primary/5 to-secondary/5">
      <div class="container px-4 mx-auto">
        <div class="max-w-3xl mx-auto text-center">
          <h1 class="mb-6 text-4xl font-bold font-heading md:text-5xl text-foreground">Nos Avocats Experts</h1>
          <p class="mb-8 text-lg text-muted-foreground">
            Découvrez nos avocats spécialisés et accédez à leurs articles d'expertise juridique. Chaque avocat partage
            ses connaissances à travers des analyses approfondies et des conseils pratiques.
          </p>
        </div>
      </div>
    </section>

    <!-- Lawyers Grid -->
    <section class="py-16">
      <div class="container px-4 mx-auto">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
          <div
            v-for="lawyer in lawyers"
            :key="lawyer.id"
            class="transition-all duration-300 border rounded-lg shadow-sm bg-card text-card-foreground group hover:shadow-lg border-border/50 hover:border-primary/20"
          >
            <div class="flex flex-col space-y-1.5 p-6 pb-4">
              <div class="flex items-start gap-4">
                <div class="relative flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                  <img
                    :src="lawyer.avatar || '/placeholder.svg'"
                    :alt="lawyer.name"
                    class="w-full h-full aspect-square"
                  />
                </div>
                <div class="flex-1">
                  <h3 class="mb-1 text-xl font-heading">{{ lawyer.name }}</h3>
                  <p class="mb-2 text-sm font-medium text-primary">{{ lawyer.title }}</p>
                  <div class="flex items-center gap-4 text-sm text-muted-foreground">
                    <div class="flex items-center gap-1">
                      <MapPin class="w-3 h-3" />
                      {{ lawyer.location }}
                    </div>
                    <div class="flex items-center gap-1">
                      <Star class="w-3 h-3 text-yellow-400 fill-yellow-400" />
                      {{ lawyer.rating }}
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="p-6 pt-0 space-y-4">
              <p class="text-sm leading-relaxed text-muted-foreground">{{ lawyer.description }}</p>

              <div class="flex flex-wrap gap-2">
                <span
                  v-for="specialty in lawyer.specialties"
                  :key="specialty"
                  class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80"
                >
                  {{ specialty }}
                </span>
              </div>

              <div class="flex items-center justify-between pt-2 text-sm border-t text-muted-foreground border-border/50">
                <div class="flex items-center gap-1">
                  <Calendar class="w-3 h-3" />
                  {{ lawyer.experience }}
                </div>
                <div class="flex items-center gap-1">
                  <BookOpen class="w-3 h-3" />
                  {{ lawyer.articles }} articles
                </div>
              </div>

              <div class="pt-2">
                <p class="mb-3 text-xs text-muted-foreground">Dernier article: "{{ lawyer.recentArticle }}"</p>
                <Link :href="route('lawyer.show', lawyer.id)">
                  <button class="inline-flex items-center justify-center w-full h-10 px-4 py-2 text-sm font-medium transition-colors rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 group-hover:bg-primary/90">
                    Voir le profil et les articles
                  </button>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <Footer />
  </div>
  </WebLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { MapPin, Star, BookOpen, Calendar } from 'lucide-vue-next'
import WebLayout from '@/Layouts/WebLayout.vue'


const lawyers = ref([
  {
    id: "marie-dubois",
    name: "Marie Dubois",
    title: "Avocate en Droit des Affaires",
    specialties: ["Droit Commercial", "Fusions & Acquisitions", "Droit Fiscal"],
    location: "Bruxelles",
    rating: 4.9,
    experience: "15 ans",
    articles: 24,
    avatar: "/professional-female-lawyer.png",
    description: "Experte en droit des affaires avec une spécialisation en fusions-acquisitions et restructurations d'entreprises.",
    recentArticle: "Les nouvelles réglementations européennes sur les acquisitions",
  },
  {
    id: "jean-martin",
    name: "Jean Martin",
    title: "Avocat en Droit Pénal",
    specialties: ["Droit Pénal", "Droit de la Défense", "Procédure Pénale"],
    location: "Liège",
    rating: 4.8,
    experience: "12 ans",
    articles: 18,
    avatar: "/placeholder-ifxms.png",
    description: "Avocat pénaliste reconnu pour sa défense rigoureuse et son expertise en procédure pénale complexe.",
    recentArticle: "Évolution de la jurisprudence en matière de légitime défense",
  },
  {
    id: "sophie-laurent",
    name: "Sophie Laurent",
    title: "Avocate en Droit de la Famille",
    specialties: ["Droit de la Famille", "Divorce", "Garde d'Enfants"],
    location: "Anvers",
    rating: 4.9,
    experience: "10 ans",
    articles: 31,
    avatar: "/placeholder-t87lq.png",
    description: "Spécialisée en droit familial avec une approche empathique et des solutions personnalisées.",
    recentArticle: "Guide complet du divorce par consentement mutuel en Belgique",
  },
  {
    id: "pierre-bernard",
    name: "Pierre Bernard",
    title: "Avocat en Droit Immobilier",
    specialties: ["Droit Immobilier", "Urbanisme", "Construction"],
    location: "Gand",
    rating: 4.7,
    experience: "18 ans",
    articles: 22,
    avatar: "/professional-male-lawyer-real-estate.png",
    description: "Expert en droit immobilier et urbanisme, conseillant particuliers et promoteurs immobiliers.",
    recentArticle: "Nouvelles règles d'urbanisme : impact sur les projets immobiliers",
  },
  {
    id: "claire-rousseau",
    name: "Claire Rousseau",
    title: "Avocate en Droit du Travail",
    specialties: ["Droit du Travail", "Relations Sociales", "Licenciements"],
    location: "Bruxelles",
    rating: 4.8,
    experience: "14 ans",
    articles: 27,
    avatar: "/female-lawyer-employment.png",
    description: "Spécialiste du droit social accompagnant entreprises et salariés dans leurs relations de travail.",
    recentArticle: "Télétravail et droit du travail : ce que dit la nouvelle législation",
  },
  {
    id: "thomas-moreau",
    name: "Thomas Moreau",
    title: "Avocat en Propriété Intellectuelle",
    specialties: ["Propriété Intellectuelle", "Brevets", "Marques"],
    location: "Louvain",
    rating: 4.9,
    experience: "11 ans",
    articles: 19,
    avatar: "/placeholder-gam31.png",
    description: "Expert en propriété intellectuelle, protégeant les innovations et créations de ses clients.",
    recentArticle: "Protection des marques à l'ère du numérique",
  },
])
</script>
