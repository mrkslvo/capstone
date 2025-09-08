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
const emit = defineEmits(["closeAddGrowthRecord"]);
function closeModal() {
    emit("closeAddGrowthRecord");
}

// ✅ useForm with correct fields
const form = useForm({
    child_profile_id: selectedChildProfile.value.id,
    date: "",
    age_in_months: "",
    weight: "",
    height: "",
    supplement_given: "",
    assessment: "",
});

const submitForm = () => {
    form.post(route("growth.store"), {
        onSuccess: () => {
            form.reset();
            successMessage.value = "Growth record added successfully!";
            showSuccess.value = true;
        },
    });
};
</script>

<template>
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <!-- Modal -->
        <div
            class="w-full max-w-2xl mx-auto p-6 bg-white rounded-2xl shadow-lg border border-gray-200"
        >
            <!-- Header -->
            <div class="border-b border-gray-200 pb-4 mb-4 flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">
                        Add Growth Record
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Assessment details for
                        <span class="font-semibold text-green-600 uppercase">
                            {{ selectedChildProfile.child_name }}
                        </span>
                    </p>
                </div>
                <button
                    @click="closeModal"
                    class="text-gray-400 hover:text-gray-700 transition"
                >
                    ✖
                </button>
            </div>

            <!-- Form -->
            <form class="space-y-6" @submit.prevent="submitForm">
                <!-- Row 1 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <TextInput
                        type="date"
                        placeholder="Date"
                        name="date"
                        v-model="form.date"
                        :message="form.errors.date"
                    />

                    <TextInput
                        type="number"
                        placeholder="Age in Months"
                        name="age_in_months"
                        v-model="form.age_in_months"
                        :message="form.errors.age_in_months"
                    />
                </div>

                <!-- Row 2 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <TextInput
                        step="0.01"
                        placeholder="Height (cm)"
                        name="height"
                        v-model="form.height"
                        :message="form.errors.height"
                    />

                    <TextInput
                        step="0.01"
                        placeholder="Weight (kg)"
                        name="weight"
                        v-model="form.weight"
                        :message="form.errors.weight"
                    />
                </div>

                <!-- Row 3 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <TextInput
                        placeholder="Supplement"
                        name="supplement_given"
                        v-model="form.supplement_given"
                        :message="form.errors.supplement_given"
                    />

                    <TextInput
                        placeholder="Assessment"
                        name="assessment"
                        v-model="form.assessment"
                        :message="form.errors.assessment"
                    />
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button
                        type="button"
                        @click="closeModal"
                        class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 transition"
                    >
                        {{ form.processing ? "Saving..." : "Save Record" }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ✅ Success Modal -->
    <SuccessModal
        :show="showSuccess"
        :message="successMessage"
        @close="
            showSuccess = false;
            location.reload();
        "
    />
</template>
