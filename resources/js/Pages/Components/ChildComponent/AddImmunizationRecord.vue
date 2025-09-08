<script setup>
import { inject, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "../TextInput.vue";
import SuccessModal from "../SuccessModal.vue";

const showSuccess = ref(false);
const successMessage = ref("");

// ✅ Inject child profile
const selectedChildProfile = inject("selectedChildProfile");
if (!selectedChildProfile) {
    throw new Error("selectedChildProfile not provided!");
}

// ✅ Emits
const emit = defineEmits(["closeAddImmunizationRecord"]);
function closeModal() {
    emit("closeAddImmunizationRecord");
}

// ✅ useForm with correct fields
const form = useForm({
    child_profile_id: selectedChildProfile.value.id,
    vaccine_name: "",
    date_of_vaccination: "",
    weight: "",
    height: "",
    type_of_feeding: "",
    notes: "",
    reaction: "",
    health_status: "",
});

const submitForm = () => {
    form.post(route("immunization.store"), {
        onSuccess: () => {
            form.reset();
            successMessage.value = "Immunization record added successfully!";
            showSuccess.value = true;
        },
    });
};
</script>

<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="w-full max-w-lg mx-auto p-6 bg-white rounded-xl shadow-lg space-y-6 relative">

      <!-- Close button -->
      <button
        @click="closeModal"
        class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition"
      >
        ✖
      </button>

      <!-- Header -->
      <div class="border-b border-blue-700 pb-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-1">
          Add New Immunization Record
        </h1>
        <p class="text-sm text-gray-500">
          For child: <span class="font-semibold text-green-600 uppercase">{{ selectedChildProfile.child_name }}</span>
        </p>
      </div>

      <!-- Form -->
      <form @submit.prevent="submitForm" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <TextInput placeholder="Vaccine name" name="vaccine_name" v-model="form.vaccine_name" :message="form.errors.vaccine_name" />
          <TextInput placeholder="Date" type="date" name="date_of_vaccination" v-model="form.date_of_vaccination" :message="form.errors.date_of_vaccination" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <TextInput :step="0.01" placeholder="Weight (kg)" name="weight" v-model="form.weight" :message="form.errors.weight" />
          <TextInput :step="0.01" placeholder="Height (cm)" name="height" v-model="form.height" :message="form.errors.height" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <TextInput placeholder="Feeding type" name="type_of_feeding" v-model="form.type_of_feeding" :message="form.errors.type_of_feeding" />
          <TextInput placeholder="Notes" name="notes" v-model="form.notes" :message="form.errors.notes" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <TextInput placeholder="Past reaction" name="reaction" v-model="form.reaction" :message="form.errors.reaction" />
          <TextInput placeholder="Current health status" name="health_status" v-model="form.health_status" :message="form.errors.health_status" />
        </div>

        <!-- Submit & Cancel -->
        <div class="flex justify-end gap-3 mt-4">
          <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            Cancel
          </button>
          <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            {{ form.processing ? "Saving..." : "Save" }}
          </button>
        </div>
      </form>
    </div>

    <!-- ✅ Success Modal -->
    <SuccessModal
      :show="showSuccess"
      :message="successMessage"
      @close="showSuccess = false; location.reload();"
    />
  </div>
</template>
