<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import SuccessModal from "../SuccessModal.vue";

const props = defineProps({
    maternalNames: Array,
    schedule: Object, // If provided, we are in "update" mode
});

const emit = defineEmits(["closeAddSchedule"]);
const mode = props.schedule ? "update" : "add";

const today = new Date();
const todayString = today.toISOString().split("T")[0];

// Success modal states
const showSuccess = ref(false);
const successMessage = ref("");
const showScheduleSuccess = ref(false);
const scheduleSuccessMessage = ref("");

// If type is timbang/immunization → no "For" input
const showForInput = ref(true);

// Main form
const form = useForm({
    for: props.schedule?.for || "",
    date: props.schedule?.date || "",
    time: props.schedule?.time || "",
    type: props.schedule?.type || "timbang",
    recurrence_rule: props.schedule?.recurrence_rule || "",
});

// Separate form for marking as done
const statusForm = useForm({});

// Mark schedule as done
function markDone() {
    if (!props.schedule?.id) return;
    statusForm.put(route("done", props.schedule.id), {
        onSuccess: () => {
            scheduleSuccessMessage.value = "Schedule marked as done successfully!";
            showScheduleSuccess.value = true;
        },
    });
}

function closeModal() {
    emit("closeAddSchedule");
}

// Watch schedule type → auto set "for"
watch(
    () => form.type,
    (newVal) => {
        if (newVal === "timbang" || newVal === "immunization") {
            form.for = "all child";
            showForInput.value = false;
        } else {
            form.for = "";
            showForInput.value = true;
        }
    },
    { immediate: true }
);

// Save or update
function submit() {
    if (mode === "add") {
        form.post(route("schedule.store"), {
            onSuccess: () => {
                successMessage.value = "Schedule added successfully!";
                showSuccess.value = true;
                form.reset();
                form.for = "all child";
                form.type = "timbang";
            },
        });
    } else {
        if (!props.schedule?.id) return;
        form.put(route("schedule.update", props.schedule.id), {
            onSuccess: () => {
                successMessage.value = "Schedule updated successfully!";
                showSuccess.value = true;
            },
        });
    }
}

// Close modal after marking done
function finalizeScheduleUpdate() {
    showScheduleSuccess.value = false;
    location.reload();
}
</script>

<template>
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 px-4">
        <div class="bg-white rounded-2xl shadow-lg w-full max-w-lg p-6 relative">
            <h2 class="text-2xl font-semibold mb-5 text-gray-800 text-center">
                {{ mode === "add" ? "Add Schedule" : "Update Schedule" }}
            </h2>

            <form @submit.prevent="submit" class="flex flex-col gap-4">
                <!-- For -->
                <div v-if="showForInput" class="relative">
                    <label class="text-gray-700 font-medium mb-1">For</label>
                    <input type="text" v-model="form.for" autocomplete="off" :disabled="mode === 'update'"
                        class="shadow-xs border text-gray-900 text-sm rounded-lg block w-full p-2.5 bg-gray-50 disabled:cursor-not-allowed" />
                </div>

                <!-- Date & Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-gray-700 font-medium mb-1">Date</label>
                        <input v-model="form.date" type="date" :min="todayString"
                            class="border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" />
                        <p v-if="form.errors.date" class="text-red-500 text-sm mt-1">
                            {{ form.errors.date }}
                        </p>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-gray-700 font-medium mb-1">Time</label>
                        <input v-model="form.time" type="time"
                            class="border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" />
                        <p v-if="form.errors.time" class="text-red-500 text-sm mt-1">
                            {{ form.errors.time }}
                        </p>
                    </div>
                </div>

                <!-- Schedule Type & Recurrence -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-gray-700 font-medium mb-1">Schedule Type</label>
                        <select v-model="form.type" class="border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                            <option value="timbang">Timbang</option>
                            <option value="prenatal">Prenatal</option>
                            <option value="postnatal">Postnatal</option>
                            <option value="immunization">Immunization</option>
                        </select>
                        <p v-if="form.errors.type" class="text-red-500 text-sm mt-1">
                            {{ form.errors.type }}
                        </p>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-gray-700 font-medium mb-1">Recurrence Rule</label>
                        <input v-model="form.recurrence_rule" type="text" placeholder="Optional"
                            class="border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" />
                        <p v-if="form.errors.recurrence_rule" class="text-red-500 text-sm mt-1">
                            {{ form.errors.recurrence_rule }}
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" @click="closeModal"
                        class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 text-gray-800">
                        Cancel
                    </button>

                    <button v-if="props.schedule" @click="markDone" type="button"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg">
                        Done
                    </button>

                    <button type="submit" class="bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 text-white">
                        {{ mode === "add" ? "Save" : "Update" }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Success Modal -->
        <SuccessModal :show="showSuccess" :message="successMessage" @close="showSuccess = false; location.reload();" />
        <SuccessModal :show="showScheduleSuccess" :message="scheduleSuccessMessage" @close="finalizeScheduleUpdate" />
    </div>
</template>
