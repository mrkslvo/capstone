<!-- DashboardOverview.vue -->
<script setup>
import { ref, computed, watch } from "vue";
import * as icons from "lucide-vue-next";
import viewAllSchedBasedOnDate from "../Components/AdminComponents/viewAllSchedBasedOnDate.vue";

import { usePage } from '@inertiajs/vue3'
const page = usePage()
const user = computed(() => page.props.auth.user)

const showAllSched = ref(false);
const allSchedBasedOnDate = ref({})


const props = defineProps({
    schedules: Array,
    totalPregnancies: Number,
    newMaternalRegistration: Number,
    totalChildren: Number,
    upcomingChildImmunization: Number,
});

const selectedDateSched = ref(null)

// 1️⃣ Function to get Tailwind background class by type
function getBgClassByType(type) {
    switch (type.toLowerCase()) {
        case "prenatal":
            return "bg-blue-400 text-white hover:bg-red-700";
        case "postnatal":
            return "bg-yellow-400 text-white hover:bg-red-700";
        case "immunization":
            return "bg-green-400 text-white hover:bg-green-500";
        case "timbang":
            return "bg-red-400 text-white hover:bg-red-500";
        default:
            return "bg-gray-400 text-white hover:bg-gray-400";
    }
}

// 2️⃣ Function to format date to YYYY-MM-DD
function formatDate(date) {
    return new Date(date).toISOString().split("T")[0];
}

// 3️⃣ Function to generate highlight object with Tailwind classes
function createHighlight(type) {
    return {
        fillMode: "solid", // keeps full background fill
        contentClass: getBgClassByType(type),
    };
}
function onDayClick(day) {
    showAllSched.value = true;

    if (day.date) {
        // Add +1 day
        const d = new Date(day.date);
        d.setDate(d.getDate() + 1);

        const clickedDate = formatDate(d); // use your existing formatDate function
        selectedDateSched.value = clickedDate;

        // Show table of schedules for that date
        const matches = props.schedules.filter(
            (sched) => formatDate(new Date(sched.date)) === selectedDateSched.value
        );
        allSchedBasedOnDate.value = matches;
    }
}


// 4️⃣ Computed attrs for v-calendar
const attrs = computed(() =>
    props.schedules.map((s) => ({
        key: s.id || s.date + "-" + s.type,
        dates: formatDate(s.date),
        highlight: createHighlight(s.type),
        customData: s,
        order: 1,
        popover: {
            label: `${s.type.charAt(0).toUpperCase() + s.type.slice(1).toLowerCase()
                } Scheduled for ${s.for}`,

            visibility: "hover",
            hideIndicator: true,
        },
    }))
);

// Menu items
const cards = ref([
    {
        name: "Total Pregnant Patients",
        icon: "HeartPulse",
        bg: "bg-green-300 text-green-900",
        value: props.totalPregnancies,
    },
    {
        name: "Total Children",
        icon: "Baby",
        bg: "bg-yellow-300 text-yellow-900",
        value: props.totalChildren,
    },
    {
        name: "New Maternal Registrations",
        icon: "HeartPulse",
        bg: "bg-indigo-300 text-indigo-900",
        value: props.newMaternalRegistration,
    },
    {
        name: "Upcoming Child Immunizations",
        icon: "Syringe",
        bg: "bg-rose-300 text-rose-900",
        value: props.upcomingChildImmunization,
    },
]);

/* Upcoming schedule table uses the same props.schedules */
const scheduleRows = computed(
    () => [...props.schedules].sort((a, b) => (a.date < b.date ? 1 : -1)) // newest first to mimic screenshot vibe
);

/* Label pill classes */
function pillClass(type) {
    return (
        {
            immunization: "bg-green-300 text-green-800",
            prenatal: "bg-indigo-300 text-indigo8700",
            postnatal: "bg-yellow-300 text-yellow-780",
            timbang: "bg-rose-300 text-rose-780",
        }[type] || "bg-slate-300 text-slate-800"
    );
}

/* Recent Activity placeholder (static to mirror screenshot) */
const activities = ref([
    { title: "Monthly Maternal Health Report generated.", sub: "2 hours ago" },
    {
        title: "Child Immunization Coverage Report updated.",
        sub: "5 hours ago",
    },
    { title: "Weekly Schedule Overview Report published.", sub: "Yesterday" },
]);

function formatTime(time) {
    if (!time) return "";
    const [hour, minute] = time.split(":").map(Number);
    const ampm = hour >= 12 ? "PM" : "AM";
    const hour12 = hour % 12 === 0 ? 12 : hour % 12;
    return `${hour12.toString().padStart(2, "0")}:${minute
        .toString()
        .padStart(2, "0")} ${ampm}`;
}


</script>

<template>

    <Head title="Dashboard" />
    <div class="flex flex-col h-full gap-4 overflow-hidden">
        <!-- Header -->
        <div
            class="flex justify-between items-center bg-white rounded-2xl shadow-md border border-slate-200 p-4 flex-shrink-0">
            <h1 class="text-2xl font-bold text-slate-900">
                Welcome, <span class="uppercase">{{ user.username }}</span>!
            </h1>
            <div class="flex items-center gap-3">

                <button class="p-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition"
                    aria-label="Messages">
                    <component :is="icons['Mail']" class="w-4 h-5 text-blue-700" />
                </button>
                <button class="p-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition"
                    aria-label="Notifications">
                    <component :is="icons['Bell']" class="w-4 h-5 text-blue-700" />
                </button>
            </div>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 flex-shrink-0">
            <div v-for="(card, index) in cards" :key="index"
                class="flex items-center gap-3 p-4 rounded-2xl shadow-md border " :class="card.bg">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                    <component :is="icons[card.icon]" class="w-6 h-6" />
                </div>
                <div>
                    <div class="text-xl font-bold ">
                        {{ card.value }}
                    </div>
                    <div class="text-md font-semibold">{{ card.name }}</div>
                </div>
            </div>
        </div>

        <!-- Middle Row: Calendar + Upcoming Schedules -->
        <div class="grid grid-cols-2 gap-4 overflow-hidden">
            <!-- VCalendar with multiple event listeners for different versions -->
            <div class="bg-white rounded-2xl shadow-md p-2">
                <VCalendar
                    :attributes="attrs"
                    expanded
                    :min-date="new Date()"
                    @dayclick="onDayClick"

                />
            </div>

            <!-- Upcoming Schedules -->
            <div
                class="bg-white rounded-2xl shadow-md border border-slate-200 p-4 flex-1 flex flex-col overflow-hidden">
                <h2 class="text-lg font-semibold text-slate-900 text-center mb-2 flex-shrink-0">
                    Upcoming Schedules
                </h2>
                <div class="overflow-x-auto rounded-lg border">
                    <table class="w-full text-sm table-fixed border-collapse">
                        <thead class="bg-blue-600 text-white sticky top-0 z-10">
                            <tr>
                                <th class="p-2 text-left">Date</th>
                                <th class="p-2 text-left">Time</th>
                                <th class="p-2 text-left">Day</th>
                                <th class="p-2 text-left">For</th>
                                <th class="p-2 text-left">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, idx) in scheduleRows.slice(0, 5)" :key="idx"
                                class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition">
                                <td class="p-2">{{ row.date }}</td>
                                <td class="p-2">{{ formatTime(row.time) }}</td>
                                <td class="p-2">
                                    {{
                                        new Date(row.date).toLocaleDateString(
                                            "en-US",
                                            { weekday: "short" }
                                        )
                                    }}
                                </td>
                                <td class="p-2">{{ row.for }}</td>
                                <td class="p-2">
                                    <span class="text-xs font-medium px-2 py-1 rounded" :class="pillClass(row.type)">
                                        {{ row.type }}
                                    </span>
                                </td>
                            </tr>
                            <tr v-if="scheduleRows.length === 0">
                                <td colspan="5" class="p-4 text-center text-gray-500 italic">
                                    No upcoming schedules
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-4 flex-shrink-0 overflow-hidden">
            <h2 class="text-lg font-semibold text-slate-900 mb-2">
                Recent Activity
            </h2>
            <div class="space-y-3 overflow-auto max-h-40">
                <div v-for="(a, i) in activities" :key="i" class="flex items-start gap-3">
                    <div class="mt-1 shrink-0 p-1 rounded border border-slate-300 flex items-center justify-center">
                        <component :is="icons['ClipboardMinus']" class="w-4 h-5 text-blue-700" />
                    </div>
                    <div>
                        <div class="text-sm text-slate-900">{{ a.title }}</div>
                        <div class="text-xs text-slate-600">{{ a.sub }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <viewAllSchedBasedOnDate v-if="showAllSched" :schedules="allSchedBasedOnDate"  @close="showAllSched = false" :date="selectedDateSched"/>
</template>
