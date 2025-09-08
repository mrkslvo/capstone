<script setup>
import { computed, ref } from "vue";
import { HandHeart, Baby, AlertTriangle, CalendarX } from "lucide-vue-next";
import { useModalStore } from "@/stores/modal";
import ModalWrapper from "../ModalWrapper.vue";
import TotalMeasured from "./GrowthChild/TotalMeasured.vue";
import Normal from "./GrowthChild/Normal.vue";
import Underweight from "./GrowthChild/Underweight.vue";
import Overweight from "./GrowthChild/Overweight.vue";

const modal = useModalStore();

const props = defineProps({
    growths: {
        type: Array,
        default: () => [],
    },
});

function getUniquePuroks() {
    return [
        ...new Set(
            props.growths.map((g) => g.child_profiles?.purok).filter(Boolean)
        ),
    ];
}

function getGrowthsByPurok(purok) {
    return props.growths.filter(
        (g) => g.child_profiles && g.child_profiles.purok === purok
    );
}

function countTotalMeasured(purok) {
    return getGrowthsByPurok(purok).length;
}
function countNormal(purok) {
    return getGrowthsByPurok(purok).filter((g) => g.status === "normal").length;
}
function countUnderweight(purok) {
    return getGrowthsByPurok(purok).filter((g) => g.status === "underweight")
        .length;
}
function countOverweight(purok) {
    return getGrowthsByPurok(purok).filter((g) => g.status === "overweight")
        .length;
}

function countAllMeasured() {
    return props.growths.length;
}
function countAllNormal() {
    return props.growths.filter((g) => g.status === "normal").length;
}
function countAllUnderweight() {
    return props.growths.filter((g) => g.status === "underweight").length;
}
function countAllOverweight() {
    return props.growths.filter((g) => g.status === "overweight").length;
}

// --- Modal ---
const allMeasured = computed(() => props.growths);
const allNormal = computed(() =>
    props.growths.filter((p) => p.status === "normal")
);
const allUnderweight = computed(() =>
    props.growths.filter((p) => p.status === "underweight")
);
const allOverweight = computed(() =>
    props.growths.filter((p) => p.status === "overweight")
);

function openTotalMeasured() {
    modal.openModal(TotalMeasured, {
        title: "Total Measured",
        total: allMeasured,
    });
}
function openNormal() {
    modal.openModal(Normal, {
        title: "Normal",
        length: countAllNormal(),
        total: allNormal,
    });
}
function openUnderweight() {
    modal.openModal(Underweight, {
        title: "Underweight",
        length: countAllUnderweight(),
        total: allUnderweight,
    });
}
function openOverweight() {
    modal.openModal(Overweight, {
        title: "Overweight",
        length: countAllOverweight(),
        total: allOverweight,
    });
}

// --- Filtering ---
const selectedPurok = ref("All");

const purokStats = computed(() => {
    const stats = {};
    const puroks = getUniquePuroks();
    puroks.forEach((purok) => {
        stats[purok] = {
            totalMeasured: countTotalMeasured(purok),
            normal: countNormal(purok),
            underweight: countUnderweight(purok),
            overweight: countOverweight(purok),
        };
    });
    return stats;
});

const filteredPurokStats = computed(() => {
    if (selectedPurok.value === "All") return purokStats.value;
    return { [selectedPurok.value]: purokStats.value[selectedPurok.value] };
});

// --- Pagination ---
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
            <div @click="openTotalMeasured"
                class="cursor-pointer bg-sky-300 text-sky-900 shadow-lg rounded-2xl p-5 transform hover:scale-105 transition">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-white rounded-full">
                        <HandHeart class="w-7 h-7" />
                    </span>
                    <div>
                        <p class="text-3xl font-bold">
                            {{ countAllMeasured() }}
                        </p>
                        <p class="text-lg font-semibold">Total Measured</p>
                    </div>
                </div>
            </div>
            <div @click="openNormal"
                class="cursor-pointer bg-green-300 text-green-900 shadow-lg rounded-2xl p-5 transform hover:scale-105 transition">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-white rounded-full">
                        <Baby class="w-7 h-7" />
                    </span>
                    <div>
                        <p class="text-3xl font-bold">{{ countAllNormal() }}</p>
                        <p class="text-lg font-semibold">Normal</p>
                    </div>
                </div>
            </div>
            <div @click="openUnderweight"
                class="cursor-pointer bg-yellow-300 text-yellow-900 shadow-lg rounded-2xl p-5 transform hover:scale-105 transition">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-white rounded-full">
                        <AlertTriangle class="w-7 h-7" />
                    </span>
                    <div>
                        <p class="text-3xl font-bold">
                            {{ countAllUnderweight() }}
                        </p>
                        <p class="text-lg font-semibold">Underweight</p>
                    </div>
                </div>
            </div>
            <div @click="openOverweight"
                class="cursor-pointer bg-red-300 text-red-900 shadow-lg rounded-2xl p-5 transform hover:scale-105 transition">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-white rounded-full">
                        <CalendarX class="w-7 h-7" />
                    </span>
                    <div>
                        <p class="text-3xl font-bold">
                            {{ countAllOverweight() }}
                        </p>
                        <p class="text-lg font-semibold">Overweight</p>
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
                        <th class="p-3 text-left">Total Measured</th>
                        <th class="p-3 text-left">Normal</th>
                        <th class="p-3 text-left">Underweight</th>
                        <th class="p-3 text-left">Overweight</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(summary, purok) in filteredPurokStats" :key="purok"
                        class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition h-[40px] font-bold border-y">
                        <td class="p-3">{{ purok }}</td>
                        <td class="p-3 text-red-500">
                            {{ summary.totalMeasured }}
                        </td>
                        <td class="p-3 text-green-500">{{ summary.normal }}</td>
                        <td class="p-3 text-yellow-500">
                            {{ summary.underweight }}
                        </td>
                        <td class="p-3 text-red-500">
                            {{ summary.overweight }}
                        </td>
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

        <ModalWrapper />
    </div>
</template>
