<script setup>
import { ref, computed, provide } from "vue";
import AddChildRecord from "./AddChildRecord.vue";
import ImmunizationRecord from "./ImmunizationRecord.vue";
import GrowthRecord from './GrowthRecord.vue'


const activeTab = ref("childProfile");
const showAddChildProfile = ref(false);

const openAddChildProfileModal = () => {
    showAddChildProfile.value = true;
};

const emit = defineEmits(["closeChildProfile", "openMainChild"]);

const props = defineProps({
    selectedChildProfile: {
        type: Object,
        required: true,
    },
    mothers: {
        type: Array,
        default: () => [],
    },
});

// ✅ Wrap with computed so it's reactive
const selectedChildProfile = computed(() => props.selectedChildProfile);

// ✅ Provide the reactive value
provide("selectedChildProfile", selectedChildProfile);

function close() {
    emit("openMainChild"); // if this was the intended one
    emit("closeChildProfile");
}

</script>

<template>
    <div class="p-4 bg-white shadow rounded-xl h-full space-y-4">
        <!-- Tabs -->
        <div class="flex items-center justify-between border-b border-blue-700 pb-2">
            <div class="flex gap-2">
                <button @click="activeTab = 'childProfile'" :class="activeTab === 'childProfile'
                    ? 'bg-blue-600 text-white'
                    : 'bg-blue-100 text-blue-700'" class="px-4 py-2 rounded-lg font-medium transition">
                    Child Profile
                </button>
                <button @click="activeTab = 'immunizationRecord'" :class="activeTab === 'immunizationRecord'
                    ? 'bg-blue-600 text-white'
                    : 'bg-blue-100 text-blue-700'" class="px-4 py-2 rounded-lg font-medium transition">
                    Immunization Records
                </button>
                <button @click="activeTab = 'growthRecord'" :class="activeTab === 'growthRecord'
                    ? 'bg-blue-600 text-white'
                    : 'bg-blue-100 text-blue-700'" class="px-4 py-2 rounded-lg font-medium transition">
                    Growth Records
                </button>
            </div>

            <button @click="close" class="text-gray-500 hover:text-gray-800 text-lg">
                ✕
            </button>
        </div>

        <!-- Tab Content -->
        <div v-if="activeTab === 'childProfile'" class="space-y-3">

              <!-- Parents Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <!-- Mother -->
                <div class="p-4 border rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                    <h2 class="text-2xl font-semibold text-blue-700 mb-3">Mother Information</h2>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">Name</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.mother_name }}</div>
                            </div>
                        </div>
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">Occupation</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.mother_occupation }}</div>
                            </div>
                        </div>
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">Education</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.mother_educational_level }}</div>
                            </div>
                        </div>
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">No. of Pregnancies</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.mother_no_of_pregnancies }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Father -->
                <div class="p-4 border rounded-lg bg-gray-50">
                     <div class="flex items-center justify-between mb-3">
                        <h2 class="text-2xl font-semibold text-blue-700">Father Information</h2>
                        <button @click="openAddChildProfileModal"
                            class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Edit
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">Name</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.father_name }}</div>
                            </div>
                        </div>
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">Occupation</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.father_occupation }}</div>
                            </div>
                        </div>
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">Education</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.father_educational_level }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile + Clinic Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <!-- Basic Information -->
                <div class="p-4 border rounded-lg bg-gray-50">
                    <h2 class="text-2xl font-semibold text-blue-700 mb-3">Child Information</h2>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">Full Name</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.child_name }}</div>
                            </div>
                        </div>
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">Age</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.age }}</div>
                            </div>
                        </div>
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">Sex</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.sex }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clinic Info -->
                <div class="p-4 border rounded-lg bg-gray-50">
                    <h2 class="text-2xl font-semibold text-blue-700 mb-3">Clinic Information</h2>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">Clinic/Health Center</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.clinic_center }}</div>
                            </div>
                        </div>
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">Barangay</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.barangay }}</div>
                            </div>
                        </div>
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">Purok/Sitio</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.purok }}</div>
                            </div>
                        </div>
                        <div>
                            <span class=" text-blue-700 text-lg font-semibold">Date of Registration</span>
                            <div class="text-md font-semibold">
                                <div>{{ props.selectedChildProfile.date_of_birth_registration }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Birth Info -->
            <div class="p-4 border rounded-lg bg-gray-50">
                <h2 class="text-2xl font-semibold text-blue-700 mb-3">Birth Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Birthdate</span>
                        <div class="text-md font-semibold">
                            <div>{{ props.selectedChildProfile.birthdate }}</div>
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Gestational Age</span>
                        <div class="text-md font-semibold">
                            <div>{{ props.selectedChildProfile.gestational_age_at_birth }}</div>
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Type of Birth</span>
                        <div class="text-md font-semibold">
                            <div>{{ props.selectedChildProfile.type_of_birth }}</div>
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Birth Order</span>
                        <div class="text-md font-semibold">
                            <div>{{ props.selectedChildProfile.birth_order }}</div>
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Birth Weight</span>
                        <div class="text-md font-semibold">
                            <div>{{ props.selectedChildProfile.weight }}</div>
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Place of Deliveryt</span>
                        <div class="text-md font-semibold">
                            <div>{{ props.selectedChildProfile.place_of_delivery }}</div>
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Birth Attendant</span>
                        <div class="text-md font-semibold">
                            <div>{{ props.selectedChildProfile.birth_attendant }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other Tabs -->
        <div v-else-if="activeTab === 'immunizationRecord'" class="mt-4">
            <ImmunizationRecord />
        </div>
        <!-- Other Tabs -->
        <div v-else-if="activeTab === 'growthRecord'" class="mt-4">
            <GrowthRecord />
        </div>

    </div>


    <AddChildRecord :mothers="mothers" v-if="showAddChildProfile" :child="selectedChildProfile"
        @closeAddChildProfile="showAddChildProfile = false" />
</template>
