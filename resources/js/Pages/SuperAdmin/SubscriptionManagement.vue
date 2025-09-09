<script setup>
import { ref, computed } from 'vue'

import { 
  Search,      // MagnifyingGlassIcon
  DollarSign,  // BanknotesIcon
  BarChart2    // ChartBarIcon
} from 'lucide-vue-next'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import SubscriptionChart from '@/Components/AdminComponents/SubscriptionChart.vue'
import FilterBar from '@/Components/AdminComponents/FilterBar.vue'
import DataTable from '@/Components/AdminComponents/DataTable.vue'
import ActionModal from '@/Components/AdminComponents/ActionModal.vue'

const searchQuery = ref('')
const selectedFilter = ref('all')
const showCancelModal = ref(false)
const selectedSubscription = ref(null)

const subscriptions = ref([
  {
    id: 1,
    user: 'Jean Dupont',
    email: 'jean.dupont@email.com',
    plan: 'Premium',
    status: 'Actif',
    amount: '€29.99',
    nextBilling: '15/02/2024',
    duration: '6 mois',
    paymentMethod: 'Carte bancaire'
  },
  {
    id: 2,
    user: 'Marie Martin', 
    email: 'marie.martin@email.com',
    plan: 'Standard',
    status: 'Actif',
    amount: '€19.99',
    nextBilling: '20/02/2024',
    duration: '3 mois',
    paymentMethod: 'PayPal'
  },
  {
    id: 3,
    user: 'Pierre Legrand',
    email: 'pierre.legrand@email.com',
    plan: 'Premium',
    status: 'Annulé',
    amount: '€29.99',
    nextBilling: '-',
    duration: '1 mois',
    paymentMethod: 'Carte bancaire'
  },
  {
    id: 4,
    user: 'Sophie Bernard',
    email: 'sophie.bernard@email.com',
    plan: 'Enterprise',
    status: 'Actif',
    amount: '€99.99',
    nextBilling: '10/02/2024',
    duration: '12 mois',
    paymentMethod: 'Virement'
  }
])

const columns = [
  { key: 'user', label: 'Utilisateur', sortable: true },
  { key: 'email', label: 'Email', sortable: true },
  { key: 'plan', label: 'Plan', sortable: true },
  { key: 'status', label: 'Statut', sortable: true },
  { key: 'amount', label: 'Montant', sortable: true },
  { key: 'nextBilling', label: 'Prochaine facturation', sortable: true },
  { key: 'duration', label: 'Durée', sortable: true },
  { key: 'paymentMethod', label: 'Mode de paiement', sortable: false },
  { key: 'actions', label: 'Actions', sortable: false }
]

const filterOptions = [
  { value: 'all', label: 'Tous les abonnements' },
  { value: 'active', label: 'Actifs' },
  { value: 'canceled', label: 'Annulés' },
  { value: 'premium', label: 'Premium' },
  { value: 'standard', label: 'Standard' },
  { value: 'enterprise', label: 'Enterprise' }
]

const stats = computed(() => [
  {
    title: 'Revenus totaux',
    value: '€45,230',
    change: '+12%',
    trend: 'up',
    icon: 'revenue'
  },
  {
    title: 'Abonnements actifs',
    value: '1,247',
    change: '+8%', 
    trend: 'up',
    icon: 'subscriptions'
  },
  {
    title: 'Taux de conversion',
    value: '24.8%',
    change: '+3%',
    trend: 'up',
    icon: 'conversion'
  },
  {
    title: 'Taux d\'annulation',
    value: '2.1%',
    change: '-1%',
    trend: 'down',
    icon: 'churn'
  }
])

const handleCancelSubscription = (subscription) => {
  selectedSubscription.value = subscription
  showCancelModal.value = true
}

const confirmCancelSubscription = () => {
  if (selectedSubscription.value) {
    console.log('Canceling subscription:', selectedSubscription.value)
  }
  showCancelModal.value = false
  selectedSubscription.value = null
}
</script>

<template>
  <AdminLayout>
    <div class="subscription-management">
    <!-- Page header -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Gestion des abonnements</h1>
        <p class="page-subtitle">Gérer les plans, paiements et facturation</p>
      </div>
      <div class="header-actions">
        <button class="flex items-center gap-3 px-6 py-2 text-white transition rounded-lg bg-primary hover:bg-green-700">
          <BarChart2 class="w-4 h-4" />
          Rapport financier
        </button>
        <button class="flex items-center gap-3 px-6 py-2 text-gray-600 transition bg-gray-100 border-2 border-gray-400 rounded-lg hover:bg-gray-400 hover:text-white">
          <DollarSign class="w-4 h-4" />
          Nouveau plan
        </button>
      </div>
    </div>

    <!-- Revenue stats -->
    <div class="stats-section">
      <div class="stats-grid">
        <div v-for="stat in stats" :key="stat.title" class="stat-card">
          <div class="stat-header">
            <h3 class="stat-title">{{ stat.title }}</h3>
            <div class="stat-trend" :class="stat.trend === 'up' ? 'trend-up' : 'trend-down'">
              {{ stat.change }}
            </div>
          </div>
          <div class="stat-value">{{ stat.value }}</div>
        </div>
      </div>
    </div>

    <!-- Chart section -->
    <div class="chart-section">
      <SubscriptionChart />
    </div>

    <!-- Filters and search -->
    <div class="filters-section">
      <div class="search-bar">
        <div class="search-wrapper">
          <Search class="search-icon" />
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Rechercher par utilisateur ou email..."
            class="search-input"
          >
        </div>
      </div>
      
      <FilterBar
        v-model="selectedFilter"
        :options="filterOptions"
        icon-component="FunnelIcon"
      />
    </div>

    <!-- Subscriptions table -->
    <div class="table-container">
      <DataTable
        :data="subscriptions"
        :columns="columns"
        @action="handleCancelSubscription"
      />
    </div>

    <!-- Cancel subscription modal -->
    <ActionModal
      v-if="showCancelModal"
      title="Annuler l'abonnement"
      :message="`Êtes-vous sûr de vouloir annuler l'abonnement ${selectedSubscription?.plan} de ${selectedSubscription?.user} ?`"
      confirm-text="Annuler l'abonnement"
      cancel-text="Garder l'abonnement"
      type="destructive"
      @confirm="confirmCancelSubscription"
      @cancel="showCancelModal = false"
    />
  </div>
  </AdminLayout>
</template>

<style scoped>
.subscription-management {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
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

.header-actions {
  display: flex;
  gap: 0.75rem;
}

.stats-section {
  margin-bottom: 1rem;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}

.stat-card {
  background-color: var(--card);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 1.5rem;
  box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
}

.stat-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.stat-title {
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--muted-foreground);
  margin: 0;
}

.stat-trend {
  font-size: 0.75rem;
  font-weight: 600;
  padding: 0.25rem 0.5rem;
  border-radius: calc(var(--radius) / 2);
}

.trend-up {
  background-color: oklch(0.95 0.05 120);
  color: var(--success);
}

.trend-down {
  background-color: oklch(0.95 0.05 25);
  color: var(--error);
}

.stat-value {
  font-size: 2rem;
  font-weight: 700;
  color: var(--foreground);
}

.chart-section {
  background-color: var(--card);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 1.5rem;
  box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
}

.filters-section {
  display: flex;
  gap: 1rem;
  align-items: center;
  flex-wrap: wrap;
}

.search-bar {
  flex: 1;
  max-width: 24rem;
}

.search-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.search-icon {
  position: absolute;
  left: 0.75rem;
  height: 1rem;
  width: 1rem;
  color: var(--muted-foreground);
  pointer-events: none;
}

.search-input {
  width: 100%;
  padding: 0.625rem 0.75rem 0.625rem 2.5rem;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  background-color: var(--input);
  font-size: 0.875rem;
  transition: border-color 150ms ease-in-out;
}

.search-input:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 2px var(--ring);
}

.table-container {
  background-color: var(--card);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  overflow: hidden;
}

@media (max-width: 1024px) {
  .stats-grid {
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1rem;
  }
}

@media (max-width: 768px) {
  .page-header {
    flex-direction: column;
    align-items: stretch;
  }
  
  .header-actions {
    justify-content: stretch;
  }
  
  .filters-section {
    flex-direction: column;
    align-items: stretch;
  }
  
  .search-bar {
    max-width: none;
  }
  
  .stats-grid {
    grid-template-columns: 1fr;
  }
}
</style>