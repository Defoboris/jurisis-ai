<script setup>
import { ref, onMounted } from 'vue'

const chartRef = ref(null)

onMounted(async () => {
  if (!chartRef.value) return

  const { Chart, registerables } = await import('chart.js')
  Chart.register(...registerables)

  const ctx = chartRef.value.getContext('2d')
  if (!ctx) return

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
      datasets: [
        {
          label: 'Revenus (€)',
          data: [32000, 35000, 38000, 42000, 45000, 48000, 52000, 49000, 53000, 56000, 58000, 62000],
          borderColor: '#4F46E5',
          backgroundColor: 'rgba(79, 70, 229, 0.1)',
          tension: 0.3,
          fill: true
        },
        {
          label: 'Nouveaux abonnements',
          data: [120, 145, 160, 180, 195, 210, 225, 200, 240, 260, 275, 290],
          borderColor: '#EC4899',
          backgroundColor: 'rgba(236, 72, 153, 0.1)',
          tension: 0.3,
          yAxisID: 'y1'
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'top', labels: { padding: 20, boxWidth: 12 } },
        title: {
          display: true,
          text: 'Évolution des revenus et abonnements 2024',
          font: { size: 16, weight: '600' }
        },
        tooltip: { mode: 'index', intersect: false }
      },
      interaction: { mode: 'nearest', axis: 'x', intersect: false },
      scales: {
        y: { type: 'linear', display: true, position: 'left' },
        y1: { type: 'linear', display: true, position: 'right', grid: { drawOnChartArea: false } }
      }
    }
  })
})
</script>

<template>
  <div class="w-full p-6 bg-white shadow rounded-xl">
    <!-- Header -->
    <div class="flex flex-col gap-4 mb-6 md:flex-row md:justify-between md:items-center">
      <h3 class="text-xl font-semibold text-gray-900">Analyse des revenus</h3>
      <select class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        <option value="year">Cette année</option>
        <option value="month">Ce mois</option>
        <option value="week">Cette semaine</option>
      </select>
    </div>

    <!-- Chart -->
    <div class="relative w-full h-96 md:h-80">
      <canvas ref="chartRef"></canvas>
    </div>
  </div>
</template>
