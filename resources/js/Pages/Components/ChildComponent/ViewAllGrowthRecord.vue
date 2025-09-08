<script setup>
import { ref, computed, inject, watchEffect } from "vue";

const emit = defineEmits(["closeAllGrowthRecord"]);

const perPage = ref(6);
const searchTerm = ref("");
const feedingFilter = ref("");
const currentPage = ref(1);

const selectedChildProfile = inject("selectedChildProfile");
if (!selectedChildProfile) {
    throw new Error("selectedChildProfile not provided!");
}

const immunizationRecords = ref(
    selectedChildProfile.value?.immunization_record ?? []
);

const filteredRecords = computed(() =>
    immunizationRecords.value.filter((rec) => {
        const matchesSearch =
            !searchTerm.value ||
            Object.values(rec).some((val) =>
                String(val ?? "")
                    .toLowerCase()
                    .includes(searchTerm.value.toLowerCase())
            );

        const matchesFeeding =
            !feedingFilter.value || rec.type_of_feeding === feedingFilter.value;

        return matchesSearch && matchesFeeding;
    })
);

const totalPages = computed(() =>
    Math.ceil(filteredRecords.value.length / perPage.value)
);

const paginatedRecords = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    return filteredRecords.value.slice(start, start + perPage.value);
});

function nextPage() {
    if (currentPage.value < totalPages.value) currentPage.value++;
}

function prevPage() {
    if (currentPage.value > 1) currentPage.value--;
}

</script>

<template>
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div
            class="p-6 bg-white rounded-2xl shadow-2xl relative min-h-[50vh] max-w-[90%] max-h-[90vh] w-full overflow-y-auto animate-fadeIn"
        >
            <!-- Close button -->
            <button
                class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition"
                @click="emit('closeAllGrowthRecord')"
            >
                ✖
            </button>

            <h2 class="text-xl font-bold text-blue-700 mb-1">
                All Growth Records
            </h2>
            <p class="text-green-600 font-medium mb-6">
                Patient: {{ selectedChildProfile.child_name }}
            </p>

            <!-- Filters -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <input
                    type="text"
                    v-model="searchTerm"
                    placeholder="🔍 Search records..."
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                />

                <select
                    v-model="feedingFilter"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                >
                    <option value="">All Feeding Types</option>
                    <option value="Breastfeeding">Breastfeeding</option>
                    <option value="Formula">Formula</option>
                    <option value="Mixed">Mixed</option>
                </select>
            </div>

            <!-- Table -->
<div class="overflow-x-auto rounded-lg border">
  <table class="w-full text-sm table-fixed border-collapse">
    <thead class="bg-blue-600 text-white sticky top-0 z-10">
      <tr>
        <th class="p-3 text-left">Date</th>
        <th class="p-3 text-left">Age (Months)</th>
        <th class="p-3 text-left">Weight (KG)</th>
        <th class="p-3 text-left">Height (CM)</th>
        <th class="p-3 text-left">Supplement</th>
        <th class="p-3 text-left">Feeding</th>
        <th class="p-3 text-left">Notes</th>
      </tr>
    </thead>
    <tbody>
      <!-- Records -->
      <tr
        v-for="(record, index) in paginatedRecords"
        :key="record.id || index"
        class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition h-[40px]"
      >
        <td class="p-3">{{ record.date_of_vaccination }}</td>
        <td class="p-3">{{ record.vaccine_name }}</td>
        <td class="p-3 font-semibold text-blue-700">{{ record.weight }}</td>
        <td class="p-3 font-semibold text-green-700">{{ record.height }}</td>
        <td class="p-3">{{ record.vaccine_name }}</td>
        <td class="p-3">
          <span
            class="px-2 py-1 rounded-full text-xs font-medium"
            :class="{
              'bg-green-100 text-green-700': record.type_of_feeding === 'Breastfeeding',
              'bg-yellow-100 text-yellow-700': record.type_of_feeding === 'Formula',
              'bg-purple-100 text-purple-700': record.type_of_feeding === 'Mixed',
            }"
          >
            {{ record.type_of_feeding }}
          </span>
        </td>
        <td class="p-3 text-gray-600">{{ record.notes }}</td>
      </tr>

      <!-- Empty rows to maintain fixed height -->
      <tr
        v-for="n in perPage - paginatedRecords.length"
        :key="'empty-' + n"
        class="h-[40px] border-b"
      >
        <td colspan="7" class="p-2"></td>
      </tr>

      <!-- No records -->
      <tr v-if="paginatedRecords.length === 0" class="bg-gray-50 h-[40px]">
        <td colspan="7" class="p-6 text-center text-gray-500 italic">
          No records found
        </td>
      </tr>
    </tbody>
  </table>
</div>


            <!-- Pagination -->
            <div
                v-if="filteredRecords.length > perPage"
                class="flex justify-between items-center mt-6 text-sm"
            >
                <span class="text-gray-600">
                    Page {{ currentPage }} of {{ totalPages }} |
                    <span class="font-medium">{{
                        filteredRecords.length
                    }}</span>
                    total records
                </span>
                <div class="space-x-2">
                    <button
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 disabled:opacity-50 transition"
                        :disabled="currentPage === 1"
                        @click="prevPage"
                    >
                        ◀ Previous
                    </button>
                    <button
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 transition"
                        :disabled="currentPage === totalPages"
                        @click="nextPage"
                    >
                        Next ▶
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
.animate-fadeIn {
    animation: fadeIn 0.25s ease-in-out;
}
</style>
