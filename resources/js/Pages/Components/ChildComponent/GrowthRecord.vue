<script setup>
import { ref, computed, onMounted, inject } from "vue";
import Chart from "chart.js/auto";
import AddGrowthRecord from './AddGrowthRecord.vue'
import ViewAllGrowthRecord from "./ViewAllGrowthRecord.vue";


// Local states
const showAddGrowthRecord = ref(false);
const showAllGrowthRecord = ref(false);

const openAddGrowthRecord = () => {
    showAddGrowthRecord.value = true;
};
const openAllGrowthRecord = () => {
    showAllGrowthRecord.value = true;
};

// ✅ Inject child profile
const selectedChildProfile = inject("selectedChildProfile");
if (!selectedChildProfile) {
    throw new Error("selectedChildProfile not provided!");
}


// ✅ All dates (labels for chart)
const dates = computed(() =>
    (selectedChildProfile.value.growth_record || []).map(
        (r) => r.date
    )
);

// ✅ All weights
const weights = computed(() =>
    (selectedChildProfile.value.growth_record || []).map((r) =>
        parseFloat(r.weight)
    )
);

// ✅ All heights
const heights = computed(() =>
    (selectedChildProfile.value.growth_record || []).map((r) =>
        parseFloat(r.height)
    )
);

// ✅ All BMI values
const bmis = computed(() =>
    (selectedChildProfile.value.growth_record || []).map((r) => {
        const w = parseFloat(r.weight);
        const h = parseFloat(r.height) / 100; // convert cm to m
        return h > 0 ? (w / (h * h)).toFixed(1) : null;
    })
);

// ✅ All records (for right panel display)
const records = computed(() =>
    (selectedChildProfile.value.growth_record || []).map((r) => ({
        date: r.date,
        weight: parseFloat(r.weight),
        height: parseFloat(r.height),
    }))
);

// --- Chart State ---
const chartType = ref("weight");

const tabClass = (type) =>
    chartType.value === type
        ? "px-4 py-2 rounded bg-blue-600 text-white"
        : "px-4 py-2 rounded bg-blue-300 hover:bg-blue-500 hover:text-white";

const setChartType = (type) => {
    chartType.value = type;
    renderChart();
};

// --- Format Date -> Month ---
const monthNames = [
    "Jan", "Feb", "Mar", "Apr", "May", "Jun",
    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
];
const formatToMonth = (dateStr) => {
    const d = new Date(dateStr);
    return monthNames[d.getMonth()];
};

// --- Computed dataset for chart ---
const chartData = computed(() => {
    const labels = dates.value.map((d) => formatToMonth(d)); // ✅ fix to months
    let data = [];
    let label = "";

    switch (chartType.value) {
        case "weight":
            label = "Weight (kg)";
            data = weights.value;
            break;
        case "height":
            label = "Height (cm)";
            data = heights.value;
            break;
        case "bmi":
            label = "BMI";
            data = bmis.value;
            break;
    }
    return { labels, data, label };
});

let chartInstance = null;
const renderChart = () => {
    const ctx = document.getElementById("growthChart").getContext("2d");

    if (chartInstance) chartInstance.destroy();

    // ✅ Gradient background fill
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, "rgba(37, 99, 235, 0.4)");   // top - blue
    gradient.addColorStop(1, "rgba(37, 99, 235, 0.05)");  // bottom - fade

    chartInstance = new Chart(ctx, {
        type: "line",
        data: {
            labels: chartData.value.labels,
            datasets: [
                {
                    label: chartData.value.label,
                    data: chartData.value.data,
                    borderColor: "#2563eb", // solid blue
                    backgroundColor: gradient, // gradient fill
                    fill: true, // ✅ area fill
                    tension: 0.4, // ✅ smoother curve
                    pointBackgroundColor: "#2563eb",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#1d4ed8",
                    pointHoverBorderColor: "#fff",
                    pointRadius: 5,
                    pointHoverRadius: 7,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: "#1e3a8a", // dark blue labels
                        font: { size: 14, weight: "bold" },
                    },
                },
                tooltip: {
                    backgroundColor: "#1e40af",
                    titleColor: "#fff",
                    bodyColor: "#fff",
                    padding: 10,
                    cornerRadius: 8,
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: "Month",
                        color: "#1e3a8a",
                        font: { size: 14, weight: "bold" },
                    },
                    grid: { color: "rgba(0,0,0,0.05)" },
                    ticks: { color: "#374151" }, // gray
                },
                y: {
                    title: {
                        display: true,
                        text: chartData.value.label,
                        color: "#1e3a8a",
                        font: { size: 14, weight: "bold" },
                    },
                    grid: { color: "rgba(0,0,0,0.05)" },
                    ticks: { color: "#374151" },
                },
            },
        },
    });
};

onMounted(() => renderChart());
</script>
<template>
    <div class="p-2">
        <div class="grid grid-cols-5 gap-3 auto-rows-fr">
            <!-- Left Panel -->
            <div class="col-span-3 flex flex-col bg-white border border-blue-700 rounded-lg shadow-md p-4 h-full">
                <!-- Chart Tabs -->
                <div class="flex gap-2 mb-3 font-semibold">
                    <button @click="setChartType('weight')" :class="tabClass('weight')" class="smooth">Weight</button>
                    <button @click="setChartType('height')" :class="tabClass('height')" class="smooth">Height</button>
                    <button @click="setChartType('bmi')" :class="tabClass('bmi')" class="smooth">BMI</button>
                </div>

                <!-- Chart -->
                <div class="flex-1 bg-gray-100 p-4 rounded-lg">
                    <canvas id="growthChart" class="h-full w-full"></canvas>
                </div>
            </div>

            <!-- Right Panel: Records -->
            <div class="bg-white border border-blue-700 rounded-lg p-6 shadow-md col-span-2 flex flex-col h-full">
                <div class="flex justify-between items-center pb-4 mb-4 border-blue-700 border-b">
                    <h3 class="text-lg font-bold text-blue-700">Recent Assessment</h3>
                    <button @click="openAllGrowthRecord" class="bg-blue-600 text-white text-sm px-3 py-1 rounded">
                        View All
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto space-y-3">
                    <div v-for="record in records" :key="record.date"
                        class="flex items-start space-x-3 border-b pb-2 border-blue-700">
                        <div class="bg-blue-200 p-2 rounded-md">
                            <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 4H2v16h20V6H12l-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-sm">{{ record.date }}</p>
                            <p class="text-gray-600 text-sm">
                                Weight: {{ record.weight }} kg,
                                Height: {{ record.height }} cm,
                                BMI: {{ (record.weight / Math.pow(record.height / 100, 2)).toFixed(1) }}
                            </p>
                        </div>
                    </div>
                </div>

                <button @click="openAddGrowthRecord" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">
                    + Add Growth Record
                </button>
            </div>
        </div>
    </div>

    <AddGrowthRecord v-if="showAddGrowthRecord" @closeAddGrowthRecord="showAddGrowthRecord = false" />
    <ViewAllGrowthRecord v-if="showAllGrowthRecord" @closeAllGrowthRecord="showAllGrowthRecord = false" />
</template>
