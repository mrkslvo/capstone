<script setup>
import { ref, computed, inject } from "vue";

const emit = defineEmits(["closePostnatalRecords"]);

const selectedMaternalProfile = inject("selectedMaternalProfile");
if (!selectedMaternalProfile) throw new Error("selectedMaternalProfile not provided!");

const perPage = ref(9);
;
// Fetch postnatal records
const postnatalRecords = computed(() => {
    const record = selectedMaternalProfile.value.maternal_records.find(r => r.isPresent === "yes");
    return record ? record.postnatal_records : [];
});


</script>

<template>
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div
            class="p-6 bg-white rounded-2xl shadow-2xl relative w-full max-w-[90%] max-h-[90vh] overflow-y-auto animate-fadeIn">

            <!-- Close button -->
            <button class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition text-xl font-bold"
                @click="emit('closePostnatalRecords')">✖</button>

            <h2 class="text-xl font-bold text-blue-700 mb-2">All Postnatal Records</h2>
            <p class="text-green-600 font-medium mb-4">Patient: {{ selectedMaternalProfile.name }}</p>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg border">
                <table class="w-full text-sm table-fixed border-collapse">
                    <thead class="bg-blue-600 text-white sticky top-0">
                        <tr>
                            <th class="p-3 text-left">Checkup Date</th>
                            <th class="p-3 text-left">Days After Delivery</th>
                            <th class="p-3 text-left">Mother Condition</th>
                            <th class="p-3 text-left">Baby Condition</th>
                            <th class="p-3 text-left">Supplement</th>
                            <th class="p-3 text-left">Remarks</th>
                            <th class="p-3 text-left">Recorded By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(record, index) in postnatalRecords" :key="index"
                            class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition  border-b">
                            <td class="p-3 truncate">{{ record.checkup_date }}</td>
                            <td class="p-3 truncate">{{ record.days_after_delivery }}</td>
                            <td class="p-3 truncate">{{ record.mother_condition }}</td>
                            <td class="p-3 truncate">{{ record.baby_condition }}</td>
                            <td class="p-3 truncate">{{ record.supplement }}</td>
                            <td class="p-3 truncate">{{ record.remarks }}</td>
                            <td class="p-3 truncate">{{ record.recorded_by }}</td>
                        </tr>

                        <!-- Empty rows for consistent height -->
                        <tr v-for="n in perPage - postnatalRecords.length" :key="'empty-' + n"
                            class="border-b h-[40px]">
                            <td colspan="7" class="p-2"></td>
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
