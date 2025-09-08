<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, inject } from "vue";
import TextInput from "../TextInput.vue";
import SuccessModal from "../SuccessModal.vue";
const showSuccess = ref(false);
const successMessage = ref("");

const emit = defineEmits(["close"]);
// Child
const selectedMaternalProfile = inject("selectedMaternalProfile");

if (!selectedMaternalProfile) {
    throw new Error("selectedMaternalProfile not provided!");
}
const record = selectedMaternalProfile.value.maternal_records.find(
    (r) => r.isPresent === "yes"
);


// ✅ useForm with your table fields
const form = useForm({
    maternal_record_id:  record?.id ?? null,
    checkup_date: null,
    days_after_delivery: null,
    mother_condition: null,
    baby_condition: null,
    supplement: null,
    remarks: null,
});


const submitForm = () => {
    form.post(route("postnatal.store"), {
        onSuccess: () => {
            form.reset();
            successMessage.value = "Postnatal record addedd successfully!";
            showSuccess.value = true; // show modal
        },
    });
};


</script>

<template>
    <!-- Modal Overlay -->
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-lg  w-2/4 p-6">
            <h2 class="text-lg font-bold mb-4 col-span-2">
                Add New Postnatal Record for
                <span class="text-green-500">{{
                    selectedMaternalProfile.name
                    }}</span>
            </h2>

            <form @submit.prevent="submitForm" class="space-y-3 text-sm">
                <div class=" grid grid-cols-2 gap-2">
                    <TextInput placeholder="Checkup Date" type="date" name="date" v-model="form.checkup_date"
                        :message="form.errors.checkup_date" />
                    <TextInput placeholder="Days After Delivery" name="days_after_delivery"
                        v-model="form.days_after_delivery" :message="form.errors.days_after_delivery" />
                    <TextInput placeholder="Mother Condition" name="mother_condition" v-model="form.mother_condition"
                        :message="form.errors.mother_condition" />
                    <TextInput placeholder="Baby Condition" name="baby_condition" v-model="form.baby_condition"
                        :message="form.errors.mother_condition" />
                    <TextInput placeholder="Supplement" name="supplement" v-model="form.supplement"
                        :message="form.errors.supplement" />
                    <TextInput placeholder="Remarks" name="remarks" v-model="form.remarks"
                        :message="form.errors.remarks" />
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-2 pt-4">
                    <button type="button" @click="emit('close')" class="px-3 py-2 bg-gray-400 text-white rounded">
                        Cancel
                    </button>
                    <button type="submit" :disabled="form.processing" class="px-3 py-2 bg-blue-600 text-white rounded">
                        {{ form.processing ? "Saving..." : "Save" }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ✅ Success Modal OUTSIDE the form modal -->
    <SuccessModal :show="showSuccess" :message="successMessage" @close="
        showSuccess = false;
    location.reload();
    " />
</template>
