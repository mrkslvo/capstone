<script setup>
/* ----------------- Imports ----------------- */
import { ref, inject, computed, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import AddPostnatalRecord from "./AddPostnatalRecord.vue";
import ViewAllPostnataLRecord from "./ViewAllPostnataLRecord.vue";
import ConfirmationModal from "../ConfirmationModal.vue";
import SuccessModal from "../SuccessModal.vue";
import TextInput from "../TextInput.vue";

/* ----------------- Emits ----------------- */
const emit = defineEmits(["openPrenatal"]);

/* ----------------- States ----------------- */
const showAddPostnatalRecord = ref(false);
const showAllPostnatalRecord = ref(false);

const showConfirmation = ref(false);
const confirmMessage = ref("");
let confirmAction = null;

const showSuccess = ref(false);
const successMessage = ref("");

const showScheduleSuccess = ref(false);
const scheduleSuccessMessage = ref("");

const edit = ref(true);
const addSched = ref(true);

/* ----------------- Injected Data ----------------- */
const selectedMaternalProfile = inject("selectedMaternalProfile");
if (!selectedMaternalProfile) throw new Error("selectedMaternalProfile not provided!");
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
      String(s.type ?? "").toLowerCase() === "postnatal"
  );

  if (filtered.length === 0) return false;

  // sort descending by date, return latest
  return filtered.sort((a, b) => toDate(b) - toDate(a))[0];
});
const schedDate = myPreSched.value.date || 'None'
const schedTime = myPreSched.value.time || 'None'


/* ----------------- Active Maternal Record ----------------- */
const record = computed(() =>
    selectedMaternalProfile.value?.maternal_records?.find(r => r.isPresent === "yes")
);

/* ----------------- Forms ----------------- */
const deliveryForm = useForm({
    place: record.value?.delivery?.place ?? "",
    birth_attendant: record.value?.delivery?.birth_attendant ?? "",
    date: record.value?.delivery?.date ?? "",
    type: record.value?.delivery?.type ?? "",
    complication: record.value?.delivery?.complication ?? "",
    remarks: record.value?.delivery?.remarks ?? "",
});


// Schedule form
const schedForm = useForm({
    for: selectedMaternalProfile?.value.name,
    date: "",
    time: "",
});

/* ----------------- Computed ----------------- */
const schedules = computed(() => selectedMaternalProfile.value?.schedules ?? []);
const pendingSchedules = computed(() =>
    schedules.value.filter((s) => s.status === "pending" && s.type === "postnatal")
);

const postnatalRecords = computed(() => record.value?.postnatal_records ?? []);
const latestDelivery = computed(() => record.value?.delivery ?? {});

/* ----------------- Watchers ----------------- */
// Make sure maternal_profile_id is reactive
watch(record, (newRecord) => {
    schedForm.maternal_profile_id = newRecord?.id ?? null;
});

/* ----------------- Functions ----------------- */

// Delivery
function saveDelivery() {
    confirmMessage.value = "Do you want to save the delivery details?";
    confirmAction = "saveDelivery";
    showConfirmation.value = true;
}

function resetDelivery() {
    deliveryForm.reset({
        place: latestDelivery.value?.place ?? "",
        birth_attendant: latestDelivery.value?.birth_attendant ?? "",
        date: latestDelivery.value?.date ?? "",
        type: latestDelivery.value?.type ?? "",
        complication: latestDelivery.value?.complication ?? "",
        remarks: latestDelivery.value?.remarks ?? "",
    });
    edit.value = true;
}

// Postnatal Record
function openAddPostnatalRecord() {
    showAddPostnatalRecord.value = true;
}

// Complete Maternal Record
function handleUpdateMaternalRecord() {
    confirmMessage.value = "Are you sure the postnatal is complete?";
    confirmAction = "completeRecord";
    showConfirmation.value = true;
}

// Schedule
function saveSched() {
    if (!schedForm.date || !schedForm.time) return;
    schedForm.post(route("schedule.addPostSched"), {
        onSuccess: () => {
            addSched.value = true;
            scheduleSuccessMessage.value = "Schedule added successfully!";
            showScheduleSuccess.value = true;
        },
    });
}

function done() {
    const scheduleId = myPreSched.value.id;
    schedForm.put(route("done", scheduleId), {
        onSuccess: () => {
            scheduleSuccessMessage.value = "Schedule marked as done successfully!";
            showScheduleSuccess.value = true;
        },
    });
}

// Confirmation modal
function confirmUpdate() {
    showConfirmation.value = false;

    if (confirmAction === "saveDelivery") {
        deliveryForm.put(route("delivery.update", latestDelivery.value), {
            onSuccess: () => {
                successMessage.value = "Delivery details saved successfully!";
                showSuccess.value = true;
                edit.value = true;
            },
        });
    } else if (confirmAction === "completeRecord") {
        successMessage.value = "Record updated successfully!";
        showSuccess.value = true;
    }
}

// Success modal handlers
function finalizeUpdate() {
    showSuccess.value = false;
    if (confirmAction === "completeRecord") {
        useForm().put(route("maternalRecordPresent.update", record.value.id), {}, {
            onSuccess: () => location.reload(),
        });
    }
}

function finalizeScheduleAdd() {
    showScheduleSuccess.value = false;
    location.reload();
}
</script>

<template>
    <div class="space-y-4">
        <!-- Delivery Details -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white border border-blue-700 rounded-lg p-6 shadow-md col-span-2">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-bold text-blue-700">Delivery Details</h3>
                    <div v-if="record">
                        <button v-if="edit" @click="edit = false"
                            class="bg-blue-600 text-white px-4 py-1 rounded">Edit</button>
                        <div v-else class="space-x-2">
                            <button @click="resetDelivery"
                                class="bg-red-600 text-white px-4 py-1 rounded">Cancel</button>
                            <button @click="saveDelivery"
                                class="bg-green-600 text-white px-4 py-1 rounded">Save</button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Place</label>
                        <div v-if="edit" class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">{{
                            latestDelivery.place ?? "N/A" }}</div>
                        <TextInput v-else name="place" v-model="deliveryForm.place"
                            :message="deliveryForm.errors.place" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Birth Attendant</label>
                        <div v-if="edit" class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">{{
                            latestDelivery.birth_attendant ?? "N/A" }}</div>
                        <TextInput v-else name="birth_attendant" v-model="deliveryForm.birth_attendant"
                            :message="deliveryForm.errors.birth_attendant" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Delivery Date</label>
                        <div v-if="edit" class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">{{
                            latestDelivery.date ?? "N/A" }}</div>
                        <TextInput v-else type="date" name="date" v-model="deliveryForm.date"
                            :message="deliveryForm.errors.date" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Delivery Type</label>
                        <div v-if="edit" class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">{{
                            latestDelivery.type ?? "N/A" }}</div>
                        <TextInput v-else name="type" v-model="deliveryForm.type" :message="deliveryForm.errors.type" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Complication</label>
                        <div v-if="edit" class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">{{
                            latestDelivery.complication ?? "N/A" }}</div>
                        <TextInput v-else name="complication" v-model="deliveryForm.complication"
                            :message="deliveryForm.errors.complication" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Remarks</label>
                        <div v-if="edit" class="text-gray-700 border-blue-500 mt-1 border rounded px-2 py-1">{{
                            latestDelivery.remarks ?? "N/A" }}</div>
                        <TextInput v-else name="remarks" v-model="deliveryForm.remarks"
                            :message="deliveryForm.errors.remarks" />
                    </div>
                </div>
            </div>

            <!-- Recent Postnatal Assessment -->
            <div class="bg-white border border-blue-700 rounded-lg p-6 shadow-md">
                <div class="flex justify-between items-center pb-3 mb-1 border-b border-blue-700">
                    <h3 class="text-lg font-bold text-blue-700">Recent Assessment</h3>
                    <button @click="showAllPostnatalRecord = true"
                        class="bg-blue-600 text-white text-sm px-3 py-1 rounded">View All</button>
                </div>
                <div class="space-y-3 text-sm" v-for="rec in postnatalRecords.slice(0, 3)" :key="rec.id">
                    <div class="border-blue-700 border-b pb-0.5 pt-2">
                        <p class="font-semibold">{{ rec.checkup_date }} - Postnatal Visit</p>
                        <p>DAF: {{ rec.days_after_delivery }}</p>
                        <p>Mother: <span class="font-semibold uppercase">{{ rec.mother_condition }}</span> - Baby: <span
                                class="font-semibold uppercase">{{ rec.baby_condition }}</span></p>
                    </div>
                </div>
                <button @click="openAddPostnatalRecord" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">+ Add
                    Postnatal Record</button>
            </div>
        </div>

        <!-- Next Schedule + Complete -->
        <div class="flex items-center justify-between mt-4">
            <div class="rounded-lg p-6 w-1/3 shadow-md border border-blue-700 bg-white">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-blue-700">Next Postnatal Schedule</h3>
                    <div v-if="!myPreSched">
                        <button v-if="addSched" @click="addSched = false"
                            class="bg-blue-600 text-white px-4 py-1 rounded">Add Schedule</button>
                        <div v-else class="space-x-2">
                            <button @click="() => { addSched = true; schedForm.reset(); }"
                                class="bg-red-600 text-white px-4 py-1 rounded">Cancel</button>
                            <button @click="saveSched" class="bg-green-600 text-white px-4 py-1 rounded">Save</button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-medium">Date</label>
                        <TextInput v-if="!addSched" type="date" name="date" v-model="schedForm.date"
                            :message="schedForm.errors.date" />
                        <p v-else class="text-gray-700 border border-blue-500 mt-1 rounded px-2 py-1">{{
                           schedDate }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Time</label>
                        <TextInput v-if="!addSched" type="time" name="time" v-model="schedForm.time"
                            :message="schedForm.errors.time" />
                        <p v-else class="text-gray-700 border border-blue-500 mt-1 rounded px-2 py-1">{{
                            schedTime }}</p>
                    </div>
                </div>

                <div v-if="myPreSched" class="flex justify-end mt-3">
                    <button @click="done" class="bg-green-600 text-white px-4 py-1 rounded">Done</button>
                </div>
            </div>

            <div v-if="record?.isPresent" class="flex justify-end">
                <button class="bg-green-600 text-white px-6 py-2 rounded"
                    @click="handleUpdateMaternalRecord">Complete</button>
            </div>
        </div>
    </div>

            <!-- Modals -->
            <ConfirmationModal :show="showConfirmation" :name="selectedMaternalProfile.value?.name ?? ''"
                title="Confirmation" :message="confirmMessage" @cancel="showConfirmation = false" @confirm="confirmUpdate" />
            <SuccessModal :show="showSuccess" :message="successMessage" @close="finalizeUpdate" />
            <SuccessModal :show="showScheduleSuccess" :message="scheduleSuccessMessage" @close="finalizeScheduleAdd"/>
            <AddPostnatalRecord v-if="showAddPostnatalRecord" @close="showAddPostnatalRecord = false" />
            <ViewAllPostnataLRecord v-if="showAllPostnatalRecord" @closePostnatalRecords="showAllPostnatalRecord = false" />
</template>
