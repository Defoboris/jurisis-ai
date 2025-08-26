<template>
  <WebLayout>
    <div class="">
      <!-- Back Navigation -->
      <div class="border-b border-border/50">
        <div class="container px-4 py-4 mx-auto">
          <Link
            :href="route('lawyers')"
            class="inline-flex items-center gap-2 text-sm transition-colors text-muted-foreground hover:text-primary"
          >
            <ArrowLeft class="w-4 h-4" />
            Retour aux avocats
          </Link>
        </div>
      </div>

      <!-- Lawyer Profile Header -->
      <section class="py-12 bg-gradient-to-br from-primary/5 to-secondary/5">
        <div class="container px-4 mx-auto">
          <div class="max-w-4xl mx-auto">
            <div class="flex flex-col items-start gap-8 md:flex-row">
              <div
                class="flex items-center justify-center w-32 h-32 mx-auto overflow-hidden rounded-full md:mx-0 bg-primary/10"
              >
                <img
                  v-if="lawyer.avatar"
                  :src="lawyer.avatar"
                  :alt="lawyer.name"
                  class="object-cover w-full h-full"
                />
                <span v-else class="text-2xl font-semibold text-primary">
                  {{ getInitials(lawyer.name) }}
                </span>
              </div>

              <div class="flex-1 text-center md:text-left">
                <h1
                  class="mb-2 text-3xl font-bold font-heading md:text-4xl text-foreground"
                >
                  {{ lawyer.name }}
                </h1>
                <p class="mb-4 text-lg font-medium text-primary">
                  {{ lawyer.title }}
                </p>

                <div
                  class="flex flex-wrap justify-center gap-4 mb-6 text-sm md:justify-start text-muted-foreground"
                >
                  <div class="flex items-center gap-1">
                    <MapPin class="w-4 h-4" />
                    {{ lawyer.location }}
                  </div>
                  <div class="flex items-center gap-1">
                    <Star class="w-4 h-4 text-yellow-400 fill-yellow-400" />
                    {{ lawyer.rating }} / 5
                  </div>
                  <div class="flex items-center gap-1">
                    <Calendar class="w-4 h-4" />
                    {{ lawyer.experience }} d'expérience
                  </div>
                </div>

                <div
                  class="flex flex-wrap justify-center gap-2 mb-6 md:justify-start"
                >
                  <span
                    v-for="specialty in lawyer.specialties"
                    :key="specialty"
                    class="inline-flex items-center rounded-md bg-secondary px-2.5 py-0.5 text-xs font-medium text-secondary-foreground"
                  >
                    {{ specialty }}
                  </span>
                </div>

                <p class="max-w-2xl leading-relaxed text-muted-foreground">
                  {{ lawyer.bio }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Profile Details & Articles -->
      <section class="py-12">
        <div class="container px-4 mx-auto">
          <div class="grid max-w-6xl grid-cols-1 gap-8 mx-auto lg:grid-cols-3">
            <!-- Sidebar - Lawyer Details -->
            <div class="lg:col-span-1">
              <div
                class="sticky border rounded-lg shadow-sm top-8 bg-card text-card-foreground"
              >
                <div class="flex flex-col space-y-1.5 p-6">
                  <h3
                    class="text-2xl font-semibold leading-none tracking-tight font-heading"
                  >
                    Informations
                  </h3>
                </div>
                <div class="p-6 pt-0 space-y-6">
                  <div>
                    <h4
                      class="mb-2 text-sm font-semibold tracking-wide uppercase text-muted-foreground"
                    >
                      Formation
                    </h4>
                    <ul class="space-y-1">
                      <li
                        v-for="(edu, index) in lawyer.education"
                        :key="index"
                        class="text-sm"
                      >
                        {{ edu }}
                      </li>
                    </ul>
                  </div>

                  <div class="border-t"></div>

                  <div>
                    <h4
                      class="mb-2 text-sm font-semibold tracking-wide uppercase text-muted-foreground"
                    >
                      Langues
                    </h4>
                    <div class="flex flex-wrap gap-2">
                      <span
                        v-for="lang in lawyer.languages"
                        :key="lang"
                        class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold"
                      >
                        {{ lang }}
                      </span>
                    </div>
                  </div>

                  <div class="border-t"></div>

                  <div>
                    <h4
                      class="mb-2 text-sm font-semibold tracking-wide uppercase text-muted-foreground"
                    >
                      Contact
                    </h4>
                    <button
                      class="inline-flex items-center justify-center w-full h-10 px-4 py-2 text-sm font-medium transition-colors rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90"
                    >
                      Prendre rendez-vous
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Main Content - Articles -->
            <div class="lg:col-span-2">
              <div class="mb-8">
                <h2 class="mb-2 text-2xl font-bold font-heading">
                  Articles d'expertise
                </h2>
                <p class="text-muted-foreground">
                  Découvrez les analyses et conseils juridiques de
                  {{ lawyer.name.split(" ")[0] }}
                </p>
              </div>

              <div class="space-y-6">
                <div
                  v-for="article in lawyer.articles"
                  :key="article.id"
                  class="transition-all duration-300 border rounded-lg shadow-sm group bg-card text-card-foreground hover:shadow-md"
                >
                  <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex items-start justify-between gap-4">
                      <div class="flex-1">
                        <h3
                          class="mb-2 text-xl transition-colors cursor-pointer font-heading group-hover:text-primary"
                        >
                          {{ article.title }}
                        </h3>
                        <p
                          class="text-sm text-base leading-relaxed text-muted-foreground"
                        >
                          {{ article.excerpt }}
                        </p>
                      </div>
                    </div>
                  </div>

                  <div class="p-6 pt-0">
                    <div class="flex flex-wrap gap-2 mb-4">
                      <span
                        v-for="tag in article.tags"
                        :key="tag"
                        class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold"
                      >
                        {{ tag }}
                      </span>
                    </div>

                    <div
                      class="flex items-center justify-between text-sm text-muted-foreground"
                    >
                      <div class="flex items-center gap-4">
                        <div class="flex items-center gap-1">
                          <Calendar class="w-3 h-3" />
                          {{ formatDate(article.publishedAt) }}
                        </div>
                        <div class="flex items-center gap-1">
                          <Clock class="w-3 h-3" />
                          {{ article.readTime }}
                        </div>
                      </div>

                      <div class="flex items-center gap-4">
                        <div class="flex items-center gap-1">
                          <Eye class="w-3 h-3" />
                          {{ article.views }}
                        </div>
                        <div class="flex items-center gap-1">
                          <MessageCircle class="w-3 h-3" />
                          {{ article.comments }}
                        </div>
                        <button
                          class="inline-flex items-center justify-center h-auto p-1 text-sm font-medium transition-colors rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground"
                        >
                          <Share2 class="w-3 h-3" />
                        </button>
                      </div>
                    </div>

                    <div class="pt-4 mt-4 border-t border-border/50">
                      <Link
                        :href="route('articles')"
                        class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-transparent border rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-primary hover:text-primary-foreground group-hover:bg-primary group-hover:text-primary-foreground"
                      >
                        Lire l'article complet
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Footer Component -->
      <Footer />
    </div>
  </WebLayout>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";
import WebLayout from "@/Layouts/WebLayout.vue";
import {
  ArrowLeft,
  MapPin,
  Star,
  Calendar,
  Clock,
  Eye,
  MessageCircle,
  Share2,
} from "lucide-vue-next";



// Sample lawyer data
const lawyersData = ref({
  "marie-dubois": {
    id: "marie-dubois",
    name: "Marie Dubois",
    title: "Avocate en Droit des Affaires",
    specialties: ["Droit Commercial", "Fusions & Acquisitions", "Droit Fiscal"],
    location: "Bruxelles",
    rating: 4.9,
    experience: "15 ans",
    avatar: "/professional-female-lawyer.png",
    bio: "Marie Dubois est une avocate expérimentée spécialisée en droit des affaires avec plus de 15 ans d'expérience. Elle accompagne les entreprises dans leurs opérations de croissance, fusions-acquisitions et restructurations. Son expertise en droit fiscal lui permet d'offrir des conseils complets à ses clients.",
    education: [
      "Master en Droit des Affaires - ULB",
      "LLM Corporate Law - KU Leuven",
    ],
    languages: ["Français", "Néerlandais", "Anglais"],
    articles: [
      {
        id: 1,
        title: "Les nouvelles réglementations européennes sur les acquisitions",
        excerpt:
          "Analyse des récentes modifications du cadre réglementaire européen et leur impact sur les opérations de M&A.",
        content:
          "Le paysage réglementaire européen en matière d'acquisitions a connu des évolutions significatives ces derniers mois...",
        publishedAt: "2024-01-15",
        readTime: "8 min",
        views: 1247,
        comments: 23,
        tags: ["Réglementation", "M&A", "Europe"],
      },
      {
        id: 2,
        title: "Optimisation fiscale lors des restructurations d'entreprises",
        excerpt:
          "Guide pratique pour optimiser la fiscalité lors des opérations de restructuration tout en respectant la conformité.",
        content:
          "Les restructurations d'entreprises offrent de nombreuses opportunités d'optimisation fiscale...",
        publishedAt: "2024-01-08",
        readTime: "12 min",
        views: 892,
        comments: 15,
        tags: ["Fiscalité", "Restructuration", "Optimisation"],
      },
      {
        id: 3,
        title: "Due diligence juridique : les points clés à ne pas manquer",
        excerpt:
          "Checklist complète pour une due diligence juridique efficace dans le cadre d'acquisitions d'entreprises.",
        content:
          "La due diligence juridique constitue une étape cruciale de toute acquisition d'entreprise...",
        publishedAt: "2023-12-20",
        readTime: "10 min",
        views: 1456,
        comments: 31,
        tags: ["Due Diligence", "Acquisition", "Audit Juridique"],
      },
    ],
  },
  "jean-martin": {
    id: "jean-martin",
    name: "Jean Martin",
    title: "Avocat en Droit Pénal",
    specialties: ["Droit Pénal", "Droit de la Défense", "Procédure Pénale"],
    location: "Liège",
    rating: 4.8,
    experience: "12 ans",
    avatar: "/placeholder-ifxms.png",
    bio: "Jean Martin est un avocat pénaliste reconnu pour sa défense rigoureuse et son expertise en procédure pénale complexe. Il défend aussi bien les particuliers que les entreprises dans des affaires pénales délicates.",
    education: [
      "Master en Droit Pénal - ULiège",
      "Certificat en Criminologie - UCLouvain",
    ],
    languages: ["Français", "Anglais", "Allemand"],
    articles: [
      {
        id: 1,
        title: "Évolution de la jurisprudence en matière de légitime défense",
        excerpt:
          "Analyse des récents arrêts de la Cour de cassation concernant les limites de la légitime défense.",
        content:
          "La notion de légitime défense a fait l'objet de plusieurs décisions importantes de la Cour de cassation...",
        publishedAt: "2024-01-12",
        readTime: "7 min",
        views: 934,
        comments: 18,
        tags: ["Légitime Défense", "Jurisprudence", "Cour de Cassation"],
      },
      {
        id: 2,
        title: "Les droits de la défense lors des interrogatoires",
        excerpt:
          "Guide complet sur les droits fondamentaux de la défense pendant la phase d'enquête pénale.",
        content:
          "Les droits de la défense constituent un pilier fondamental de notre système judiciaire...",
        publishedAt: "2024-01-05",
        readTime: "9 min",
        views: 756,
        comments: 12,
        tags: ["Droits de la Défense", "Interrogatoire", "Procédure"],
      },
    ],
  },
});

// Get current lawyer from route params
const lawyer = computed(() => {
  const lawyerId = lawyersData.value['jean-martin'].id;
  const foundLawyer = lawyersData.value[lawyerId];

  if (!foundLawyer) {
    // Handle not found case - could redirect or show error
    // router.push("/404");
    return null;
  }

  return foundLawyer;
});

// Helper functions
const getInitials = (name) => {
  return name
    .split(" ")
    .map((n) => n[0])
    .join("");
};

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString("fr-FR");
};

// Check if lawyer exists on mount
onMounted(() => {
  if (!lawyer.value) {
    // router.push("/404");
  }
});
</script>