<script setup>

import { ref, computed } from "vue";

import Maternal from "../Components/ReportComponents/Maternal.vue";
import Growth from "../Components/ReportComponents/Growth.vue";
import Immunization from "../Components/ReportComponents/Immunization.vue";


const props = defineProps({
    maternals: {
        type: Array,
        default: () => []
    },
    childs: {
        type: Array,
        default: () => []
    },
    growths: {
        type: Array,
        default: () => []
    },
    totalPrenancies: { type: Array, default: () => [] },
    delivered: { type: Array, default: () => [] },
    highRisks: { type: Array, default: () => [] },
    missedPrenatal: { type: Array, default: () => [] },
});
const activeTab = ref("maternal");

</script>
<template>

    <Head title="Reports" />
    <div class="h-full flex flex-col rounded-xl overflow-hidden bg-white">
        <div class="w-full border-b border-blue-700 p-4 space-x-2">
            <button @click="activeTab = 'maternal'" :class="activeTab === 'maternal'
                ? 'bg-blue-600 text-white'
                : 'bg-blue-200 text-blue-700'
                " class="px-4 py-2 rounded-full transition">
                Maternal Reports
            </button>
            <button @click="activeTab = 'immunization'" :class="activeTab === 'immunization'
                ? 'bg-blue-600 text-white'
                : 'bg-blue-200 text-blue-700'
                " class="px-4 py-2 rounded-full transition">
                Immunization Reports
            </button>
            <button @click="activeTab = 'growth'" :class="activeTab === 'growth'
                ? 'bg-blue-600 text-white'
                : 'bg-blue-200 text-blue-700'
                " class="px-4 py-2 rounded-full transition">
                Growth Reports
            </button>
        </div>



        <!-- COMPOENENTS -->
        <Maternal v-if="activeTab === 'maternal'" :maternals="maternals" />
        <Immunization v-if="activeTab === 'immunization'" :childs="childs"/>
        <Growth v-if="activeTab === 'growth'" :growths="growths"/>

    </div>
</template>
