<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "../TextInput.vue";
import SelectInput from "../SelectInput.vue";
import SuccessModal from "../SuccessModal.vue";

const showSuccess = ref(false);
const successMessage = ref("");

const props = defineProps({
    maternalProfile: { type: Object, default: null }, // null = Add, Object = Update
});

const emit = defineEmits(["closeAddMaternalProfile"]);

function closeModal() {
    emit("closeAddMaternalProfile");
}

function calculateAge(birthdate) {
    if (!birthdate) return "N/A";

    const today = new Date();
    const bday = new Date(birthdate);

    let age = today.getFullYear() - bday.getFullYear();
    const m = today.getMonth() - bday.getMonth();

    if (m < 0 || (m === 0 && today.getDate() < bday.getDate())) {
        age--; // birthday hasn’t happened yet this year
    }

    return age;
}

// Initialize form with props
const form = useForm({
    name: props.maternalProfile?.name ?? "",
    spouse_name: props.maternalProfile?.spouse_name ?? "",
    birthdate: props.maternalProfile?.birthdate ?? "",
    // 👇 auto-compute age from birthdate
    age: props.maternalProfile?.birthdate ? calculateAge(props.maternalProfile.birthdate) : "",
    barangay: props.maternalProfile?.barangay ?? "",
    purok: props.maternalProfile?.purok ?? "",
    contact_number: props.maternalProfile?.contact_number ?? "",
    civil_status: props.maternalProfile?.civil_status ?? "",
    philhealth_no: props.maternalProfile?.philhealth_no ?? "",
    family_serial_no: props.maternalProfile?.family_serial_no ?? "",
    nhts_status: props.maternalProfile?.nhts_status ?? "",
    blood_type: props.maternalProfile?.blood_type ?? "",
});


// Save or Update
const saveOrUpdate = () => {
    if (props.maternalProfile) {
        form.put(route("maternal.update", props.maternalProfile.id), {
            onSuccess: () => {
                successMessage.value = "Maternal profile updated successfully!";
                showSuccess.value = true;
            },
        });
    } else {
        form.post(route("maternal.store"), {
            onSuccess: () => {
                form.reset();
                successMessage.value = "Maternal profile added successfully!";
                showSuccess.value = true;
            },
        });
    }
};

const bloodTypeOptions = [
    { value: "A+", label: "A+" },
    { value: "A-", label: "A-" },
    { value: "B+", label: "B+" },
    { value: "B-", label: "B-" },
    { value: "AB+", label: "AB+" },
    { value: "AB-", label: "AB-" },
    { value: "O+", label: "O+" },
    { value: "O-", label: "O-" },
];

const statusOptions = [
    { value: "single", label: "Single" },
    { value: "married", label: "Married" },
    { value: "divorce", label: "Divorce" },
];

const eligibilityOptions = [
    { value: "nhts", label: "NHTS" },
    { value: "4ps", label: "4PS" },
    { value: "ips", label: "IPS" },
    { value: "non-nhts", label: "NON-NHTS" },
];

watch(() => form.birthdate, (newVal) => {
    form.age = newVal ? calculateAge(newVal) : "";
});
</script>

<template>
    <div class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-5xl relative animate-fadeIn">

            <!-- Close Button -->
            <button @click="closeModal"
                class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-xl transition">✖</button>

            <h2 class="text-2xl font-bold text-blue-700 mb-6">
                {{ props.maternalProfile ? "Edit Maternal Profile" : "Add Maternal Profile" }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                <!-- Left Column: Personal Info -->
                <div>
                    <h3 class="font-semibold text-xl text-blue-700 mb-4">Personal & Contact Information</h3>
                    <div class="grid grid-cols-4 gap-4">
                        <TextInput placeholder="Name" name="name" v-model="form.name" :message="form.errors.name" />
                        <TextInput placeholder="Spouse Name" name="spouse_name" v-model="form.spouse_name"
                            :message="form.errors.spouse_name" />
                        <TextInput placeholder="Family Serial No" name="family_serial_no"
                            v-model="form.family_serial_no" :message="form.errors.family_serial_no" />
                        <TextInput placeholder="PhilHealth No" name="philhealth_no" v-model="form.philhealth_no"
                            :message="form.errors.philhealth_no" />
                        <TextInput placeholder="Purok" name="purok" v-model="form.purok"
                            :message="form.errors.purok" />
                        <TextInput placeholder="barangay" name="barangay" v-model="form.barangay"
                            :message="form.errors.barangay" />
                        <TextInput type="date" placeholder="Birthdate" name="birthdate" v-model="form.birthdate"
                            :message="form.errors.birthdate" />
                        <TextInput placeholder="Age" name="age" v-model="form.age" :message="form.errors.age" />
                        <TextInput placeholder="Contact Number" name="contact_number" v-model="form.contact_number"
                            :message="form.errors.contact_number" />
                        <SelectInput v-model="form.blood_type" placeholder="Blood Type" name="blood_type"
                            :options="bloodTypeOptions" :message="form.errors.blood_type" />
                        <SelectInput v-model="form.civil_status" placeholder="Civil Status" name="civil_status"
                            :options="statusOptions" :message="form.errors.civil_status" />
                        <div class=" col-span-2">
                            <label class="block font-medium mb-2">Eligibility</label>
                            <div class="flex flex-wrap gap-4">
                                <label v-for="opt in eligibilityOptions" :key="opt.value"
                                    class="flex items-center gap-2">
                                    <input type="radio" :value="opt.value" v-model="form.nhts_status"
                                        class="text-blue-600" />
                                    {{ opt.label }}
                                </label>
                            </div>
                            <p v-if="form.errors.nhts_status" class="text-sm text-red-600 mt-1">{{
                                form.errors.nhts_status
                            }}</p>
                        </div>
                    </div>
                </div>
                <!-- Right Column: Eligibility & Credentials -->


            </div>



            <!-- Buttons -->
            <div class="flex justify-end gap-4 mt-6">
                <button @click="closeModal"
                    class="px-4 py-2 border rounded-lg hover:bg-gray-100 transition">Cancel</button>
                <button @click="saveOrUpdate"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <span v-if="form.processing">{{ props.maternalProfile ? "Updating..." : "Saving..." }}</span>
                    <span v-else>{{ props.maternalProfile ? "Update" : "Save" }}</span>
                </button>
            </div>
        </div>

        <!-- Success Modal -->
        <SuccessModal :show="showSuccess" :message="successMessage" @close="showSuccess = false; location.reload();" />
    </div>
</template>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.25s ease-in-out;
}
</style>
