<script setup>
import { ref, computed } from "vue";
import AddSchedule from '../Components/Schedule/AddSchedule.vue'
import viewAllSchedBasedOnDate from "../Components/AdminComponents/viewAllSchedBasedOnDate.vue";

const props = defineProps({
    schedules: Array,
    maternalNames: Array,
    childNames: Array,
});

const selectSchedule = ref(null); // null for "add"
const showAddSchedule = ref(false);

const showAllSched = ref(false);
const allSchedBasedOnDate = ref({})
const selectedDateSched = ref(null)
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


function openAddAndUpdateSchedule(schedule = null) {
    selectSchedule.value = schedule; // null = add, object = update
    showAddSchedule.value = true;
}

// 1️⃣ Function to get Tailwind background class by type
function getBgClassByType(type) {
    switch (type.toLowerCase()) {
        case "prenatal":
            return "bg-blue-700 text-white ";
        case "immunization":
            return "bg-green-500 text-white";
        case "timbang":
            return "bg-red-500 text-white";
        case "postnatal":
            return "bg-yellow-500 text-white";
        default:
            return "bg-gray-400 text-white";
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


// 4️⃣ Computed attrs for v-calendar
const attrs = computed(() =>
    props.schedules.map((s) => ({
        key: s.id || s.date + "-" + s.type,
        dates: formatDate(s.date),
        highlight: createHighlight(s.type),
        customData: s,
        rder: 0,
        popover: {
            label: `${
                s.type.charAt(0).toUpperCase() + s.type.slice(1).toLowerCase()
            } Scheduled for ${s.for}`,

            visibility: "hover",
            hideIndicator: true,
        },
    }))
);

function pillClass(type) {
    return ({
        immunization: "bg-green-300 text-green-900",
        prenatal: "bg-blue-300 text-blue-900",
        timbang: "bg-rose-300 text-rose-900",
        postnatal: "bg-yellow-300 text-yellow-900",
    }[type] || "bg-slate-300 text-slate-800");
}

function formatTime(time) {
    if (!time) return "";
    const [hour, minute] = time.split(":").map(Number);
    const ampm = hour >= 12 ? "PM" : "AM";
    const hour12 = hour % 12 === 0 ? 12 : hour % 12;
    return `${hour12.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')} ${ampm}`;
}

const scheduleRows = computed(() =>
    [...props.schedules].sort((a, b) => new Date(a.date) - new Date(b.date))
);
</script>

<template>
    <Head title="Schedule"/>

    <div class=" gap-6 h-full p-4 bg-white">
        <div class=" grid grid-cols-3 gap-4">
            <!-- Calendar -->
            <div class="bg-white rounded-2xl shadow-md border border-slate-200 ">
                <VCalendar
                    :attributes="attrs"
                    expanded
                    :min-date="new Date()"
                    @dayclick="onDayClick"
                    class="w-full"
                />
            </div>

            <!-- Upcoming Schedules -->
            <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-4 col-span-2 flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-900">Upcoming Schedules</h2>
                    <button
                        class="bg-blue-600 text-white px-4 py-1.5 rounded-lg shadow hover:bg-blue-700 transition"
                        @click="openAddAndUpdateSchedule()">
                        + Add Schedule
                    </button>
                </div>

                <div class="overflow-x-auto rounded-lg border">
                    <table class="w-full text-sm border-collapse">
                        <thead class="bg-blue-600 text-white sticky top-0 z-10">
                            <tr>
                                <th class="p-3 text-left">Date</th>
                                <th class="p-3 text-left">Time</th>
                                <th class="p-3 text-left">Day</th>
                                <th class="p-3 text-left">For</th>
                                <th class="p-3 text-left">Type</th>
                                <th class="p-3 text-left">Recurrence</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(row, idx) in scheduleRows.slice(0, 5)"
                                :key="idx"
                                @click="openAddAndUpdateSchedule(row)"
                                class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition h-[40px] border-y cursor-pointer"
                            >
                                <td class="p-3">{{ row.date }}</td>
                                <td class="p-3">{{ formatTime(row.time) }}</td>
                                <td class="p-3">
                                    {{ new Date(row.date).toLocaleDateString('en-US', { weekday: 'short' }) }}
                                </td>
                                <td class="p-3 font-medium text-slate-700">{{ row.for }}</td>
                                <td class="p-3">
                                    <span
                                        class="text-xs font-medium px-2 py-1 rounded"
                                        :class="pillClass(row.type)"
                                    >
                                        {{ row.type }}
                                    </span>
                                </td>
                                <td class="p-3">{{ row.recurrence_rule || '—' }}</td>
                            </tr>

                            <tr v-if="scheduleRows.length === 0">
                                <td colspan="6" class="p-4 text-center text-gray-500 italic">
                                    No upcoming schedules
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Add / Update Modal -->
        <AddSchedule
            v-if="showAddSchedule"
            :schedule="selectSchedule"
            :maternalNames="maternalNames"
            :childNames="childNames"
            @closeAddSchedule="showAddSchedule = false"
        />
    </div>
    <viewAllSchedBasedOnDate v-if="showAllSched" :schedules="allSchedBasedOnDate"  @close="showAllSched = false" :date="selectedDateSched"/>
</template>
