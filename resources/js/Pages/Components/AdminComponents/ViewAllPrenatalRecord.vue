<script setup>
import { ref, computed, inject } from "vue";

const emit = defineEmits(["closePrenatalRecords"]);

const selectedMaternalProfile = inject("selectedMaternalProfile");
if (!selectedMaternalProfile) throw new Error("selectedMaternalProfile not provided!");

// Active maternal record
const activeRecord = computed(() => {
    const maternalRecords = selectedMaternalProfile.value?.maternal_records ?? [];
    return maternalRecords.find((r) => r.isPresent === "yes");
});

const prenatalRecords = computed(() => activeRecord.value?.prenatal_records ?? []);

const perPage = ref(9);

</script>

<template>
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div
            class="p-6 bg-white rounded-2xl shadow-2xl relative w-full max-w-[90%] max-h-[90vh] overflow-y-auto animate-fadeIn">
            <!-- Close button -->
            <button class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition text-xl font-bold"
                @click="emit('closePrenatalRecords')">
                ✖
            </button>

            <h2 class="text-xl font-bold text-blue-700 mb-2">All Prenatal Records</h2>
            <p class="text-green-600 font-medium mb-4">
                Patient: {{ selectedMaternalProfile.name }}
            </p>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg border">
                <table class="w-full text-sm table-fixed border-collapse">
                    <thead class="bg-blue-600 text-white sticky top-0 z-10">
                        <tr>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Weight</th>
                            <th class="p-3 text-left">Blood Pressure</th>
                            <th class="p-3 text-left">Heart_rate</th>
                            <th class="p-3 text-left">Fundal Height</th>
                            <th class="p-3 text-left">Fetal Heart Rate</th>
                            <th class="p-3 text-left">Fetal Position</th>
                            <th class="p-3 text-left">Swelling</th>
                            <th class="p-3 text-left">Nutritional Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(record, index) in prenatalRecords" :key="index"
                            class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition h-[40px] border-b">
                            <td class="p-3 truncate">{{ record.date }}</td>
                            <td class="p-3 truncate">{{ record.weight }}</td>
                            <td class="p-3 truncate">{{ record.blood_pressure }}</td>
                            <td class="p-3 truncate">{{ record.heart_rate }}</td>
                            <td class="p-3 truncate">{{ record.fundal_height }}</td>
                            <td class="p-3 truncate">{{ record.fetal_heart_rate }}</td>
                            <td class="p-3 truncate">{{ record.fetal_position }}</td>
                            <td class="p-3 truncate">{{ record.swelling }}</td>
                            <td class="p-3 truncate">{{ record.nutritional_status }}</td>
                        </tr>

                        <!-- Empty rows to keep table height -->
                        <tr v-for="n in perPage - prenatalRecords.length" :key="'empty-' + n"
                            class="h-[40px] border-b">
                            <td colspan="9" class="p-2"></td>
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
