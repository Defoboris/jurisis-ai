<template>
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white divide-y divide-gray-200 rounded-lg shadow-sm dark:divide-neutral-700 dark:bg-neutral-900">
      <thead class="bg-gray-50 dark:bg-neutral-800">
        <tr>
          <th
            v-for="col in props.columns"
            :key="col.key"
            @click="col.sortable ? handleSort(col.key) : null"
            :class="['px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200 select-none', col.sortable ? 'cursor-pointer' : '']"
          >
            <div class="flex items-center gap-2">
              {{ col.label }}
              <span v-if="col.sortable" class="flex items-center">
                <ChevronUp v-if="sortKey === col.key && sortOrder === 'asc'" class="w-4 h-4 text-gray-500" />
                <ChevronDown v-else-if="sortKey === col.key && sortOrder === 'desc'" class="w-4 h-4 text-gray-500" />
                <ChevronsUpDown v-else class="w-4 h-4 text-gray-400" />
              </span>
            </div>
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
        <tr
          v-for="(item, idx) in sortedData"
          :key="item.id"
          class="transition hover:bg-gray-50 dark:hover:bg-neutral-800"
        >
          <td
            v-for="col in props.columns"
            :key="`${item.id}-${col.key}`"
            class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200"
          >
            <template v-if="col.key === 'status'">
              <span :class="['px-2 py-1 rounded-full text-xs font-medium', getStatusBadgeClass(item[col.key]) ]">
                {{ item[col.key] }}
              </span>
            </template>
            <template v-else-if="col.key === 'actions'">
              <div class="inline-block ">
                <button
                  @click="toggleDropdown(idx)"
                  class="p-1 rounded hover:bg-gray-100 dark:hover:bg-neutral-800"
                >
                  <MoreVertical class="w-5 h-5 text-gray-500 dark:text-gray-300" />
                </button>
                <div
                  v-if="activeDropdown === idx"
                  class="absolute right-0 z-10 mt-1 overflow-hidden bg-white rounded-md shadow-lg w-36 dark:bg-neutral-800"
                >
                  <button
                    class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 dark:hover:bg-neutral-700"
                    @click="$emit('action', item); activeDropdown = null"
                  >
                    Modifier
                  </button>
                  <button
                    class="w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-100 dark:hover:bg-red-700 dark:text-red-400"
                    @click="$emit('action', item); activeDropdown = null"
                  >
                    {{ item.status === "Actif" ? "Bloquer" : "Débloquer" }}
                  </button>
                </div>
              </div>
            </template>
            <template v-else>
              {{ item[col.key] }}
            </template>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script setup lang="ts">
import { ref, computed } from "vue";
import { ChevronsUpDown, ChevronUp, ChevronDown, MoreVertical } from "lucide-vue-next";

interface Column {
  key: string;
  label: string;
  sortable: boolean;
}

interface Props {
  data: any[];
  columns: Column[];
}

const props = defineProps<Props>();
const emit = defineEmits<{ action: [item: any] }>();

const sortKey = ref("");
const sortOrder = ref<"asc" | "desc">("asc");
const activeDropdown = ref<number | null>(null);

const sortedData = computed(() => {
  if (!sortKey.value) return props.data;
  return [...props.data].sort((a, b) => {
    const aVal = a[sortKey.value];
    const bVal = b[sortKey.value];
    if (aVal < bVal) return sortOrder.value === "asc" ? -1 : 1;
    if (aVal > bVal) return sortOrder.value === "asc" ? 1 : -1;
    return 0;
  });
});

const handleSort = (key: string) => {
  if (sortKey.value === key) {
    sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
  } else {
    sortKey.value = key;
    sortOrder.value = "asc";
  }
};

const toggleDropdown = (index: number) => {
  activeDropdown.value = activeDropdown.value === index ? null : index;
};

const getStatusBadgeClass = (status: string) => {
  const s = status.toLowerCase();
  if (s === "actif") return "bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400";
  if (s === "bloqué" || s === "annulé") return "bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-400";
  if (s === "en attente") return "bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-400";
  return "bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400";
};
</script>

<style scoped>
/* Smooth dropdown backdrop click closure */
</style>
