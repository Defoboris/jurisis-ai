<template>
  <main class="min-h-screen bg-background">
    <!-- Header would be imported as a component -->
    
    <!-- Navigation -->
    <div class="border-b border-border/50">
      <div class="container px-4 py-4 mx-auto">
        <div class="flex items-center gap-2 text-sm text-muted-foreground">
          <Link :href="route('lawyers')" class="transition-colors hover:text-primary">
            Avocats
          </Link>
          <span>/</span>
          <Link :href="route('lawyer.show', curentLaywer.id)" class="transition-colors hover:text-primary">
            {{ props.lawyer.name }}
          </Link>
          <span>/</span>
          <span class="text-foreground">Article</span>
        </div>
      </div>
    </div>

    <!-- Article Header -->
    <section class="py-12 bg-gradient-to-br from-primary/5 to-secondary/5">
      <div class="container px-4 mx-auto">
        <div class="max-w-4xl mx-auto">
          <Link
            :href="route('lawyer.show', curentLaywer.id)"
            class="inline-flex items-center gap-2 mb-6 text-sm transition-colors text-muted-foreground hover:text-primary"
          >
            <ArrowLeft class="w-4 h-4" />
            Retour au profil de  {{ props.lawyer.name }}
          </Link>

          <div class="flex flex-wrap gap-2 mb-4">
            <span
              v-for="tag in article.tags"
              :key="tag"
              class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80"
            >
              {{ tag }}
            </span>
          </div>

          <h1 class="mb-6 text-3xl font-bold font-heading md:text-4xl text-foreground">
            {{ props.article.title }}
          </h1>

          <div class="flex items-center gap-6 mb-6 text-sm text-muted-foreground">
            <div class="flex items-center gap-1">
              <Calendar class="w-4 h-4" />
              {{ formatDate(props.article.publishedAt) }}
            </div>
            <div class="flex items-center gap-1">
              <Clock class="w-4 h-4" />
              {{ props.article.readTime }}
            </div>
            <div class="flex items-center gap-1">
              <Eye class="w-4 h-4" />
              {{ props.article.views }} vues
            </div>
            <div class="flex items-center gap-1">
              <MessageCircle class="w-4 h-4" />
              {{ props.article.comments }} commentaires
            </div>
          </div>

          <!-- Author Info -->
          <div class="flex items-center gap-4 p-4 border rounded-lg bg-card border-border/50">
            <div class="relative flex w-12 h-12 overflow-hidden rounded-full shrink-0">
              <img
                :src="curentLaywer.profile || '/placeholder.svg'"
                :alt="curentLaywer.name"
                class="w-full h-full aspect-square"
              />
            </div>
            <div>
              <p class="font-semibold">{{ props.lawyer.name }}</p>
              <p class="text-sm text-muted-foreground">{{ props.curentLaywer.specialty }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Article Content -->
    <section class="py-12">
      <div class="container px-4 mx-auto">
        <div class="grid max-w-4xl grid-cols-1 gap-8 mx-auto lg:grid-cols-4">
          <!-- Sidebar - Sharing & Actions -->
          <div class="order-2 lg:col-span-1 lg:order-1">
            <div class="sticky space-y-4 top-8">
              <div class="border rounded-lg shadow-sm bg-card text-card-foreground">
                <div class="flex flex-col space-y-1.5 p-6">
                  <h3 class="text-sm font-semibold leading-none tracking-tight">Actions</h3>
                </div>
                <div class="p-6 pt-0 space-y-3">
                  <button
                    @click="toggleLike"
                    class="inline-flex items-center justify-start w-full px-3 text-sm font-medium transition-colors bg-transparent border rounded-md whitespace-nowrap ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-accent hover:text-accent-foreground h-9"
                  >
                    <ThumbsUp class="w-4 h-4 mr-2" />
                    J'aime ({{ props.article.likes }})
                  </button>
                  <button
                    @click="toggleBookmark"
                    class="inline-flex items-center justify-start w-full px-3 text-sm font-medium transition-colors bg-transparent border rounded-md whitespace-nowrap ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-accent hover:text-accent-foreground h-9"
                  >
                    <Bookmark class="w-4 h-4 mr-2" />
                    Sauvegarder
                  </button>
                </div>
              </div>

              <div class="border rounded-lg shadow-sm bg-card text-card-foreground">
                <div class="flex flex-col space-y-1.5 p-6">
                  <h3 class="text-sm font-semibold leading-none tracking-tight">Partager</h3>
                </div>
                <div class="p-6 pt-0 space-y-3">
                  <button
                    @click="shareOn('twitter')"
                    class="inline-flex items-center justify-start w-full px-3 text-sm font-medium transition-colors bg-transparent border rounded-md whitespace-nowrap ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-accent hover:text-accent-foreground h-9"
                  >
                    <Twitter class="w-4 h-4 mr-2" />
                    Twitter
                  </button>
                  <button
                    @click="shareOn('linkedin')"
                    class="inline-flex items-center justify-start w-full px-3 text-sm font-medium transition-colors bg-transparent border rounded-md whitespace-nowrap ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-accent hover:text-accent-foreground h-9"
                  >
                    <Linkedin class="w-4 h-4 mr-2" />
                    LinkedIn
                  </button>
                  <button
                    @click="shareOn('email')"
                    class="inline-flex items-center justify-start w-full px-3 text-sm font-medium transition-colors bg-transparent border rounded-md whitespace-nowrap ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-accent hover:text-accent-foreground h-9"
                  >
                    <Mail class="w-4 h-4 mr-2" />
                    Email
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Content -->
          <div class="order-1 lg:col-span-3 lg:order-2">
            <div class="border rounded-lg shadow-sm bg-card text-card-foreground">
              <div class="p-8">
                <div class="prose prose-lg max-w-none">
                 
                  <div class="shrink-0 bg-border h-[1px] w-full my-8"></div>
                  <div class="article-content" v-html="props.article.content"></div>
                </div>
              </div>
            </div>

            <!-- Comments Section -->
            <div class="mt-8 border rounded-lg shadow-sm bg-card text-card-foreground">
              <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight font-heading">
                  Commentaires ({{ article.comments }})
                </h3>
              </div>
              <div class="p-6 pt-0">
                <div class="space-y-6">
                  <div class="py-8 text-center text-muted-foreground">
                    <MessageCircle class="w-12 h-12 mx-auto mb-4 opacity-50" />
                    <p>Les commentaires seront bientôt disponibles.</p>
                    <p class="text-sm">En attendant, n'hésitez pas à contacter {{ lawyer.name }} directement.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer would be imported as a component -->
  </main>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

import { Link } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'

const routeParams = usePage().props.value

import {
  ArrowLeft,
  Calendar,
  Clock,
  Eye,
  MessageCircle,
  ThumbsUp,
  Bookmark,
  Twitter,
  Linkedin,
  Mail,
} from 'lucide-vue-next'

const props = defineProps({
  article: {
    type: Object,
    required: true,
  },
  lawyer: {
    type: Object,
    required: true,
  },
  curentLaywer: {
    type: Object,
    required: true
  }
})
// Extended lawyer data with full article content
const lawyersData = {
  "marie-dubois": {
    id: "marie-dubois",
    name: "Marie Dubois",
    title: "Avocate en Droit des Affaires",
    avatar: "/professional-female-lawyer.png",
    articles: {
      "1": {
        id: "1",
        title: "Les nouvelles réglementations européennes sur les acquisitions",
        excerpt: "Analyse des récentes modifications du cadre réglementaire européen et leur impact sur les opérations de M&A.",
        content: `
# Les nouvelles réglementations européennes sur les acquisitions

Le paysage réglementaire européen en matière d'acquisitions a connu des évolutions significatives ces derniers mois, avec l'adoption de nouvelles directives qui transforment fondamentalement l'approche des opérations de fusions-acquisitions.

## Impact sur les seuils de notification

Les nouveaux seuils de notification ont été revus à la baisse, particulièrement pour les secteurs technologiques et pharmaceutiques. Cette modification vise à renforcer le contrôle des concentrations dans des secteurs stratégiques.

### Points clés à retenir :

- **Seuil global** : Abaissement de 5 milliards à 2,5 milliards d'euros
- **Seuil national** : Réduction de 250 millions à 100 millions d'euros
- **Secteurs spécifiques** : Règles particulières pour la tech et la pharma

## Procédures d'examen renforcées

La Commission européenne a également renforcé ses procédures d'examen, avec des délais d'instruction allongés et des obligations d'information accrues pour les parties notifiantes.

Les entreprises doivent désormais fournir des analyses d'impact concurrentiel plus détaillées, incluant :

1. Une évaluation des effets sur l'innovation
2. L'impact sur les chaînes d'approvisionnement
3. Les conséquences pour les consommateurs européens

## Recommandations pratiques

Pour naviguer dans ce nouveau cadre réglementaire, je recommande aux entreprises de :

- **Anticiper** les notifications dès la phase de négociation
- **Préparer** une documentation complète en amont
- **Consulter** des experts juridiques spécialisés

Ces évolutions marquent une nouvelle ère dans le contrôle des concentrations européennes, nécessitant une adaptation des stratégies d'acquisition.
        `,
        publishedAt: "2024-01-15",
        readTime: "8 min",
        views: 1247,
        comments: 23,
        likes: 89,
        tags: ["Réglementation", "M&A", "Europe"],
      },
      "2": {
        id: "2",
        title: "Optimisation fiscale lors des restructurations d'entreprises",
        excerpt: "Guide pratique pour optimiser la fiscalité lors des opérations de restructuration tout en respectant la conformité.",
        content: `
# Optimisation fiscale lors des restructurations d'entreprises

Les restructurations d'entreprises offrent de nombreuses opportunités d'optimisation fiscale, à condition de respecter scrupuleusement le cadre légal en vigueur.

## Stratégies d'optimisation

### 1. Choix de la structure juridique

Le choix de la structure juridique post-restructuration est crucial pour l'optimisation fiscale. Les options incluent :

- **Holding de participation** : Avantages du régime mère-fille
- **Société en commandite** : Flexibilité fiscale accrue
- **Structure européenne** : Optimisation transfrontalière

### 2. Timing des opérations

Le calendrier des opérations peut significativement impacter la charge fiscale :

- Étalement des plus-values sur plusieurs exercices
- Utilisation des déficits reportables
- Optimisation des amortissements

## Conformité réglementaire

L'optimisation fiscale doit impérativement respecter :

1. **Substance économique** : Réalité des opérations
2. **Abus de droit** : Éviter les montages artificiels
3. **Documentation** : Justification des choix structurels

## Cas pratiques

### Exemple 1 : Restructuration par apport-fusion

Une société holding acquiert une filiale par apport-fusion, permettant :
- Report des déficits de la société absorbée
- Optimisation de la structure capitalistique
- Réduction de l'impôt sur les sociétés

### Exemple 2 : Scission d'activités

La scission permet de séparer des activités distinctes tout en :
- Préservant les avantages fiscaux
- Optimisant la gestion des participations
- Facilitant les cessions futures

Ces stratégies nécessitent une analyse approfondie au cas par cas.
        `,
        publishedAt: "2024-01-08",
        readTime: "12 min",
        views: 892,
        comments: 15,
        likes: 67,
        tags: ["Fiscalité", "Restructuration", "Optimisation"],
      },
    },
  },
  "jean-martin": {
    id: "jean-martin",
    name: "Jean Martin",
    title: "Avocat en Droit Pénal",
    avatar: "/placeholder-ifxms.png",
    articles: {
      "1": {
        id: "1",
        title: "Évolution de la jurisprudence en matière de légitime défense",
        excerpt: "Analyse des récents arrêts de la Cour de cassation concernant les limites de la légitime défense.",
        content: `
# Évolution de la jurisprudence en matière de légitime défense

La notion de légitime défense a fait l'objet de plusieurs décisions importantes de la Cour de cassation ces derniers mois, redéfinissant les contours de cette cause d'irresponsabilité pénale.

## Rappel des conditions légales

La légitime défense suppose la réunion de conditions strictes :

### Conditions relatives à l'agression
- **Actualité** : L'agression doit être en cours ou imminente
- **Réalité** : L'agression doit être effective, non imaginaire
- **Injustice** : L'agression doit être illégitime

### Conditions relatives à la riposte
- **Nécessité** : La riposte doit être le seul moyen d'échapper au péril
- **Proportionnalité** : Les moyens employés doivent être proportionnés à la gravité de l'agression

## Évolutions jurisprudentielles récentes

### Arrêt du 15 novembre 2023

La Cour de cassation a précisé que l'appréciation de la proportionnalité doit tenir compte :
- Du contexte général de l'agression
- De l'état psychologique de la victime
- Des moyens disponibles pour échapper au danger

### Arrêt du 3 janvier 2024

Un arrêt récent a élargi la notion d'imminence, admettant la légitime défense dans des situations où l'agression, bien que non encore commencée, était certaine et très proche.

## Implications pratiques

Ces évolutions jurisprudentielles ont des conséquences importantes :

1. **Élargissement** du champ d'application de la légitime défense
2. **Appréciation** plus souple des conditions de proportionnalité
3. **Prise en compte** accrue du contexte psychologique

## Conseils pour la pratique

En tant qu'avocat pénaliste, je recommande :
- Une analyse minutieuse des circonstances factuelles
- La constitution d'un dossier médico-psychologique complet
- L'expertise des lieux et des moyens utilisés

Cette évolution jurisprudentielle témoigne d'une approche plus nuancée de la légitime défense.
        `,
        publishedAt: "2024-01-12",
        readTime: "7 min",
        views: 934,
        comments: 18,
        likes: 45,
        tags: ["Légitime Défense", "Jurisprudence", "Cour de Cassation"],
      },
    },
  },
}

// Get lawyer and article from route params
const lawyer = computed(() => lawyersData["jean-martin"] || null)
const article = computed(() => lawyer.value?.articles["1"] || null)
// Format date function
const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString("fr-FR", {
    year: "numeric",
    month: "long",
    day: "numeric",
  })
}

// Format article content
const formattedContent = computed(() => {
  if (!article.value) return ''
  
  return article.value.content
    .split("\n")
    .map((line) => {
      if (line.startsWith("# ")) {
        return `<h1 class="mt-8 mb-4 text-2xl font-bold font-heading text-foreground">${line.slice(2)}</h1>`
      }
      if (line.startsWith("## ")) {
        return `<h2 class="mt-6 mb-3 text-xl font-semibold font-heading text-foreground">${line.slice(3)}</h2>`
      }
      if (line.startsWith("### ")) {
        return `<h3 class="mt-4 mb-2 text-lg font-semibold font-heading text-foreground">${line.slice(4)}</h3>`
      }
      if (line.startsWith("- **") && line.includes("** :")) {
        const match = line.match(/- \*\*(.*?)\*\* : (.*)/)
        if (match) {
          const [, bold, rest] = match
          return `<li class="mb-2"><strong class="text-primary">${bold}</strong> : ${rest}</li>`
        }
      }
      if (line.startsWith("- ")) {
        return `<li class="mb-1 text-muted-foreground">${line.slice(2)}</li>`
      }
      if (line.match(/^\d+\. /)) {
        return `<li class="mb-2 text-muted-foreground">${line.replace(/^\d+\. /, "")}</li>`
      }
      if (line.trim() === "") {
        return "<br>"
      }
      return `<p class="mb-4 leading-relaxed text-foreground">${line}</p>`
    })
    .join("")
})

// Interactive functions
const toggleLike = () => {
  console.log('Article liked!')
  // Implement like functionality
}

const toggleBookmark = () => {
  console.log('Article bookmarked!')
  // Implement bookmark functionality
}

const shareOn = (platform) => {
  console.log(`Sharing on ${platform}`)
  // Implement sharing functionality
}

// Check if lawyer and article exist
const checkExistence = () => {
  if (!lawyer.value || !article.value) {
    // Handle 404 - redirect or show error
    console.error('Lawyer or article not found')
  }
}

onMounted(checkExistence)
</script>

<style scoped>
.article-content {
  line-height: 1.7;
}

.article-content h1,
.article-content h2,
.article-content h3 {
  margin-top: 2rem;
  margin-bottom: 1rem;
}

.article-content p {
  margin-bottom: 1rem;
}

.article-content ul,
.article-content ol {
  margin-left: 1.5rem;
  margin-bottom: 1rem;
}
</style>