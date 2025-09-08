<script setup>
import { ref, computed, provide } from "vue";
import AddMaternalProfile from "../Components/AdminComponents/AddMaternalProfile.vue";
import MaternalProfile from "../Components/AdminComponents/MaternalProfile.vue";


const props = defineProps({
    maternalProfiles: {
        type: Array,
        default: () => [],
    },
    schedules : {
        type: Array,
        default: () => [],
    }
});

provide("schedules", props.schedules);


const showMainMaternal = ref(true);
const showMaternalProfile = ref(false);
const showAddMaternalProfile = ref(false);

const openAddMaternalProfileModal = () => {
    showAddMaternalProfile.value = true;
};

const selectedMaternalProfile = ref({});



const openMaternalProfile = (selected) => {
    showMainMaternal.value = false;
    showMaternalProfile.value = true;
    selectedMaternalProfile.value = selected;
};

// --- Search & Filter ---
const searchQuery = ref("");
const selectedBarangay = ref("All Barangay");
const selectedPurok = ref("All Purok");

const presentProfiles = computed(() =>
    props.maternalProfiles
);

const barangayOptions = computed(() => {
    const unique = new Set(presentProfiles.value.map((p) => p.barangay));
    return ["All Barangay", ...unique];
});

const purokOptions = computed(() => {
    const unique = new Set(presentProfiles.value.map((p) => p.purok));
    return ["All Purok", ...unique];
});

const filteredProfiles = computed(() => {
    return presentProfiles.value.filter((profile) => {
        const matchesSearch =
            profile.name
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase()) ||
            profile.spouse_name
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase());

        const matchesBarangay =
            selectedBarangay.value === "All Barangay" ||
            profile.barangay === selectedBarangay.value;

        const matchesPurok =
            selectedPurok.value === "All Purok" || profile.purok == selectedPurok.value;

        return matchesSearch && matchesBarangay && matchesPurok;
    });
});

// --- Pagination ---
const currentPage = ref(1);
const itemsPerPage = ref(11);



const totalPages = computed(() =>
    Math.ceil(filteredProfiles.value.length / itemsPerPage.value)
);

const paginatedProfiles = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return filteredProfiles.value.slice(start, start + itemsPerPage.value);
});

if(paginatedProfiles){
    itemsPerPage.value = 11
}

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};
</script>

<template>

    <Head title="Maternal" />
    <div class="flex flex-col gap-4 h-full">
        <div v-if="showMainMaternal" class="flex flex-col gap-4 bg-white p-4 rounded-2xl shadow h-full">
            <!-- Filters -->
            <div class="flex flex-col sm:flex-row gap-3 justify-between items-center">
                <div class="flex flex-wrap gap-2 items-center">
                    <input v-model="searchQuery" type="text" placeholder="🔍 Search by name or spouse..."
                        class="border border-slate-300 rounded-lg px-3 py-2 w-60 focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" />
                    <select v-model="selectedBarangay"
                        class="border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 transition">
                        <option v-for="addr in barangayOptions" :key="addr">
                            {{ addr }}
                        </option>
                    </select>
                    <select v-model="selectedPurok"
                        class="border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 transition">
                        <option v-for="purok in purokOptions" :key="purok">
                            {{ purok }}
                        </option>
                    </select>
                </div>

                <button @click="openAddMaternalProfileModal"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow">
                    + Register
                </button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg border">
                <table class="w-full text-sm table-fixed border-collapse">
                    <thead class="bg-blue-600 text-white sticky top-0 z-10">
                        <tr>
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-left">Age</th>
                            <th class="p-3 text-left">Birthday</th>
                            <th class="p-3 text-left">Purok</th>
                            <th class="p-3 text-left">Barangay</th>
                            <th class="p-3 text-left">Spouse</th>
                            <th class="p-3 text-left">Contact No.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(profile, index) in paginatedProfiles" :key="index"
                            @click="openMaternalProfile(profile)"
                            class=" border-y hover:bg-blue-50 cursor-pointer h-12 ">
                            <td class="p-3 truncate">{{ profile.name }}</td>
                            <td class="p-3 truncate">{{ profile.age }}</td>
                            <td class="p-3 truncate">
                                {{ profile.birthdate }}
                            </td>
                            <td class="p-3 truncate">{{ profile.purok }}</td>
                            <td class="p-3 truncate">{{ profile.barangay }}</td>
                            <td class="p-3 truncate">
                                {{ profile.spouse_name }}
                            </td>
                            <td class="p-3 truncate">
                                0{{ profile.contact_number }}
                            </td>
                        </tr>

                        <!-- No records -->
                        <tr v-if="paginatedProfiles.length === 0" class="h-12 border-b">
                            <td colspan="7" class="text-center text-gray-500 italic">
                                No profiles found.
                            </td>
                        </tr>
                        <!-- Empty rows to keep table height -->
                        <tr v-for="n in itemsPerPage - paginatedProfiles.length" :key="'empty-' + n"
                            class="h-[40px] border-b">
                            <td colspan="7" class="p-2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-between items-center mt-3 text-sm">
                <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 transition">
                    ◀ Prev
                </button>
                <span>Page {{ currentPage }} of {{ totalPages }}</span>
                <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages || currentPage === 1"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 transition">
                    Next ▶
                </button>
            </div>
        </div>

        <!-- Modals -->
        <AddMaternalProfile v-if="showAddMaternalProfile" @closeAddMaternalProfile="showAddMaternalProfile = false" />
        <MaternalProfile v-if="showMaternalProfile" :selectedMaternalProfile="selectedMaternalProfile"
            @closeMaternalProfile="showMaternalProfile = false" @openMainMaternal="showMainMaternal = true" />
    </div>
</template>
