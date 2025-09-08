<script setup>
import { X } from "lucide-vue-next";
import { useModalStore } from "@/stores/modal";
import { ref } from "vue";

const modal = useModalStore();
function close() {
    modal.closeModal();
}

const activeTab = ref("prenatal");

// Props
const props = defineProps({
    record: Object,
});

// Date formatter
const formatDate = (dateStr) => {
    if (!dateStr) return "N/A";
    const date = new Date(dateStr);
    return date.toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};
</script>

<template>
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div
            class="bg-white rounded-2xl shadow-2xl w-full max-w-[90vw] p-6 relative min-h-[85vh] max-h-[90vh] overflow-y-auto">
            <!-- Close Button -->
            <button @click="close" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <X class="w-6 h-6" />
            </button>

            <!-- Header -->
            <h2 class="text-2xl font-bold text-blue-700 border-b pb-3 mb-3">
                Maternal Record #{{ record?.id }}
            </h2>

            <!-- Tabs -->
            <div class="flex flex-wrap items-center justify-between pb-3 gap-2 mb-3">
                <div class="flex flex-wrap gap-2">
                    <button @click="activeTab = 'prenatal'" :class="activeTab === 'prenatal'
                        ? 'bg-blue-600 text-white'
                        : 'bg-blue-100 text-blue-700'
                        " class="px-4 py-2 rounded-full transition">
                        Prenatal records
                    </button>
                    <button @click="activeTab = 'postnatal'" :class="activeTab === 'postnatal'
                        ? 'bg-blue-600 text-white'
                        : 'bg-blue-100 text-blue-700'
                        " class="px-4 py-2 rounded-full transition">
                        Postnatal records
                    </button>
                    <button @click="activeTab = 'medical'" :class="activeTab === 'medical'
                        ? 'bg-blue-600 text-white'
                        : 'bg-blue-100 text-blue-700'
                        " class="px-4 py-2 rounded-full transition">
                        Medical record
                    </button>
                    <button @click="activeTab = 'delivery'" :class="activeTab === 'delivery'
                        ? 'bg-blue-600 text-white'
                        : 'bg-blue-100 text-blue-700'
                        " class="px-4 py-2 rounded-full transition">
                        Delivery record
                    </button>
                </div>
            </div>

            <div v-if="activeTab === 'prenatal'">
                <!-- Prenatal Records -->
                <div v-if="record?.prenatal_records?.length" class="mb-10">
                    <div class="overflow-hidden rounded-lg shadow border border-gray-200">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-blue-600 text-white uppercase text-xs tracking-wide">
                                <tr>
                                    <th class="px-4 py-3">Record No.</th>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3">Blood Pressure</th>
                                    <th class="px-4 py-3">Heart Rate</th>
                                    <th class="px-4 py-3">Fetal Heart Rate</th>
                                    <th class="px-4 py-3">Fundal Height</th>
                                    <th class="px-4 py-3">Fetal Position</th>
                                    <th class="px-4 py-3">Swelling</th>
                                    <th class="px-4 py-3">Nutritional Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(p, i) in record.prenatal_records" :key="i"
                                    class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 border">{{ p.id }}</td>
                                    <td class="px-4 py-2 border">
                                        {{ formatDate(p.date) }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ p.blood_pressure }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ p.heart_rate }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ p.fetal_heart_rate }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ p.fundal_height }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ p.fetal_position }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ p.swelling }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ p.nutritional_status }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div v-if="activeTab === 'postnatal'">
                <!-- Postnatal Records -->
                <div v-if="record?.postnatal_records?.length">
                    <div class="overflow-hidden rounded-lg shadow border border-gray-200">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-blue-600 text-white uppercase text-xs tracking-wide">
                                <tr>
                                    <th class="px-4 py-3">Record No.</th>
                                    <th class="px-4 py-3">Check Up Date</th>
                                    <th class="px-4 py-3">Days After Delivery</th>
                                    <th class="px-4 py-3">Mother Condition</th>
                                    <th class="px-4 py-3">Baby Condition</th>
                                    <th class="px-4 py-3">Supplement</th>
                                    <th class="px-4 py-3">Remarks</th>
                                    <th class="px-4 py-3">Recorded By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(p, i) in record.postnatal_records" :key="i"
                                    class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 border">{{ p.id }}</td>
                                    <td class="px-4 py-2 border">
                                        {{ formatDate(p.checkup_date) }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ p.days_after_delivery }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ p.mother_condition }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ p.baby_condition }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ p.supplement }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ p.remarks }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ p.recorded_by }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div v-if="activeTab === 'medical'">
                <!-- Left Section -->
                <div class="lg:col-span-2 bg-white border border-blue-700 rounded-lg p-6 shadow-md">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- LMP -->
                        <div>
                            <label class="block text-sm font-medium">LMP: </label>
                            <div class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">
                                {{ props.record.lmp }}
                            </div>
                        </div>
                        <!-- LMP -->
                        <div>
                            <label class="block text-sm font-medium">ECD: </label>
                            <div class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">
                                {{ props.record.ecd }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-6">
                        <!-- OB Score -->
                        <div>
                            <label class="block text-sm font-medium mb-2">OB Score: </label>
                            <div class="grid grid-cols-5 gap-3">
                                <!-- G -->
                                <div class="flex items-center gap-2">
                                    <label class="font-semibold">G: </label>
                                    <p class="text-gray-700 border border-blue-500 rounded px-2 py-1 w-12 text-center">
                                        {{ props.record.ob_score_g }}
                                    </p>
                                </div>

                                <!-- T -->
                                <div class="flex items-center gap-2">
                                    <label class="font-semibold">T: </label>
                                    <p class="text-gray-700 border border-blue-500 rounded px-2 py-1 w-12 text-center">
                                        {{ props.record.ob_score_t }}
                                    </p>
                                </div>

                                <!-- P -->
                                <div class="flex items-center gap-2">
                                    <label class="font-semibold">P: </label>
                                    <p class="text-gray-700 border border-blue-500 rounded px-2 py-1 w-12 text-center">
                                        {{ props.record.ob_score_p }}
                                    </p>
                                </div>

                                <!-- L -->
                                <div class="flex items-center gap-2">
                                    <label class="font-semibold">L: </label>
                                    <p class="text-gray-700 border border-blue-500 rounded px-2 py-1 w-12 text-center">
                                        {{ props.record.ob_score_l }}
                                    </p>
                                </div>

                                <!-- A -->
                                <div class="flex items-center gap-2">
                                    <label class="font-semibold">A: </label>
                                    <p class="text-gray-700 border border-blue-500 rounded px-2 py-1 w-12 text-center">
                                        {{ props.record.ob_score_a }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- TT/Td Status -->
                        <div>
                            <label class="block text-sm font-medium mb-2">TT/Td Status: </label>
                            <p class="text-gray-700 border border-blue-500 rounded px-2 py-1">
                                {{ props.record.tt_status }}
                            </p>
                        </div>


                    </div>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Past Deliveries: </label>
                            <p class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">
                                {{ props.record.maternal_record_no }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">High-Risk Pregnancy: </label>
                            <p class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">
                                {{ record?.high_risk ?? "N/A" }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="activeTab ==='delivery'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-5 border border-blue-700 rounded-lg">
                    <div>
                        <label class="block text-sm font-medium">Place</label>
                        <div class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">
                            {{ record?.delivery.place }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Birth Attendant</label>
                        <div class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">
                            {{ record?.delivery.birth_attendant }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Delivery Date</label>
                        <div class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">
                            {{ record?.delivery.date }}
                        </div>

                    </div>

                    <div>
                        <label class="block text-sm font-medium">Delivery Type</label>
                        <div class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">
                            {{ record?.delivery.type }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Complication</label>
                        <div class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">
                           {{ record?.delivery.complication }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Remarks</label>
                        <div class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">
                            {{ record?.delivery.remarks }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- No Records -->
            <p v-if="
                !record?.prenatal_records?.length &&
                !record?.postnatal_records?.length
            " class="text-gray-500 italic text-center py-6">
                No records available.
            </p>
        </div>
    </div>
</template>
