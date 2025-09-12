<script setup>
import { ref } from "vue";

const emit = defineEmits(["close"]);

const props = defineProps({
    schedules: {
        type: Array,
        default: () => []
    },
    date: String
});

const selected = ref([]); //  store selected IDs

function formatDateReadable(date) {
    if (!date) return "";
    const d = new Date(date);
    const options = { year: "numeric", month: "short", day: "numeric" };
    return d.toLocaleDateString("en-US", options);
}

function formatTimeAMPM(time) {
    if (!time) return "";
    const [hourStr, minuteStr] = time.split(":");
    let hour = parseInt(hourStr, 10);
    const minute = parseInt(minuteStr, 10);
    const ampm = hour >= 12 ? "PM" : "AM";
    hour = hour % 12 || 12;
    return `${hour}:${minute.toString().padStart(2, "0")} ${ampm}`;
}

function pillClass(type) {
    return ({
        immunization: "bg-green-300 text-green-900",
        prenatal: "bg-blue-300 text-blue-900",
        timbang: "bg-rose-300 text-rose-900",
        postnatal: "bg-yellow-300 text-yellow-900",
    }[type] || "bg-slate-300 text-slate-800");
}

// Log selected schedules
function logSelected() {
    const chosen = props.schedules
        .filter(s => selected.value.includes(s.id))
        .map(s => ({
            date: formatDateReadable(s.date),
            name: s.for
        }));

    chosen.forEach(item => {
        console.log(`Tomorrow is your schedule: ${item.name} on ${item.date}`);
    });
}

</script>

<template>
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div
            class="p-6 bg-white rounded-2xl shadow-2xl relative w-full max-w-[60%] min-h-[400px] max-h-[90vh] overflow-y-auto animate-fadeIn">
            <!-- Close button -->
            <button class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition text-xl font-bold"
                @click="emit('close')">
                ✖
            </button>

            <h1 class="text-black text-xl font-medium mb-4">
                Scheduled for: {{ formatDateReadable(date) }}
            </h1>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg border">
                <table class="w-full text-sm table-fixed border-collapse">
                    <thead class="bg-blue-600 text-white sticky top-0 z-10">
                        <tr>
                            <th class="p-3">
                                <!-- master checkbox -->
                                <input
                                    type="checkbox"
                                    @change="e => selected = e.target.checked ? props.schedules.map(s => s.id) : []"
                                    :checked="selected.length === props.schedules.length"
                                />
                            </th>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Time</th>
                            <th class="p-3 text-left">For</th>
                            <th class="p-3 text-left">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sched in props.schedules" :key="sched.id"
                            class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition h-[40px] border-b">
                            <td class="p-3 text-center">
                                <input type="checkbox" v-model="selected" :value="sched.id" />
                            </td>
                            <td class="p-3 truncate">
                                {{ formatDateReadable(sched.date) }}
                            </td>
                            <td class="p-3 truncate">
                                {{ formatTimeAMPM(sched.time)}}
                            </td>
                            <td class="p-3 truncate">
                                {{ sched.for }}
                            </td>
                            <td class="p-3">
                                <span
                                    class="text-xs font-medium px-2 py-1 rounded"
                                    :class="pillClass(sched.type)"
                                >
                                    {{ sched.type }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Log button -->
            <div class="mt-4 flex justify-end">
                <button
                    @click="logSelected"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                >
                    Log Selected
                </button>
            </div>
        </div>
    </div>
</template>
