<script setup>
import { ref, computed, inject, watchEffect } from "vue";

const emit = defineEmits(["closeAllImmunizationRecord"]);

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


function pillClass(type) {
    return ({
        fully: "bg-green-300 text-green-900",
        partially: "bg-yellow-300 text-yellow-900",
        missed: "bg-red-300 text-red-900",
    }[type] || "bg-slate-300 text-slate-800");
}
</script>

<template>
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div
            class="p-6 bg-white rounded-2xl shadow-2xl relative min-h-[50vh] max-w-[90%] max-h-[90vh] w-full overflow-y-auto animate-fadeIn">
            <!-- Close button -->
            <button class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition text-xl"
                @click="emit('closeAllImmunizationRecord')">
                ✖
            </button>

            <h2 class="text-xl font-bold text-blue-700 mb-1">
                All Immunization Records
            </h2>
            <p class="text-green-600 font-medium mb-6">
                Patient: {{ selectedChildProfile.child_name }}
            </p>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg border">
                <table class="w-full text-sm table-fixed border-collapse">
                    <thead class="bg-blue-600 text-white sticky top-0 z-10">
                        <tr>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Vaccine</th>
                            <th class="p-3 text-left">Weight (KG)</th>
                            <th class="p-3 text-left">Height (CM)</th>
                            <th class="p-3 text-left">Feeding</th>
                            <th class="p-3 text-left">Notes</th>
                            <th class="p-3 text-left">status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Records -->
                        <tr v-for="(record, index) in immunizationRecords" :key="record.id || index"
                            class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition h-[40px]  border-b">
                            <td class="p-3">{{ record.date_of_vaccination }}</td>
                            <td class="p-3">{{ record.vaccine_name }}</td>
                            <td class="p-3 font-semibold text-blue-700">{{ record.weight }}</td>
                            <td class="p-3 font-semibold text-green-700">{{ record.height }}</td>
                            <td class="p-3">{{ record.type_of_feeding }}</td>
                            <td class="p-3 text-gray-600">{{ record.notes }}</td>
                            <td class="p-3 font-semibold"> <span class="text-xs px-2 py-1 rounded font-bold"
                                    :class="pillClass(record.status)">
                                    {{ record.status }} Immunized
                                </span></td>
                        </tr>
                    </tbody>
                </table>
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
