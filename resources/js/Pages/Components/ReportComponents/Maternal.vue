<script setup>
import { computed, ref } from "vue";
import { HandHeart, Baby, AlertTriangle, CalendarX } from "lucide-vue-next";
import { useModalStore } from "@/stores/modal";
import ModalWrapper from "../ModalWrapper.vue";

const modal = useModalStore();

const props = defineProps({
    maternals: {
        type: Array,
        default: () => [],
    },
});

function getUniquePuroks() {
    return [...new Set(props.maternals.map((m) => m.purok).filter(Boolean))];
}

function getMothersByPurok(purok) {
    return props.maternals.filter((m) => m.purok === purok);
}

function countPregnancies(purok) {
    return getMothersByPurok(purok).filter((m) => m.status === "ongoing")
        .length;
}
function countMissedPrenatal(purok) {
    return getMothersByPurok(purok).filter((m) =>
        m.schedules?.some((s) => s.status === "missed")
    ).length;
}
function countHighRisks(purok) {
    return getMothersByPurok(purok).filter((m) =>
        m.maternal_records?.some((r) => r.status === "high risk")
    ).length;
}
function countDelivered(purok) {
    return getMothersByPurok(purok).filter((m) =>
        m.maternal_records?.some((r) => r.status === "delivered")
    ).length;
}

const allPregnancies = computed(() =>
    props.maternals.filter((p) => p.status === "ongoing")
);
const allDelivered = computed(() =>
    props.maternals.filter((p) => p.status === "delivered")
);
const allHighRisk = computed(() =>
    props.maternals.filter((p) => p.status === "high risk")
);
const allMissedPrenatal = computed(() =>
    props.maternals.filter((m) =>
        m.schedules?.some((s) => s.status === "missed")
    )
);

const purokStats = computed(() => {
    const stats = {};
    getUniquePuroks().forEach((purok) => {
        stats[purok] = {
            pregnancies: countPregnancies(purok),
            delivered: countDelivered(purok),
            highRisks: countHighRisks(purok),
            missedPrenatal: countMissedPrenatal(purok),
        };
    });
    return stats;
});

const selectedPurok = ref("All");

const filteredPurokStats = computed(() => {
    if (selectedPurok.value === "All") return purokStats.value;
    return { [selectedPurok.value]: purokStats.value[selectedPurok.value] };
});

const totalPregnancies = computed(() =>
    Object.values(purokStats.value).reduce((sum, s) => sum + s.pregnancies, 0)
);
const totalDelivered = computed(() =>
    Object.values(purokStats.value).reduce((sum, s) => sum + s.delivered, 0)
);
const totalHighRisks = computed(() =>
    Object.values(purokStats.value).reduce((sum, s) => sum + s.highRisks, 0)
);
const totalMissedPrenatal = computed(() =>
    Object.values(purokStats.value).reduce(
        (sum, s) => sum + s.missedPrenatal,
        0
    )
);

import TotalPregnancies from "../ReportComponents/MaternalChild/TotalPregnancies.vue";
import Delivered from "../ReportComponents/MaternalChild/Delivered.vue";
import HighRisks from "../ReportComponents/MaternalChild/HighRisks.vue";
import MissedPrenatal from "../ReportComponents/MaternalChild/MissedPrenatal.vue";

function openTotalPreganciesModal() {
    modal.openModal(TotalPregnancies, {
        title: "Total Pregnancies",
        total: allPregnancies,
    });
}
function openDeliveredModal() {
    modal.openModal(Delivered, { title: "Delivered", total: allDelivered });
}
function openHighRisksModal() {
    modal.openModal(HighRisks, { title: "High Risks", total: allHighRisk });
}
function openMissedPrenatalModal() {
    modal.openModal(MissedPrenatal, {
        title: "Missed Prenatal",
        total: allMissedPrenatal,
    });
}

const perPage = ref(6);
const currentPage = ref(1);

const totalPages = computed(() =>
    Math.ceil(Object.keys(filteredPurokStats.value).length / perPage.value)
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
</script>

<template>
    <div class="w-full h-full p-4 space-y-6">
        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div @click="openTotalPreganciesModal"
                class="cursor-pointer bg-sky-300 text-sky-900 shadow-lg rounded-2xl p-5 transform hover:scale-105 transition duration-300">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-white rounded-full">
                        <HandHeart class="w-7 h-7" />
                    </span>
                    <div>
                        <p class="text-3xl font-bold">{{ totalPregnancies }}</p>
                        <p class="text-lg font-semibold">Total Pregnancies</p>
                    </div>
                </div>
            </div>
            <div @click="openDeliveredModal"
                class="cursor-pointer bg-green-300 text-green-900 shadow-lg rounded-2xl p-5 transform hover:scale-105 transition duration-300">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-white rounded-full">
                        <Baby class="w-7 h-7" />
                    </span>
                    <div>
                        <p class="text-3xl font-bold">{{ totalDelivered }}</p>
                        <p class="text-lg font-semibold">Delivered</p>
                    </div>
                </div>
            </div>
            <div @click="openHighRisksModal"
                class="cursor-pointer bg-yellow-300 text-yellow-900 shadow-lg rounded-2xl p-5 transform hover:scale-105 transition duration-300">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-white rounded-full">
                        <AlertTriangle class="w-7 h-7" />
                    </span>
                    <div>
                        <p class="text-3xl font-bold">{{ totalHighRisks }}</p>
                        <p class="text-lg font-semibold">High Risks</p>
                    </div>
                </div>
            </div>
            <div @click="openMissedPrenatalModal"
                class="cursor-pointer bg-red-300 text-red-900 shadow-lg rounded-2xl p-5 transform hover:scale-105 transition duration-300">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-white rounded-full">
                        <CalendarX class="w-7 h-7" />
                    </span>
                    <div>
                        <p class="text-3xl font-bold">
                            {{ totalMissedPrenatal }}
                        </p>
                        <p class="text-lg font-semibold">Missed Prenatal</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purok Filter-->
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
                        <th class="p-3 text-left">Total Pregnancies</th>
                        <th class="p-3 text-left">High Risks</th>
                        <th class="p-3 text-left">Delivered</th>
                        <th class="p-3 text-left">Missed Prenatal Visits</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(summary, purok) in filteredPurokStats" :key="purok"
                        class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition h-[40px] border-y">
                        <td class="p-3 truncate">{{ purok }}</td>
                        <td class="p-3">{{ summary.pregnancies }}</td>
                        <td class="p-3">{{ summary.highRisks }}</td>
                        <td class="p-3">{{ summary.delivered }}</td>
                        <td class="p-3">{{ summary.missedPrenatal }}</td>
                    </tr>

                        <tr v-for="n in Math.max(
                            0,
                            perPage - Object.keys(filteredPurokStats).length
                        )" :key="'empty-' + n" class="h-[40px] border-b">
                            <td colspan="5" class="p-2"></td>
                        </tr>
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
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">
                    ◀ Prev
                </button>
                <button @click="nextPage" :disabled="currentPage === totalPages || currentPage === 1"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">
                    Next ▶
                </button>
            </div>
        </div>

        <!-- Modal Wrapper -->
        <ModalWrapper />
    </div>
</template>
