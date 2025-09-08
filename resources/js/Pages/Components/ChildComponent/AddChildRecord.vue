<script setup>
import { useForm } from "@inertiajs/vue3";
import TextInput from "../TextInput.vue";
import SelectInput from "../SelectInput.vue";
import SuccessModal from "../SuccessModal.vue";
import { ref } from "vue";

// ✅ Success Modal
const showSuccess = ref(false);
const successMessage = ref("");

// ✅ Props
const props = defineProps({
    child: {
        type: Object,
        default: null,
    },
    mothers: {
        type: Array,
        default: () => [],
    },
});

// ✅ Active tab
const activeTab = ref("mother")

// ✅ Navigation helpers
const nextTab = () => {
    const steps = ["mother", "father", "child", "birth", "address"]
    const index = steps.indexOf(activeTab.value)
    if (index < steps.length - 1) {
        activeTab.value = steps[index + 1]
    }
}

const prevTab = () => {
    const steps = ["child", "mother", "father", "birth", "address"]
    const index = steps.indexOf(activeTab.value)
    if (index > 0) {
        activeTab.value = steps[index - 1]
    }
}

// ✅ Emits
const emit = defineEmits(["closeAddChildProfile"]);
function closeModal() {
    emit("closeAddChildProfile");
}

// ✅ Dropdown state
const isMotherOpen = ref(false);
const filteredMothers = ref([...props.mothers]);

// ✅ Form initialization
const form = useForm({
    clinic_center: props.child?.clinic_center ?? "",
    barangay: props.child?.barangay ?? "",
    purok: props.child?.purok ?? "",
    address: props.child?.address ?? "",
    child_name: props.child?.child_name ?? "",
    child_no: props.child?.child_no ?? "",
    family_no: props.child?.family_no ?? "",
    sex: props.child?.sex ?? "",
    age: props.child?.age ?? "",
    mother_name: props.child?.mother_name ?? "",
    mother_occupation: props.child?.mother_occupation ?? "",
    mother_educational_level: props.child?.mother_educational_level ?? "",
    mother_no_of_pregnancies: props.child?.mother_no_of_pregnancies ?? "",
    father_name: props.child?.father_name ?? "",
    father_occupation: props.child?.father_occupation ?? "",
    father_educational_level: props.child?.father_educational_level ?? "",
    birthdate: props.child?.birthdate ?? "",
    gestational_age_at_birth: props.child?.gestational_age_at_birth ?? "",
    type_of_birth: props.child?.type_of_birth ?? "",
    birth_order: props.child?.birth_order ?? "",
    weight: props.child?.weight ?? "",
    length: props.child?.length ?? "",
    place_of_delivery: props.child?.place_of_delivery ?? "",
    birth_attendant: props.child?.birth_attendant ?? "",
    date_of_birth_registration: props.child?.date_of_birth_registration ?? "",
});

// ✅ Mother filtering
function filterMothers() {
    if (!form.mother_name) {
        filteredMothers.value = [...props.mothers];
    } else {
        filteredMothers.value = props.mothers.filter((m) =>
            m.name.toLowerCase().includes(form.mother_name.toLowerCase())
        );
    }
}
function selectMother(mother) {
    form.mother_name = mother.name;
    isMotherOpen.value = false;
}
function closeMotherDropdown() {
    setTimeout(() => (isMotherOpen.value = false), 150);
}

// ✅ Submit
const submit = () => {
    if (props.child && props.child.id) {
        // update
        form.put(route("child.update", props.child.id), {
            onSuccess: () => {
                successMessage.value = "Child profile updated successfully!";
                showSuccess.value = true;
            },
        });
    } else {
        // create
        form.post(route("child.store"), {
            onSuccess: () => {
                successMessage.value = "Child profile added successfully!";
                showSuccess.value = true;
                form.reset();
            },
        });
    }
};
</script>

<template>
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-2xl shadow-lg min-w-[50vw]  p-5 relative  min-h-[80vh]">
            <!-- Title -->
            <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">
                {{ props.child ? "Update Child" : "Register Child" }}
            </h2>

            <!-- Form -->
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-2">
                <!-- Child Info -->
                <div v-if="activeTab === 'child'" class="border rounded-xl p-4 border-blue-700 shadow-md">
                    <h3 class="text-lg font-semibold text-blue-700 mb-3">
                        Child Information
                    </h3>
                    <div class="grid grid-cols-1 gap-1">
                        <TextInput placeholder="Name" name="child_name" v-model="form.child_name"
                            :message="form.errors.child_name" />
                        <TextInput placeholder="Child No." name="child_no" v-model="form.child_no"
                            :message="form.errors.child_no" />
                        <SelectInput v-model="form.sex" placeholder="Sex" name="sex" :options="[
                            { value: 'male', label: 'Male' },
                            { value: 'female', label: 'Female' },
                        ]" :message="form.errors.sex" />
                        <TextInput placeholder="Age in Months" name="age" v-model="form.age" :message="form.errors.age" />
                    </div>
                </div>
                <!-- Mother Info -->
                <div v-if="activeTab === 'mother'" class="border rounded-xl p-4 border-blue-700 shadow-md">
                    <h3 class="text-lg font-semibold text-blue-700 mb-3">
                        Mother Information
                    </h3>
                    <div class="grid grid-cols-1 gap-1">
                        <!-- Searchable Recommendation Input -->
                        <div class="relative">
                            <div class="w-full">
                                <label class="block mb-1 text-sm font-medium">
                                    Name
                                </label>

                                <input type="text" v-model="form.mother_name" @focus="isMotherOpen = true"
                                    @input="filterMothers" @blur="closeMotherDropdown" placeholder="Name"
                                    autocomplete="off" name="mother_name"
                                    class="shadow-xs bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                            </div>

                            <div v-if="isMotherOpen && filteredMothers.length"
                                class="absolute z-10 bg-white border rounded-lg mt-1 w-full max-h-40 overflow-auto shadow-lg">
                                <div v-for="(mother, index) in filteredMothers" :key="mother.id || index"
                                    @mousedown.prevent="selectMother(mother)"
                                    class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                    {{ mother.name }}
                                </div>
                            </div>
                            <p v-if="form.errors.mother_name" class="text-red-500 text-sm mt-1">
                                {{ form.errors.mother_name }}
                            </p>
                        </div>

                        <TextInput placeholder="Occupation" name="mother_occupation" v-model="form.mother_occupation"
                            :message="form.errors.mother_occupation" />
                        <TextInput placeholder="Educational Level" name="mother_educational_level"
                            v-model="form.mother_educational_level" :message="form.errors.mother_educational_level" />
                        <TextInput placeholder="No. of Pregnancies" name="mother_no_of_pregnancies"
                            v-model="form.mother_no_of_pregnancies" :message="form.errors.mother_no_of_pregnancies" />
                    </div>
                </div>

                <!-- Father Info -->
                <div v-if="activeTab === 'father'" class="border rounded-xl p-4 border-blue-700 shadow-md">
                    <h3 class="text-lg font-semibold text-blue-700 mb-3">
                        Father Information
                    </h3>
                    <div class="grid grid-cols-1 gap-1">
                        <TextInput placeholder="Name" name="father_name" v-model="form.father_name"
                            :message="form.errors.father_name" />
                        <TextInput placeholder="Occupation" name="father_occupation" v-model="form.father_occupation"
                            :message="form.errors.father_occupation" />
                        <TextInput placeholder="Educational Level" name="father_educational_level"
                            v-model="form.father_educational_level" :message="form.errors.father_educational_level" />
                    </div>
                </div>

                <!-- Birth Info -->
                <div v-if="activeTab === 'birth'" class="col-span-2 border rounded-xl p-4 border-blue-700 shadow-md">
                    <h3 class="text-lg font-semibold text-blue-700 mb-3">
                        Birth Information
                    </h3>
                    <div class="grid grid-cols-3 gap-4">
                        <TextInput type="date" placeholder="Birthdate" name="birthdate" v-model="form.birthdate"
                            :message="form.errors.birthdate" />
                        <TextInput placeholder="Gestational Age at Birth (weeks)" name="gestational_age_at_birth"
                            v-model="form.gestational_age_at_birth" :message="form.errors.gestational_age_at_birth" />
                        <TextInput placeholder="Type of Birth" name="type_of_birth" v-model="form.type_of_birth"
                            :message="form.errors.type_of_birth" />
                        <TextInput placeholder="Birth Order" name="birth_order" v-model="form.birth_order"
                            :message="form.errors.birth_order" />
                        <TextInput placeholder="Weight (kg)" step="0.01" name="weight" min="0.01" v-model="form.weight"
                            :message="form.errors.weight" />
                        <TextInput placeholder="Length (cm)" step="0.01" min="0.01" name="length" v-model="form.length"
                            :message="form.errors.length" />
                        <TextInput placeholder="Place of Delivery" name="place_of_delivery"
                            v-model="form.place_of_delivery" :message="form.errors.place_of_delivery" />
                        <TextInput placeholder="Birth Attendant" name="birth_attendant" v-model="form.birth_attendant"
                            :message="form.errors.birth_attendant" />
                        <TextInput type="date" placeholder="Date of Birth Registration"
                            name="date_of_birth_registration" v-model="form.date_of_birth_registration"
                            :message="form.errors.date_of_birth_registration" />
                    </div>
                </div>

                <!-- Address -->
                <div v-if="activeTab === 'address'" class="border rounded-xl p-4 border-blue-700 shadow-md">
                    <h3 class="text-lg font-semibold text-blue-700 mb-3">
                        Address
                    </h3>
                    <div class="grid grid-cols-1 gap-2">
                        <TextInput placeholder="Clinic Center" name="clinic_center" v-model="form.clinic_center"
                            :message="form.errors.clinic_center" />
                        <TextInput placeholder="Barangay" name="barangay" v-model="form.barangay"
                            :message="form.errors.barangay" />
                        <TextInput placeholder="Purok" name="purok" v-model="form.purok" :message="form.errors.purok" />
                        <TextInput placeholder="Address" name="address" v-model="form.address"
                            :message="form.errors.address" />
                    </div>
                </div>

                <!-- Stepper Navigation -->
                <div class="flex items-center justify-end mt-4 gap-2">
                    <button type="button" @click="closeModal" class="px-4 py-2 bg-red-500 text-white rounded-lg">
                        Cancel
                    </button>
                    <button type="button" v-if="activeTab !== 'mother'" @click="prevTab"
                        class="px-4 py-2 bg-gray-300 rounded-lg">
                        Previous
                    </button>


                    <button type="button" v-if="activeTab !== 'address'" @click="nextTab"
                        class="px-4 py-2 bg-blue-700 text-white rounded-lg">
                        Next
                    </button>

                    <button v-if="activeTab === 'address'" type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg">
                        {{ props.child ? "Update" : "Save" }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ✅ Success Modal -->
    <SuccessModal :show="showSuccess" :message="successMessage" @close="
        showSuccess = false;
    location.reload();
    " />
</template>
