<script setup>
import { ref, computed, provide } from "vue";
import PastMaternalRecord from "./PastMaternalRecord.vue";
import PresentMaternalRecord from "./PresentMaternalRecord.vue";
import AddMaternalProfile from "./AddMaternalProfile.vue";

const activeTab = ref("maternalProfile");
const showAddMaternalProfile = ref(false);

const openAddMaternalProfileModal = () => {
    showAddMaternalProfile.value = true;
};

const emit = defineEmits(["closeMaternalProfile", "openMainMaternal"]);

const props = defineProps({
    selectedMaternalProfile: {
        type: Object,
        required: true,
    },
});

const selectedMaternalProfile = computed(() => props.selectedMaternalProfile);
provide("selectedMaternalProfile", selectedMaternalProfile);

function close() {
    emit("openMainMaternal");
    emit("closeMaternalProfile");
}
</script>

<template>
    <div
        class="bg-white h-full rounded-2xl shadow-2xl p-6 w-full animate-fadeIn"
    >
        <!-- Tabs -->
        <div
            class="flex flex-wrap items-center justify-between pb-3 gap-2 border-b border-blue-700 mb-3"
        >
            <div class="flex flex-wrap gap-2">
                <button
                    @click="activeTab = 'maternalProfile'"
                    :class="
                        activeTab === 'maternalProfile'
                            ? 'bg-blue-600 text-white'
                            : 'bg-blue-100 text-blue-700'
                    "
                    class="px-4 py-2 rounded-full transition"
                >
                    Maternal Profile
                </button>
                <button
                    @click="activeTab = 'presentRecords'"
                    :class="
                        activeTab === 'presentRecords'
                            ? 'bg-blue-600 text-white'
                            : 'bg-blue-100 text-blue-700'
                    "
                    class="px-4 py-2 rounded-full transition"
                >
                    Present Maternal Records
                </button>
                <button
                    @click="activeTab = 'pastRecords'"
                    :class="
                        activeTab === 'pastRecords'
                            ? 'bg-blue-600 text-white'
                            : 'bg-blue-100 text-blue-700'
                    "
                    class="px-4 py-2 rounded-full transition"
                >
                    Past Maternal Records
                </button>
            </div>

            <button
                @click="close"
                class="text-gray-500 hover:text-gray-800 text-lg transition"
            >
                ✕
            </button>
        </div>

        <!-- Tab Content -->
        <div v-if="activeTab === 'maternalProfile'">
            <!-- Personal Info -->
            <div class="border-b pb-3 mb-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-blue-700">
                        Personal Information
                    </h3>
                    <button
                        @click="openAddMaternalProfileModal"
                        class="bg-blue-600 text-white px-3 py-1 rounded transition hover:bg-blue-700"
                    >
                        Edit
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Full Name:</span>
                        <div class="text-lg font-semibold">
                            {{ props.selectedMaternalProfile.name }}
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Age</span>
                        <div class="text-lg font-semibold">
                            {{ props.selectedMaternalProfile.age }}
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Birthdate</span>
                        <div class="text-lg font-semibold">
                            {{ props.selectedMaternalProfile.birthdate }}
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Spouse's Name</span>
                        <div class="text-lg font-semibold">
                            {{ props.selectedMaternalProfile.spouse_name }}
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Civil Status</span>
                        <div class="text-lg font-semibold">
                            {{ props.selectedMaternalProfile.civil_status }}
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Classification</span>
                        <div class="text-lg font-semibold">
                            {{ props.selectedMaternalProfile.nhts_status }}
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Barangay</span>
                        <div class="text-lg font-semibold">
                            {{ props.selectedMaternalProfile.barangay }}
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Purok</span>
                        <div class="text-lg font-semibold">
                            {{ props.selectedMaternalProfile.purok }}
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Blood Type</span>
                        <div class="text-lg font-semibold">
                            {{ props.selectedMaternalProfile.blood_type }}
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Contact No.</span>
                        <div class="text-lg font-semibold">
                            0{{ props.selectedMaternalProfile.contact_number }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Identification & Eligibility -->
            <div class="border-b pb-3 mb-4">
                <h3 class="text-2xl font-bold text-blue-700">
                    Identification and Eligibility
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">PhilHealth No.</span>
                        <div class="text-lg font-semibold">
                            {{ props.selectedMaternalProfile.philhealth_no }}
                        </div>
                    </div>
                    <div>
                        <span class=" text-blue-700 text-lg font-semibold">Family Serial No.</span>
                        <div class="text-lg font-semibold">
                            {{ props.selectedMaternalProfile.family_serial_no }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div v-else-if="activeTab === 'presentRecords'" class="mt-4">
            <PresentMaternalRecord />
        </div>

        <!-- Past Records Tab -->
        <div v-else-if="activeTab === 'pastRecords'" class="mt-4">
            <PastMaternalRecord />
        </div>

        <!-- Add Maternal Profile Modal -->
        <AddMaternalProfile
            v-if="showAddMaternalProfile"
            :maternalProfile="selectedMaternalProfile"
            @closeAddMaternalProfile="showAddMaternalProfile = false"
        />

        <!-- Present Records Tab -->
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
