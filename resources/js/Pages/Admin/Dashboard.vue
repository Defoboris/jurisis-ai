<template>
  <div class="min-h-screen bg-background">
    <!-- Admin Header -->
    <header class="border-b border-border/50 bg-card">
      <div class="container px-4 py-4 mx-auto">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <a href="/" class="text-2xl font-bold font-heading text-primary">
              Jurisis
            </a>
            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-secondary text-secondary-foreground">
              Admin
            </span>
          </div>
          <div class="flex items-center gap-4">
            <button class="inline-flex items-center justify-center px-3 text-sm font-medium transition-colors border rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input bg-background hover:bg-accent hover:text-accent-foreground h-9">
              <Eye class="w-4 h-4 mr-2" />
              Voir mon profil public
            </button>
            <div class="relative flex w-8 h-8 overflow-hidden rounded-full shrink-0">
              <img 
                :src="currentLawyer.avatar || '/placeholder.svg'" 
                :alt="currentLawyer.name"
                class="w-full h-full aspect-square"
              />
              <div class="flex items-center justify-center w-full h-full text-sm rounded-full bg-primary/10 text-primary">
                {{ currentLawyer.name.split(' ').map(n => n[0]).join('') }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="container px-4 py-8 mx-auto">
      <div class="mb-8">
        <h1 class="mb-2 text-3xl font-bold font-heading text-foreground">Tableau de bord</h1>
        <p class="text-muted-foreground">
          Bienvenue {{ currentLawyer.name.split(' ')[0] }}, gérez votre profil et vos articles d'expertise.
        </p>
      </div>

      <div class="space-y-6">
        <!-- Tabs Navigation -->
        <div class="inline-flex grid items-center justify-center w-full h-10 grid-cols-4 p-1 rounded-md bg-muted text-muted-foreground lg:w-auto lg:grid-cols-4">
          <button
            v-for="tab in tabs"
            :key="tab.value"
            @click="activeTab = tab.value"
            :class="[
              'inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50',
              activeTab === tab.value ? 'bg-background text-foreground shadow-sm' : ''
            ]"
            class="flex items-center gap-2"
          >
            <component :is="tab.icon" class="w-4 h-4" />
            {{ tab.label }}
          </button>
        </div>

        <!-- Overview Tab -->
        <div v-if="activeTab === 'overview'" class="space-y-6">
          <!-- Stats Cards -->
          <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div v-for="stat in statsCards" :key="stat.title" class="border rounded-lg shadow-sm bg-card text-card-foreground">
              <div class="flex flex-row items-center justify-between p-6 pb-2 space-y-0">
                <h3 class="text-sm font-medium tracking-tight">{{ stat.title }}</h3>
                <component :is="stat.icon" class="w-4 h-4 text-muted-foreground" />
              </div>
              <div class="p-6 pt-0">
                <div class="text-2xl font-bold">{{ stat.value }}</div>
                <p class="text-xs text-muted-foreground">{{ stat.change }}</p>
              </div>
            </div>
          </div>

          <!-- Recent Activity -->
          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Recent Articles Card -->
            <div class="border rounded-lg shadow-sm bg-card text-card-foreground">
              <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight font-heading">Articles récents</h3>
                <p class="text-sm text-muted-foreground">Vos dernières publications et brouillons</p>
              </div>
              <div class="p-6 pt-0 space-y-4">
                <div
                  v-for="article in currentLawyer.recentArticles"
                  :key="article.id"
                  class="flex items-center justify-between p-3 border rounded-lg border-border/50"
                >
                  <div class="flex-1">
                    <h4 class="mb-1 text-sm font-medium">{{ article.title }}</h4>
                    <div class="flex items-center gap-4 text-xs text-muted-foreground">
                      <span :class="[
                        'inline-flex items-center rounded-full px-2 py-1 text-xs font-medium',
                        article.status === 'published' 
                          ? 'bg-primary text-primary-foreground' 
                          : 'bg-secondary text-secondary-foreground'
                      ]">
                        {{ article.status === 'published' ? 'Publié' : 'Brouillon' }}
                      </span>
                      <template v-if="article.status === 'published'">
                        <span class="flex items-center gap-1">
                          <Eye class="w-3 h-3" />
                          {{ article.views }}
                        </span>
                        <span class="flex items-center gap-1">
                          <MessageCircle class="w-3 h-3" />
                          {{ article.comments }}
                        </span>
                      </template>
                    </div>
                  </div>
                  <button class="inline-flex items-center justify-center text-sm font-medium transition-colors rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 w-9">
                    <Edit class="w-4 h-4" />
                  </button>
                </div>
                <a href="/admin/articles">
                  <button class="inline-flex items-center justify-center w-full h-10 px-4 py-2 text-sm font-medium transition-colors bg-transparent border rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-accent hover:text-accent-foreground">
                    Voir tous les articles
                  </button>
                </a>
              </div>
            </div>

            <!-- Performance Card -->
            <div class="border rounded-lg shadow-sm bg-card text-card-foreground">
              <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight font-heading">Performances</h3>
                <p class="text-sm text-muted-foreground">Statistiques de votre profil ce mois</p>
              </div>
              <div class="p-6 pt-0 space-y-4">
                <div class="space-y-3">
                  <div v-for="metric in performanceMetrics" :key="metric.label" class="flex items-center justify-between">
                    <span class="text-sm">{{ metric.label }}</span>
                    <span :class="['font-semibold', metric.highlight ? 'text-primary' : '']">{{ metric.value }}</span>
                  </div>
                </div>
                <button class="inline-flex items-center justify-center w-full h-10 px-4 py-2 text-sm font-medium transition-colors bg-transparent border rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-accent hover:text-accent-foreground">
                  <TrendingUp class="w-4 h-4 mr-2" />
                  Voir les analytics détaillées
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Articles Tab -->
        <div v-if="activeTab === 'articles'" class="space-y-6">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-2xl font-bold font-heading">Gestion des articles</h2>
              <p class="text-muted-foreground">Créez et gérez vos articles d'expertise juridique</p>
            </div>
            <a href="/admin/articles/new">
              <button class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90">
                <Plus class="w-4 h-4 mr-2" />
                Nouvel article
              </button>
            </a>
          </div>

          <div class="border rounded-lg shadow-sm bg-card text-card-foreground">
            <div class="p-6">
              <div class="space-y-4">
                <div
                  v-for="article in currentLawyer.recentArticles"
                  :key="article.id"
                  class="flex items-center justify-between p-4 transition-colors border rounded-lg border-border/50 hover:bg-muted/50"
                >
                  <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                      <h3 class="font-medium">{{ article.title }}</h3>
                      <span :class="[
                        'inline-flex items-center rounded-full px-2 py-1 text-xs font-medium',
                        article.status === 'published' 
                          ? 'bg-primary text-primary-foreground' 
                          : 'bg-secondary text-secondary-foreground'
                      ]">
                        {{ article.status === 'published' ? 'Publié' : 'Brouillon' }}
                      </span>
                    </div>
                    <div class="flex items-center gap-6 text-sm text-muted-foreground">
                      <span v-if="article.publishedAt" class="flex items-center gap-1">
                        <Calendar class="w-3 h-3" />
                        {{ formatDate(article.publishedAt) }}
                      </span>
                      <template v-if="article.status === 'published'">
                        <span class="flex items-center gap-1">
                          <Eye class="w-3 h-3" />
                          {{ article.views }} vues
                        </span>
                        <span class="flex items-center gap-1">
                          <MessageCircle class="w-3 h-3" />
                          {{ article.comments }} commentaires
                        </span>
                        <span class="flex items-center gap-1">
                          <Star class="w-3 h-3" />
                          {{ article.likes }} j'aime
                        </span>
                      </template>
                    </div>
                  </div>
                  <div class="flex items-center gap-2">
                    <button class="inline-flex items-center justify-center text-sm font-medium transition-colors rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 w-9">
                      <Edit class="w-4 h-4" />
                    </button>
                    <button class="inline-flex items-center justify-center text-sm font-medium transition-colors rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 w-9">
                      <Eye class="w-4 h-4" />
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Profile Tab -->
        <div v-if="activeTab === 'profile'" class="space-y-6">
          <div>
            <h2 class="mb-2 text-2xl font-bold font-heading">Gestion du profil</h2>
            <p class="text-muted-foreground">Modifiez vos informations professionnelles et spécialisations</p>
          </div>

          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="border rounded-lg shadow-sm bg-card text-card-foreground">
              <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight font-heading">Informations personnelles</h3>
              </div>
              <div class="p-6 pt-0 space-y-4">
                <div class="flex items-center gap-4">
                  <div class="relative flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                    <img 
                      :src="currentLawyer.avatar || '/placeholder.svg'" 
                      :alt="currentLawyer.name"
                      class="w-full h-full aspect-square"
                    />
                  </div>
                  <div>
                    <h3 class="font-semibold">{{ currentLawyer.name }}</h3>
                    <p class="text-sm text-muted-foreground">{{ currentLawyer.title }}</p>
                    <button class="inline-flex items-center justify-center px-3 mt-2 text-sm font-medium transition-colors bg-transparent border rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-accent hover:text-accent-foreground h-9">
                      Changer la photo
                    </button>
                  </div>
                </div>
                <button class="inline-flex items-center justify-center w-full h-10 px-4 py-2 text-sm font-medium transition-colors bg-transparent border rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-accent hover:text-accent-foreground">
                  Modifier les informations
                </button>
              </div>
            </div>

            <div class="border rounded-lg shadow-sm bg-card text-card-foreground">
              <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight font-heading">Spécialisations</h3>
              </div>
              <div class="p-6 pt-0 space-y-4">
                <div class="flex flex-wrap gap-2">
                  <span
                    v-for="specialty in currentLawyer.specialties"
                    :key="specialty"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-secondary text-secondary-foreground"
                  >
                    {{ specialty }}
                  </span>
                </div>
                <button class="inline-flex items-center justify-center w-full h-10 px-4 py-2 text-sm font-medium transition-colors bg-transparent border rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-accent hover:text-accent-foreground">
                  Modifier les spécialisations
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Settings Tab -->
        <div v-if="activeTab === 'settings'" class="space-y-6">
          <div>
            <h2 class="mb-2 text-2xl font-bold font-heading">Paramètres</h2>
            <p class="text-muted-foreground">Configurez vos préférences et paramètres de compte</p>
          </div>

          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="border rounded-lg shadow-sm bg-card text-card-foreground">
              <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight font-heading">Notifications</h3>
              </div>
              <div class="p-6 pt-0 space-y-4">
                <div class="space-y-3">
                  <div v-for="notification in notificationSettings" :key="notification.label" class="flex items-center justify-between">
                    <span class="text-sm">{{ notification.label }}</span>
                    <button class="inline-flex items-center justify-center px-3 text-sm font-medium transition-colors border rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input bg-background hover:bg-accent hover:text-accent-foreground h-9">
                      {{ notification.status }}
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="border rounded-lg shadow-sm bg-card text-card-foreground">
              <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight font-heading">Sécurité</h3>
              </div>
              <div class="p-6 pt-0 space-y-4">
                <button
                  v-for="securityOption in securityOptions"
                  :key="securityOption"
                  class="inline-flex items-center justify-start justify-center w-full h-10 px-4 py-2 text-sm font-medium transition-colors bg-transparent border rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-accent hover:text-accent-foreground"
                >
                  {{ securityOption }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import {
  BarChart3,
  BookOpen,
  Calendar,
  Eye,
  MessageCircle,
  Settings,
  TrendingUp,
  Users,
  FileText,
  Star,
  Plus,
  Edit,
} from 'lucide-vue-next'

const activeTab = ref('overview')

const currentLawyer = ref({
  id: "marie-dubois",
  name: "Marie Dubois",
  title: "Avocate en Droit des Affaires",
  avatar: "/professional-female-lawyer.png",
  specialties: ["Droit Commercial", "Fusions & Acquisitions", "Droit Fiscal"],
  stats: {
    totalArticles: 24,
    totalViews: 15420,
    totalComments: 187,
    totalLikes: 892,
    monthlyViews: 3240,
    profileViews: 1847,
  },
  recentArticles: [
    {
      id: 1,
      title: "Les nouvelles réglementations européennes sur les acquisitions",
      status: "published",
      publishedAt: "2024-01-15",
      views: 1247,
      comments: 23,
      likes: 89,
    },
    {
      id: 2,
      title: "Optimisation fiscale lors des restructurations d'entreprises",
      status: "published",
      publishedAt: "2024-01-08",
      views: 892,
      comments: 15,
      likes: 67,
    },
    {
      id: 3,
      title: "Guide pratique des contrats de distribution",
      status: "draft",
      publishedAt: null,
      views: 0,
      comments: 0,
      likes: 0,
    },
  ],
})

const tabs = [
  { value: 'overview', label: 'Vue d\'ensemble', icon: BarChart3 },
  { value: 'articles', label: 'Articles', icon: BookOpen },
  { value: 'profile', label: 'Profil', icon: Users },
  { value: 'settings', label: 'Paramètres', icon: Settings },
]

const statsCards = computed(() => [
  {
    title: 'Articles publiés',
    value: currentLawyer.value.stats.totalArticles,
    change: '+2 ce mois-ci',
    icon: FileText
  },
  {
    title: 'Vues totales',
    value: currentLawyer.value.stats.totalViews.toLocaleString(),
    change: `+${currentLawyer.value.stats.monthlyViews} ce mois`,
    icon: Eye
  },
  {
    title: 'Commentaires',
    value: currentLawyer.value.stats.totalComments,
    change: '+12 cette semaine',
    icon: MessageCircle
  },
  {
    title: 'J\'aime',
    value: currentLawyer.value.stats.totalLikes,
    change: '+45 cette semaine',
    icon: Star
  }
])

const performanceMetrics = computed(() => [
  { label: 'Vues du profil', value: currentLawyer.value.stats.profileViews },
  { label: 'Vues des articles', value: currentLawyer.value.stats.monthlyViews },
  { label: 'Taux d\'engagement', value: '12.4%', highlight: true },
  { label: 'Temps de lecture moyen', value: '6m 32s' }
])

const notificationSettings = [
  { label: 'Nouveaux commentaires', status: 'Activé' },
  { label: 'Mentions J\'aime', status: 'Activé' },
  { label: 'Rapport mensuel', status: 'Activé' }
]

const securityOptions = [
  'Changer le mot de passe',
  'Authentification à deux facteurs',
  'Sessions actives'
]

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('fr-FR')
}
</script>