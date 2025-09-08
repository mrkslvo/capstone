<script setup>
/* ----------------- Imports ----------------- */
import { ref, inject, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import AddPrenatalRecord from "./AddPrenatalRecord.vue";
import ViewAllPrenatalRecord from "./ViewAllPrenatalRecord.vue";
import ConfirmationModal from "../ConfirmationModal.vue";
import SuccessModal from "../SuccessModal.vue";
import TextInput from "../TextInput.vue";
import SelectInput from "../SelectInput.vue";


/* ----------------- Props / Emits ----------------- */
const emit = defineEmits(["openPostnatal"]);

/* ----------------- Modal States ----------------- */
const showSuccess = ref(false);
const successMessage = ref("");

const showConfirmation = ref(false);
const confirmMessage = ref("");

const showAddPrenatalRecord = ref(false);
const showAllPrenatalRecords = ref(false);

const showAddRecordConfirmation = ref(false);
const showAddRecordSuccess = ref(false);

const showScheduleSuccess = ref(false);
const scheduleSuccessMessage = ref("");

const showMedicalSuccess = ref(false);
const medicalSuccessMessage = ref("");

/* ----------------- Injected Data ----------------- */
const selectedMaternalProfile = inject("selectedMaternalProfile");
const injectedSchedules = inject("schedules", []); // could be a ref OR a plain array

// normalize to always be a plain array (inside a computed)
const schedulesArr = computed(() => {
  if (Array.isArray(injectedSchedules)) return injectedSchedules;
  if (Array.isArray(injectedSchedules?.value)) return injectedSchedules.value;
  return [];
});

// helper: safely convert date string to Date
const toDate = (s) => (s?.date ? new Date(s.date) : new Date(0));

// latest pending prenatal schedule for this profile
const myPreSched = computed(() => {
  const name = selectedMaternalProfile?.value?.name;
  if (!name || schedulesArr.value.length === 0) return false;

  const filtered = schedulesArr.value.filter(
    (s) =>
      s.for === name &&
      String(s.status ?? "").toLowerCase() === "pending" &&
      String(s.type ?? "").toLowerCase() === "prenatal"
  );

  if (filtered.length === 0) return false;

  // sort descending by date, return dine
  return filtered.sort((a, b) => toDate(b) - toDate(a))[0];
});

const schedDate = myPreSched.value.date || 'None'
const schedTime = myPreSched.value.time || 'None'



/* ----------------- Reactive State ----------------- */
const form = useForm({});
const doneForm = useForm({});
const edit = ref(true);
const addSched = ref(true);

const record = selectedMaternalProfile.value.maternal_records?.find(
    (r) => r.isPresent === "yes"
);



const medicalForm = useForm({
    lmp: record?.lmp ?? "",
    ecd: record?.ecd ?? "",
    ob_score_g: record?.ob_score_g ?? "",
    ob_score_a: record?.ob_score_a ?? "",
    ob_score_t: record?.ob_score_t ?? "",
    ob_score_l: record?.ob_score_l ?? "",
    ob_score_p: record?.ob_score_p ?? "",
    allergies: record?.allergies ?? "",
    tt_status: record?.tt_status ?? "",
    assessment: record?.assessment ?? "",
    treatment: record?.treatment ?? "",
    status: record?.status ?? "",
    past_deliveries: record?.past_deliveries ?? "",
    high_risk: record?.high_risk ?? "",
});

const schedForm = useForm({
    for: selectedMaternalProfile?.value.name,
    date: "",
    time: "",
});


const prenatalRecords = computed(() => record?.prenatal_records ?? []);

const statusOptions = [
    { value: "tt1", label: "Status 1" },
    { value: "tt2", label: "Status 2" },
    { value: "tt3", label: "Status 3" },
    { value: "tt4", label: "Status 4" },
    { value: "tt5", label: "Status 5" },
];

/* ----------------- Functions ----------------- */

// Open modals
const openAddPrenatalRecordModal = () => (showAddPrenatalRecord.value = true);

// Medical form
function saveMedical() {
    if (!record.id) return;

    medicalForm.put(route("maternalRecord.updateRecord", record.id), {
        onSuccess: () => {
            edit.value = true;
            medicalSuccessMessage.value = "Medical record updated successfully!";
            showMedicalSuccess.value = true;
        },
    });
}


function resetMedical() {
    medicalForm.reset({
        lmp: record?.lmp ?? "",
        ecd: record?.ecd ?? "",
        ob_score_g: record?.ob_score_g ?? "",
        ob_score_a: record?.ob_score_a ?? "",
        ob_score_t: record?.ob_score_t ?? "",
        ob_score_l: record?.ob_score_l ?? "",
        ob_score_p: record?.ob_score_p ?? "",
        allergies: record?.allergies ?? "",
        tt_status: record?.tt_status ?? "",
        assessment: record?.assessment ?? "",
        treatment: record?.treatment ?? "",
        status: record?.status ?? "",
        past_deliveries: record?.past_deliveries ?? "",
        high_risk: record?.high_risk ?? "",
    });
    edit.value = true;
}

// Schedule
function saveSched() {
    schedForm.post(route("schedule.addSched"), {
        onSuccess: () => {
            addSched.value = true;
            scheduleSuccessMessage.value = "Schedule added successfully!";
            showScheduleSuccess.value = true;
        },
    });
}

function done() {
    const scheduleId = myPreSched.value.id;
    doneForm.put(route("done", scheduleId), {
        onSuccess: () => {
            scheduleSuccessMessage.value = "Schedule marked as done successfully!";
            showScheduleSuccess.value = true;
        },
    });
}

function finalizeScheduleUpdate() {
    showScheduleSuccess.value = false;
    location.reload();
}

function finalizeScheduleAdd() {
    showScheduleSuccess.value = false;
    location.reload();
}

// Complete maternal record
function handleUpdateMaternalRecord() {
    confirmMessage.value = "Are you sure the prenatal is complete?";
    showConfirmation.value = true;
}

function confirmUpdate() {
    showConfirmation.value = false;
    successMessage.value = "Record updated successfully!";
    showSuccess.value = true;
}

function finalizeUpdate() {
    showSuccess.value = false;
    form.put(route("maternalRecord.update", record), {}, { onSuccess: () => location.reload() });
}

// Add new record
function handleAddNewRecord() {
    showAddRecordConfirmation.value = true;
}

function confirmAddNewRecord() {
    showAddRecordConfirmation.value = false;
    successMessage.value = "New maternal record added successfully!";
    showAddRecordSuccess.value = true;
}

function finalizeAddNewRecord() {
    showAddRecordSuccess.value = false;
    form.post(route("maternalRecord.addRecord", selectedMaternalProfile.value), {}, { onSuccess: () => location.reload() });
}

</script>

<template>
    <div class="space-y-4">

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            <!-- Left Section: Medical & Pregnancy Details -->
            <div class="lg:col-span-2 bg-white border border-blue-700 rounded-lg p-6 shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-bold text-blue-700">Medical & Pregnancy Details</h3>
                    <div v-if="record && record.isCompleted === 'ongoing'">
                        <div v-if="edit" class="flex items-center justify-center">
                            <button @click="edit = false" class="bg-blue-600 text-white px-4 py-1 rounded">Edit</button>
                        </div>
                        <div v-else class="space-x-2">
                            <button @click="(edit = true), medicalForm.reset()"
                                class="bg-red-600 text-white px-4 py-1 rounded">Cancel</button>
                            <button @click="saveMedical" class="bg-green-600 text-white px-4 py-1 rounded">Save</button>
                        </div>
                    </div>
                </div>

                <!-- LMP & ECD -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">LMP</label>
                        <div v-if="edit" class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">{{
                            record?.lmp ?? "N/A" }}</div>
                        <TextInput v-else type="date" name="lmp" v-model="medicalForm.lmp"
                            :message="medicalForm.errors.lmp" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">ECD</label>
                        <div v-if="edit" class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">{{
                            record?.ecd ?? "N/A" }}</div>
                        <TextInput v-else type="date" name="ecd" v-model="medicalForm.ecd"
                            :message="medicalForm.errors.ecd" />
                    </div>
                </div>

                <!-- OB Score & TT Status -->
                <div class="mt-4 grid grid-cols-2 gap-6">
                    <!-- OB Score -->
                    <div>
                        <label class="block text-sm font-medium mb-2">OB Score</label>
                        <div class="grid grid-cols-5 gap-3">

                            <!-- G -->
                            <div class="flex flex-col items-start">
                                <label class="font-semibold">G</label>
                                <p v-if="edit"
                                    class="text-gray-700 border border-blue-500 rounded px-2 py-1 w-12 text-center">
                                    {{ record?.ob_score_g ?? 'N/A' }}
                                </p>
                                <TextInput v-else name="ob_score_g" v-model="medicalForm.ob_score_g"
                                    class="w-12 text-center" />
                            </div>

                            <!-- T -->
                            <div class="flex flex-col items-start">
                                <label class="font-semibold">T</label>
                                <p v-if="edit"
                                    class="text-gray-700 border border-blue-500 rounded px-2 py-1 w-12 text-center">
                                    {{ record?.ob_score_t ?? 'N/A' }}
                                </p>
                                <TextInput v-else name="ob_score_t" v-model="medicalForm.ob_score_t"
                                    class="w-12 text-center" />
                            </div>

                            <!-- P -->
                            <div class="flex flex-col items-start">
                                <label class="font-semibold">P</label>
                                <p v-if="edit"
                                    class="text-gray-700 border border-blue-500 rounded px-2 py-1 w-12 text-center">
                                    {{ record?.ob_score_p ?? 'N/A' }}
                                </p>
                                <TextInput v-else name="ob_score_p" v-model="medicalForm.ob_score_p"
                                    class="w-12 text-center" />
                            </div>

                            <!-- L -->
                            <div class="flex flex-col items-start">
                                <label class="font-semibold">L</label>
                                <p v-if="edit"
                                    class="text-gray-700 border border-blue-500 rounded px-2 py-1 w-12 text-center">
                                    {{ record?.ob_score_l ?? 'N/A' }}
                                </p>
                                <TextInput v-else name="ob_score_l" v-model="medicalForm.ob_score_l"
                                    class="w-12 text-center" />
                            </div>

                            <!-- A -->
                            <div class="flex flex-col items-start">
                                <label class="font-semibold">A</label>
                                <p v-if="edit"
                                    class="text-gray-700 border border-blue-500 rounded px-2 py-1 w-12 text-center">
                                    {{ record?.ob_score_a ?? 'N/A' }}
                                </p>
                                <TextInput v-else name="ob_score_a" v-model="medicalForm.ob_score_a"
                                    class="w-12 text-center" />
                            </div>

                        </div>
                    </div>


                    <!-- TT Status -->
                    <div>
                        <label class="block text-sm font-medium mb-2">TT/Td Status</label>
                        <p v-if="edit" class="text-gray-700 border border-blue-500 rounded px-2 py-1">{{
                            record?.tt_status ?? "N/A" }}</p>
                        <SelectInput v-else v-model="medicalForm.tt_status" name="tt_status" :options="statusOptions"
                            :message="medicalForm.errors.tt_status" />
                    </div>
                </div>

                <!-- Past Deliveries & High Risk -->
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Past Deliveries</label>
                        <p class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">{{
                            record?.past_deliveries ?? "N/A" }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">High-Risk Pregnancy</label>
                        <p class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">{{ record?.high_risk ??
                            "N/A" }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Section: Recent Assessment -->
            <div class="bg-white border border-blue-700 rounded-lg p-6 shadow-md">
                <div class="flex justify-between items-center pb-3 mb-1 border-blue-700 border-b">
                    <h3 class="text-lg font-bold text-blue-700">Recent Assessment</h3>
                    <button @click="showAllPrenatalRecords = true"
                        class="bg-blue-600 text-white text-sm px-3 py-1 rounded">View All</button>
                </div>

                <div class="space-y-3 text-sm" v-for="prenatal in prenatalRecords.slice(0, 3)" :key="prenatal.id">
                    <div class="border-blue-700 pb-0.5 border-b pt-2">
                        <p class="font-semibold">{{ prenatal.date }}</p>
                        <p>Prenatal Visit</p>
                        <span>BP: {{ prenatal.blood_pressure }} - Weight: {{ prenatal.weight }} kg</span>
                    </div>
                </div>

                <div v-if="record">
                    <button v-if="record.isCompleted === 'ongoing'" @click="openAddPrenatalRecordModal"
                        class="bg-blue-600 text-white px-4 py-2 rounded mt-4">+ Add Prenatal Record</button>
                    <div v-else-if="record.isCompleted === 'prenatal completed'"
                        class="bg-green-600 text-white px-4 py-2 rounded mt-4">Prenatal Completed!</div>
                </div>
            </div>
        </div>
        <!-- ----------------- Bottom Section ----------------- -->
        <div class="flex items-center" :class="record?.isCompleted === 'ongoing' ? 'justify-between' : 'justify-end'">

            <!-- Next Prenatal Schedule -->
            <div v-if="record?.isCompleted === 'ongoing'"
                class="rounded-lg p-6 w-1/3 shadow-md border-blue-700 border bg-white">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-blue-700">Next Prenatal Schedule</h3>
                    <div v-if="!myPreSched">
                        <div v-if="addSched">
                            <button @click="addSched = false" class="bg-blue-600 text-white px-4 py-1 rounded">Add
                                Schedule</button>
                        </div>
                        <div v-else class="space-x-2">
                            <button @click="(addSched = true), schedForm.reset()"
                                class="bg-red-600 text-white px-4 py-1 rounded">Cancel</button>
                            <button @click="saveSched" class="bg-green-600 text-white px-4 py-1 rounded">Save</button>
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
                    <form v-if="myPreSched" @submit.prevent="done"
                        class="flex items-center justify-end col-span-2">
                        <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded">Done</button>
                    </form>
                </div>
            </div>

            <!-- Complete Button -->
            <div v-if="record?.isCompleted === 'ongoing'" class="flex justify-end">
                <button class="bg-green-600 text-white px-6 py-2 rounded" @click="handleUpdateMaternalRecord">
                    Complete
                </button>
            </div>

            <!-- Postnatal Button -->
            <div v-if="record?.isCompleted === 'prenatal completed'" class="flex justify-end">
                <button @click="emit('openPostnatal')" class="bg-blue-600 text-white px-6 py-2 rounded">
                    Postnatal Records
                </button>
            </div>
        </div>

        <!-- ----------------- No Present Record Section ----------------- -->
        <div v-if="!record"
            class="flex flex-col items-center justify-center gap-4 p-6 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 text-center">
            <span class="text-gray-600 text-lg font-medium">No Present Maternal Record</span>
            <button @click="handleAddNewRecord"
                class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-green-700 focus:ring-2 focus:ring-green-400 transition duration-200">
                Add New Record
            </button>
        </div>
    </div>

    <!-- ----------------- Modals ----------------- -->
    <ConfirmationModal :show="showConfirmation" :name="selectedMaternalProfile.value?.name ?? ''"
        title="Prenatal Complete" :message="confirmMessage" @cancel="showConfirmation = false"
        @confirm="confirmUpdate" />
    <AddPrenatalRecord v-if="showAddPrenatalRecord" :maternalRecordId="record?.id"
        :maternalName="selectedMaternalProfile.value?.name" @close="showAddPrenatalRecord = false" />
    <ViewAllPrenatalRecord v-if="showAllPrenatalRecords" :patientName="selectedMaternalProfile.value?.name" :perPage="5"
        @closePrenatalRecords="showAllPrenatalRecords = false" />
    <SuccessModal :show="showSuccess" :message="successMessage" @close="finalizeUpdate" />
    <ConfirmationModal :show="showAddRecordConfirmation" :name="selectedMaternalProfile.value?.name ?? ''"
        title="Add New Maternal Record" message="Are you sure you want to add a new maternal record?"
        @cancel="showAddRecordConfirmation = false" @confirm="confirmAddNewRecord" />
    <SuccessModal :show="showAddRecordSuccess" :message="successMessage" @close="finalizeAddNewRecord" />
    <SuccessModal :show="showScheduleSuccess" :message="scheduleSuccessMessage" @close="finalizeScheduleUpdate" />
    <SuccessModal :show="showScheduleSuccess" :message="scheduleSuccessMessage" @close="finalizeScheduleAdd" />
    <SuccessModal :show="showMedicalSuccess" :message="medicalSuccessMessage" @close="showMedicalSuccess = false" />

</template>
