<script setup>
import { ref, inject, computed } from "vue";
import AddImmunizationRecord from "./AddImmunizationRecord.vue";
import ViewAllImmunizationRecord from "./ViewAllImmunizationRecord.vue";
import { Check } from "lucide-vue-next";
import TextInput from "../TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import SuccessModal from "../SuccessModal.vue";

// Local states
const showAddImmunizationRecord = ref(false);
const showAllImmunizationRecord = ref(false);

const showScheduleSuccess = ref(false);
const scheduleSuccessMessage = ref("");

// Modal openers
const openAddImmunizationRecord = () => (showAddImmunizationRecord.value = true);
const openAllImmunizationRecord = () => (showAllImmunizationRecord.value = true);

// Injected props
const selectedChildProfile = inject("selectedChildProfile");
if (!selectedChildProfile) {
  throw new Error("selectedChildProfile not provided!");
}

const injectedSchedules = inject("schedules", []);

// normalize to always be an array
const schedulesArr = computed(() => {
  if (Array.isArray(injectedSchedules)) return injectedSchedules;
  if (Array.isArray(injectedSchedules?.value)) return injectedSchedules.value;
  return [];
});

// helper: safely convert date string to Date
const toDate = (s) => (s?.date ? new Date(s.date) : new Date(0));

// latest pending immunization schedule
const myPreSched = computed(() => {
  const childName = selectedChildProfile?.value.child_name;
  if (!childName || schedulesArr.value.length === 0) {
    return false;
  }

  const filtered = schedulesArr.value.filter(
    (s) =>
      (s.for === "all child" || s.for === childName) &&
      s.status === "pending" &&
      s.type === "immunization"
  );

  if (!filtered.length) return false;

  return filtered.sort((a, b) => toDate(b) - toDate(a))[0];
});

// expose values
const schedDate = computed(() => myPreSched.value?.date || "None");
const schedTime = computed(() => myPreSched.value?.time || "None");

// --- Immunization Records ---
const immunizationRecords =
  selectedChildProfile.value?.immunization_record ?? [];

// collect all vaccine names
const vaccineName = immunizationRecords
  .map((record) => record.vaccine_name?.toLowerCase())
  .filter((r) => r); // removes null/empty

const vaccines = computed(() => [
  { key: "bcg", label: "Bcg", active: vaccineName.includes("bcg") },
  { key: "hepb", label: "HepB", active: vaccineName.includes("hepb") },
  { key: "penta", label: "Penta", active: vaccineName.includes("penta") },
  { key: "opv", label: "Opv", active: vaccineName.includes("opv") },
  { key: "ipv", label: "Ipv", active: vaccineName.includes("ipv") },
]);

// Determine next required vaccine
const vaccineLabel = computed(() => {
  for (const v of vaccines.value) {
    if (!v.active) {
      return v.label;
    }
  }
  return "None"; // all complete
});

// Get latest immunization record
const latestRecord = immunizationRecords.length
  ? immunizationRecords.reduce((latest, record) =>
      new Date(record.created_at) > new Date(latest.created_at)
        ? record
        : latest
    )
  : null;

const pastReaction = latestRecord?.reaction ?? "None";
const currentHealthStatus = latestRecord?.health_status ?? "Normal";

// --- Schedule Form (for adding new schedule) ---
const addSched = ref(true);
const schedForm = useForm({
  for: selectedChildProfile?.value.child_name,
  date: "",
  time: "",
  type: "immunization", // default immunization
  recurrence_rule: "",
});

// Save schedule
const saveSched = () => {
  schedForm.post(route("schedule.addImmunizationSched"), {
    onSuccess: () => {
      addSched.value = true;
      scheduleSuccessMessage.value = "Schedule added successfully!";
      showScheduleSuccess.value = true;
    },
  });
};

// Mark schedule as done
const done = () => {
  if (!myPreSched.value?.id) return;
  schedForm.put(route("done", myPreSched.value.id), {
    onSuccess: () => {
      scheduleSuccessMessage.value =
        "Schedule marked as done successfully!";
      showScheduleSuccess.value = true;
    },
  });
};

function finalizeSchedule() {
  showScheduleSuccess.value = false;
  location.reload();
}
</script>


<template>
    <div class="space-y-4">
        <!-- Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Left Section -->
            <div class="lg:col-span-2 bg-white border border-blue-700 rounded-lg p-6 shadow-md">
                <h3 class="text-lg font-bold text-blue-700 mb-3">
                    Immunization Details
                </h3>
                <div class="mb-4">
                    <p class="font-medium mb-1">Vaccination Name</p>
                    <div class="flex flex-wrap gap-4">
                        <div v-for="vaccine in vaccines" :key="vaccine.key"
                            class="flex items-center justify-center gap-1">
                            <span :class="vaccine.active ? 'bg-blue-600' : 'bg-gray-300'"
                                class="w-5 h-5 p-1 rounded flex items-center justify-center">
                                <Check v-if="vaccine.active" class="text-white" stroke-width="5" />
                            </span>
                            <span>{{ vaccine.label }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Past Vaccine Reactions</label>
                        <div disabled class="w-full border border-gray-300 rounded px-3 py-2">
                            {{ pastReaction }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Current Health Status</label>
                        <div disabled class="w-full border border-gray-300 rounded px-3 py-2">
                            {{ currentHealthStatus }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="bg-white border border-blue-700 rounded-lg p-6 shadow-md">
                <div class="flex justify-between items-center pb-3 mb-1 border-blue-700 border-b">
                    <h3 class="text-lg font-bold text-blue-700">
                        Recent Assessment
                    </h3>
                    <button @click="openAllImmunizationRecord" class="bg-blue-600 text-white text-sm px-3 py-1 rounded">
                        View All
                    </button>
                </div>

                <div class="space-y-3 text-sm" v-for="record in immunizationRecords.slice(0, 3)" :key="record.id">
                    <div class="border-blue-700 pb-0.5 border-b pt-2">
                        <p class="font-semibold">
                            {{ record.date_of_vaccination }}
                        </p>
                        <p>Immunization Visit</p>
                        <span>
                            <strong> Height: </strong>
                            {{ record.height }} (CM) -
                            <strong> Weight:</strong> {{ record.weight }} (KG)
                        </span>
                    </div>
                </div>

                <button @click="openAddImmunizationRecord" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">
                    + Add Immunization Record
                </button>
            </div>
        </div>

        <div class="grid grid-cols-2">
            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-lg p-6 shadow-md border-blue-700 border bg-white">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-blue-700">
                            Next Immunization Schedule
                        </h3>
                        <div v-if="!myPreSched">
                            <div v-if="addSched">
                                <button @click="addSched = false" class="bg-blue-600 text-white px-4 py-1 rounded">
                                    Add Schedule
                                </button>
                            </div>
                            <div v-else class="space-x-2">
                                <button @click="
                                    (addSched = true), schedForm.reset()
                                    " class="bg-red-600 text-white px-4 py-1 rounded">
                                    Cancel
                                </button>
                                <button @click="saveSched" class="bg-green-600 text-white px-4 py-1 rounded">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <!-- Date -->
                        <div>
                            <label class="block text-sm font-medium">Date</label>
                            <div v-if="addSched" class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">
                                {{ schedDate }}
                            </div>
                            <TextInput v-else type="date" name="date" v-model="schedForm.date"
                                :message="schedForm.errors.date" />
                        </div>

                        <!-- Time -->
                        <div>
                            <label class="block text-sm font-medium">Time</label>
                            <div v-if="addSched" class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">
                                {{ schedTime }}
                            </div>
                            <TextInput v-else type="time" name="time" v-model="schedForm.time"
                                :message="schedForm.errors.time" />
                        </div>

                        <!-- Done Button -->
                        <form v-if="myPreSched" @submit.prevent="done" class="flex items-center justify-end col-span-2">
                            <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded">
                                Done
                            </button>
                        </form>
                    </div>
                </div>
                <div class="rounded-lg p-6 shadow-md border-blue-700 border bg-white">
                    <h3 class="text-lg font-bold text-blue-700 mb-4">
                        Next Vaccine Type
                    </h3>
                    <div class="grid grid-cols-1">
                        <div>
                            <label class="block text-sm font-medium">Type</label>
                            <p class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">
                                {{ vaccineLabel }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Complete Button -->
            <div class="flex items-center justify-end">
                <button class="bg-green-600 text-white px-6 py-2 rounded">
                    Complete
                </button>
            </div>
        </div>
    </div>

    <AddImmunizationRecord v-if="showAddImmunizationRecord"
        @closeAddImmunizationRecord="showAddImmunizationRecord = false" />
    <ViewAllImmunizationRecord v-if="showAllImmunizationRecord"
        @closeAllImmunizationRecord="showAllImmunizationRecord = false" />
    <SuccessModal :show="showScheduleSuccess" :message="scheduleSuccessMessage" @close="finalizeScheduleUpdate" />
    <SuccessModal :show="showScheduleSuccess" :message="scheduleSuccessMessage" @close="finalizeScheduleAdd" />
</template>
