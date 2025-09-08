<script setup>
import { computed, ref } from "vue";
import { Syringe, Baby, AlertTriangle, CalendarX } from "lucide-vue-next";
import { useModalStore } from "@/stores/modal";
import ModalWrapper from "../ModalWrapper.vue";

import TotalImmnized from "../ReportComponents/ImmunizationChild/TotalImmunized.vue";
import FullyImmunized from "../ReportComponents/ImmunizationChild/FullyImmunized.vue";
import PartiallyImmunized from "../ReportComponents/ImmunizationChild/PartiallyImmunized.vue";
import MissedImmunized from "../ReportComponents/ImmunizationChild/MissedImmunized.vue";

const modal = useModalStore();

const props = defineProps({
    childs: {
        type: Array,
        default: () => [],
    },
});

// Utility functions
function getUniquePuroks() {
    return [...new Set(props.childs.map((c) => c.purok))];
}

function getChildsByPurok(purok) {
    return props.childs.filter((c) => c.purok === purok);
}

function countTotalImmunized(purok) {
    return getChildsByPurok(purok).reduce(
        (sum, child) => sum + (child.immunization_record?.length || 0),
        0
    );
}

function countFullyImmunized(purok) {
    return getChildsByPurok(purok).reduce(
        (sum, child) =>
            sum +
            (child.immunization_record?.filter((r) => r.status === "fully")
                .length || 0),
        0
    );
}

function countPartiallyImmunized(purok) {
    return getChildsByPurok(purok).reduce(
        (sum, child) =>
            sum +
            (child.immunization_record?.filter((r) => r.status === "partially")
                .length || 0),
        0
    );
}

function countMissedImmunized(purok) {
    return getChildsByPurok(purok).reduce(
        (sum, child) =>
            sum +
            (child.immunization_record?.filter((r) => r.status === "missed")
                .length || 0),
        0
    );
}

// Global totals
const allImmunized = computed(() =>
    props.childs.reduce(
        (sum, child) => sum + (child.immunization_record?.length || 0),
        0
    )
);
const allFully = computed(() =>
    props.childs.reduce(
        (sum, child) =>
            sum +
            (child.immunization_record?.filter((r) => r.status === "fully")
                .length || 0),
        0
    )
);
const allPartially = computed(() =>
    props.childs.reduce(
        (sum, child) =>
            sum +
            (child.immunization_record?.filter((r) => r.status === "partially")
                .length || 0),
        0
    )
);
const allMissed = computed(() =>
    props.childs.reduce(
        (sum, child) =>
            sum +
            (child.immunization_record?.filter((r) => r.status === "missed")
                .length || 0),
        0
    )
);

// Stats per purok
const purokStats = computed(() => {
    const stats = {};
    getUniquePuroks().forEach((purok) => {
        stats[purok] = {
            total: countTotalImmunized(purok),
            fully: countFullyImmunized(purok),
            partially: countPartiallyImmunized(purok),
            missed: countMissedImmunized(purok),
        };
    });
    return stats;
});
const selectedPurok = ref("All");
const filteredPurokStats = computed(() => {
    if (selectedPurok.value === "All") return purokStats.value;
    return { [selectedPurok.value]: purokStats.value[selectedPurok.value] };
});

// Pagination
const perPage = ref(6);
const currentPage = ref(1);
const totalPages = computed(() =>
    Math.ceil(Object.keys(purokStats.value).length / perPage.value)
);

function goToPage(page) {
    if (page >= 1 && page <= totalPages.value) currentPage.value = page;
}
function nextPage() {
    goToPage(currentPage.value + 1);
}
function prevPage() {
    goToPage(currentPage.value - 1);
}

const totalImmunized = computed(() =>
    props.childs.filter((m) => m.immunization_record)
);

const fullyImmunized = computed(() =>
    props.childs.filter((m) =>
        m.immunization_record?.some((s) => s.status === "fully")
    )
);
const partiallyImmunized = computed(() =>
    props.childs.filter((m) =>
        m.immunization_record?.some((s) => s.status === "partially")
    )
);
const missedImmunized = computed(() =>
    props.childs.filter((m) =>
        m.immunization_record?.some((s) => s.status === "missed")
    )
);

function openTotalImmunized() {
    modal.openModal(TotalImmnized, {
        title: "Total Immunized",
        total: totalImmunized,
    });
}
function openFullyImmunized() {
    modal.openModal(FullyImmunized, {
        title: "Fully Immunized",
        total: fullyImmunized,
    });
}
function openPartiallyImmunized() {
    modal.openModal(PartiallyImmunized, {
        title: "Partially Immunized",
        total: partiallyImmunized,
    });
}
function openMissedImmunized() {
    modal.openModal(MissedImmunized, {
        title: "Missed Immunized",
        total: missedImmunized,
    });
}
</script>

<template>
    <div class="w-full h-full p-4 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div @click="openTotalImmunized"
                class="cursor-pointer bg-sky-300 text-sky-900 shadow-lg rounded-2xl p-5 transform hover:scale-105 transition duration-300">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-white rounded-full">
                        <Syringe class="w-7 h-7" />
                    </span>
                    <div>
                        <p class="text-3xl font-bold">{{ allImmunized }}</p>
                        <p class="text-lg font-semibold shadow-sm">
                            Total Immunized
                        </p>
                    </div>
                </div>
            </div>

            <div @click="openFullyImmunized"
                class="cursor-pointer bg-green-300 text-green-900 shadow-lg rounded-2xl p-5 transform hover:scale-105 transition duration-300">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-white rounded-full">
                        <Baby class="w-7 h-7" />
                    </span>
                    <div>
                        <p class="text-3xl font-bold">{{ allFully }}</p>
                        <p class="text-lg font-semibold shadow-sm">
                            Fully Immunized
                        </p>
                    </div>
                </div>
            </div>

            <div @click="openPartiallyImmunized"
                class="cursor-pointer bg-yellow-300 text-yellow-900 shadow-lg rounded-2xl p-5 transform hover:scale-105 transition duration-300">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-white rounded-full">
                        <AlertTriangle class="w-7 h-7" />
                    </span>
                    <div>
                        <p class="text-3xl font-bold">{{ allPartially }}</p>
                        <p class="text-lg font-semibold shadow-sm">
                            Partially Immunized
                        </p>
                    </div>
                </div>
            </div>

            <div @click="openMissedImmunized"
                class="cursor-pointer bg-red-300 text-red-900 shadow-lg rounded-2xl p-5 transform hover:scale-105 transition duration-300">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-white rounded-full">
                        <CalendarX class="w-7 h-7" />
                    </span>
                    <div>
                        <p class="text-3xl font-bold">{{ allMissed }}</p>
                        <p class="text-lg font-semibold shadow-sm">
                            Missed Immunized
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center mb-2">
            <label class="mr-2 font-medium text-gray-700">Filter by Purok:</label>
            <select v-model="selectedPurok" class="border rounded-lg px-3 py-1">
                <option value="All">All</option>
                <option v-for="purok in Object.keys(purokStats)" :key="purok" :value="purok">
                    {{ purok }}
                </option>
            </select>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg border">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-blue-600 text-white sticky top-0 z-10">
                    <tr>
                        <th class="p-3 text-left">Purok Name</th>
                        <th class="p-3 text-left">Total Immunized</th>
                        <th class="p-3 text-left">Fully Immunized</th>
                        <th class="p-3 text-left">Partially Immunized</th>
                        <th class="p-3 text-left">Missed Immunized</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(summary, purok) in filteredPurokStats" :key="purok"
                        class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition h-[40px] border-y">
                        <td class="p-3 truncate">{{ purok }}</td>
                        <td class="p-3">{{ summary.total }}</td>
                        <td class="p-3">{{ summary.fully }}</td>
                        <td class="p-3">{{ summary.partially }}</td>
                        <td class="p-3">{{ summary.missed }}</td>
                    </tr>
                    <!-- Empty rows to keep table height fixed -->
                    <tr v-for="n in Math.max(
                        0,
                        perPage - Object.keys(filteredPurokStats).length
                    )" :key="'empty-' + n" class="h-[40px] border-b">
                        <td colspan="5" class="p-2"></td>
                    </tr>

                    <!-- No records -->
                    <tr v-if="Object.keys(filteredPurokStats).length === 0" class="bg-gray-50 h-[40px]">
                        <td colspan="5" class="p-3 text-center text-gray-500 italic">
                            No records found
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-6 text-sm">
            <span class="text-gray-600">
                Page {{ currentPage }} of {{ totalPages }} | Total:
                {{ Object.keys(filteredPurokStats).length }}
            </span>
            <div class="space-x-2">
                <button @click="prevPage" :disabled="currentPage === 1"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 transition">
                    ◀ Prev
                </button>
                <button @click="nextPage" :disabled="currentPage === totalPages"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 transition">
                    Next ▶
                </button>
            </div>
        </div>

        <!-- Modal Wrapper -->
        <ModalWrapper />
    </div>
</template>
