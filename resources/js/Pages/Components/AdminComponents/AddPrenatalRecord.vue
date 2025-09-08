<script setup>
import { inject, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "../TextInput.vue";
import SuccessModal from "../SuccessModal.vue";
import ConfirmationModal from "../ConfirmationModal.vue";

const showSuccess = ref(false);
const successMessage = ref("");
const showConfirmation = ref(false);

// Child
const selectedMaternalProfile = inject("selectedMaternalProfile");
if (!selectedMaternalProfile) {
    throw new Error("selectedMaternalProfile not provided!");
}

const record = selectedMaternalProfile.value.maternal_records.find(
  (r) => r.isPresent === "yes"
);

const props = defineProps({
    maternalRecordId: Number,
    maternalName: String,
});
const emit = defineEmits(["close"]);



const form = useForm({
    maternal_record_id: record?.id ?? null,
    date: null,
    weight: null,
    blood_pressure: null,
    heart_rate: null,
    fetal_heart_rate: null,
    fundal_height: null,
    fetal_position: null,
    swelling: null,
    nutritional_status: null,
});

function close() {
    emit("close");
}

// ✅ Ask confirmation first
function trySaveRecord() {
    showConfirmation.value = true;
}

// ✅ If confirmed
function saveRecord() {
    form.post(route("prenatal.store"), {
        onSuccess: () => {
            successMessage.value = "Prenatal successfully recorded!";
            showSuccess.value = true;
            form.reset();
        },
    });
}
</script>

<template>
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center">
        <form @submit.prevent="trySaveRecord" class="w-2/4">
            <div class="bg-white p-6 rounded-lg grid grid-cols-2 gap-2">
                <h2 class="text-lg font-bold mb-4 col-span-2">
                    Add New Prenatal Record for
                    <span class="text-green-500">{{ selectedMaternalProfile.name }}</span>
                </h2>

                <TextInput placeholder="Date" type="date" name="date" v-model="form.date" :message="form.errors.date" />
                <TextInput placeholder="Weight" name="weight" v-model="form.weight" :message="form.errors.weight" />
                <TextInput placeholder="Blood Pressure" name="blood_pressure" v-model="form.blood_pressure" :message="form.errors.blood_pressure" />
                <TextInput placeholder="Heart Rate" name="heart_rate" v-model="form.heart_rate" :message="form.errors.heart_rate" />
                <TextInput placeholder="Fetal Heart Rate" name="fetal_heart_rate" v-model="form.fetal_heart_rate" :message="form.errors.fetal_heart_rate" />
                <TextInput placeholder="Fetal Position" name="fetal_position" v-model="form.fetal_position" :message="form.errors.fetal_position" />
                <TextInput placeholder="Fundal height" name="fundal_height" v-model="form.fundal_height" :message="form.errors.fundal_height" />
                <TextInput placeholder="Swelling" name="swelling" v-model="form.swelling" :message="form.errors.swelling" />
                <TextInput placeholder="Nutritional Status" name="nutritional_status" v-model="form.nutritional_status" :message="form.errors.nutritional_status" />

                <div class="flex justify-end mt-4 space-x-2 col-span-2">
                    <button type="button" @click="close" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save Record</button>
                </div>
            </div>
        </form>
    </div>

    <!-- ✅ Confirmation Modal -->
    <ConfirmationModal
        :show="showConfirmation"
        title="Confirm Save"
        message="Do you want to save this prenatal record?"
        @cancel="showConfirmation = false"
        @confirm="() => { showConfirmation = false; saveRecord(); }"
    />

    <!-- ✅ Success Modal -->
    <SuccessModal
        :show="showSuccess"
        :message="successMessage"
        @close="() => { showSuccess = false; location.reload(); }"
    />
</template>
