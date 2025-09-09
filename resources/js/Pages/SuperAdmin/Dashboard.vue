<template>
  <AdminLayout>
    <div class="dashboard-overview">
      <!-- Page header -->
      <div class="page-header">
        <h1 class="page-title">Tableau de bord</h1>
        <p class="page-subtitle">Vue d'ensemble de la plateforme Jurisis</p>
      </div>

      <!-- Stats grid -->
      <div class="stats-grid">
        <StatsCard
          v-for="stat in stats"
          :key="stat.title"
          :title="stat.title"
          :value="stat.value"
          :change="stat.change"
          :trend="stat.trend"
          :icon="stat.icon"
        />
      </div>

      <!-- Main content grid -->
      <div class="content-grid">
        <!-- Quick actions -->
        <div class="content-section">
          <QuickActions />
        </div>

        <!-- Recent activity -->
        <div class="content-section">
          <RecentActivity />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
<script setup>
import { ref } from "vue";
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import StatsCard from "@/Components/AdminComponents/StatsCard.vue";
import QuickActions from "@/Components/AdminComponents/QuickActions.vue";
import RecentActivity from "@/Components/AdminComponents/RecentActivity.vue";


const stats = ref([
  {
    title: 'Utilisateurs Total',
    value: '12,847',
    change: '+12%',
    trend: 'up',
    icon: 'users'
  },
  {
    title: 'Avocats Actifs',
    value: '1,234',
    change: '+8%',
    trend: 'up',
    icon: 'lawyers'
  },
  {
    title: 'Abonnements',
    value: '8,672',
    change: '+15%',
    trend: 'up',
    icon: 'subscriptions'
  },
  {
    title: 'Revenus Mensuel',
    value: '€45,230',
    change: '+23%',
    trend: 'up',
    icon: 'revenue'
  }
])
</script>
<style scoped>
.dashboard-overview {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.page-header {
  margin-bottom: 1rem;
}

.page-title {
  font-size: 2rem;
  font-weight: 700;
  color: var(--foreground);
  margin-bottom: 0.5rem;
}

.page-subtitle {
  color: var(--muted-foreground);
  font-size: 1rem;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}

.content-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2rem;
}

.content-section {
  display: flex;
  flex-direction: column;
}

@media (max-width: 1024px) {
  .content-grid {
    grid-template-columns: 1fr;
  }

  .stats-grid {
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1rem;
  }
}

@media (max-width: 768px) {
  .page-title {
    font-size: 1.75rem;
  }

  .stats-grid {
    grid-template-columns: 1fr;
  }
}
</style>