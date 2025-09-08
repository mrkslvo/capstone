<script setup>
import { ref, computed, provide } from "vue";
import AddChildRecord from "../Components/ChildComponent/AddChildRecord.vue";
import ChildProfile from "../Components/ChildComponent/ChildProfile.vue";

const props = defineProps({
    childProfiles: { type: Array, default: () => [] },
    mothers: { type: Array, default: () => [] },
    schedules: { type: Array, default: () => [] },
});

provide("schedules", props.schedules);

const showMainChild = ref(true);
const showChildProfile = ref(false);
const showAddChildProfile = ref(false);

const openAddChildProfileModal = () => (showAddChildProfile.value = true);

const selectedChildProfile = ref({});

const openChildProfile = (selected) => {
    showMainChild.value = false;
    showChildProfile.value = true;
    selectedChildProfile.value = selected;
};

// --- Search & Filter ---
const searchQuery = ref("");
const selectedName = ref("All Names");
const selectedAge = ref("All Age");

const nameOptions = computed(() => {
    const unique = new Set(props.childProfiles.map((p) => p.child_name));
    return ["All Names", ...unique];
});

const ageOptions = computed(() => {
    const unique = new Set(props.childProfiles.map((p) => p.age));
    return ["All Age", ...unique];
});

const filteredProfiles = computed(() =>
    props.childProfiles.filter((profile) => {
        const matchesSearch =
            profile.child_name
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase()) ||
            String(profile.age)
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase());
        const matchesName =
            selectedName.value === "All Names" ||
            profile.child_name === selectedName.value;
        const matchesAge =
            selectedAge.value === "All Age" || profile.age == selectedAge.value;
        return matchesSearch && matchesName && matchesAge;
    })
);

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

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) currentPage.value = page;
};
</script>

<template>

    <Head title="Child" />
    <div v-if="showMainChild" class="flex flex-col gap-4 h-full p-4 bg-white rounded-xl shadow-md">
        <!-- Header & Filters -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex flex-wrap gap-2 items-center">
                <input v-model="searchQuery" type="text" placeholder="🔍 Search by name or age..."
                    class="border rounded-lg px-3 py-2 w-52 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                <select v-model="selectedName" class="border rounded-lg px-3 py-2">
                    <option v-for="name in nameOptions" :key="name">
                        {{ name }}
                    </option>
                </select>
                <select v-model="selectedAge" class="border rounded-lg px-3 py-2">
                    <option v-for="age in ageOptions" :key="age">
                        {{ age }}
                    </option>
                </select>
            </div>

            <button @click="openAddChildProfileModal"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Register
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg border">
            <table class="w-full text-sm table-fixed border-collapse">
                <thead class="bg-blue-600 text-white sticky top-0 z-10">
                    <tr>
                        <th class="p-3 text-left">Child Name</th>
                        <th class="p-3 text-left">Sex</th>
                        <th class="p-3 text-left">Birthdate</th>
                        <th class="p-3 text-left">Age</th>
                        <th class="p-3 text-left">Birth Length</th>
                        <th class="p-3 text-left">Birth Weight</th>
                        <th class="p-3 text-left">Address</th>
                        <th class="p-3 text-left">Mother</th>
                        <th class="p-3 text-left">Father</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data rows -->
                    <tr v-for="(profile, index) in paginatedProfiles" :key="index"
                        class=" border-y hover:bg-blue-50 cursor-pointer h-12" @click="openChildProfile(profile)">
                        <td class="p-3 truncate">{{ profile.child_name }}</td>
                        <td class="p-3 truncate">{{ profile.sex }}</td>
                        <td class="p-3 truncate">{{ profile.birthdate }}</td>
                        <td class="p-3 truncate">{{ profile.age }}</td>
                        <td class="p-3 truncate">{{ profile.length }}</td>
                        <td class="p-3 truncate">{{ profile.weight }}</td>
                        <td class="p-3 truncate">{{ profile.address }}</td>
                        <td class="p-3 truncate">{{ profile.mother_name }}</td>
                        <td class="p-3 truncate">{{ profile.father_name }}</td>
                    </tr>
                       <!-- No records -->
                    <tr v-if="paginatedProfiles.length === 0" class="h-12 border-b">
                        <td colspan="9" class="text-center text-gray-500 italic">
                            No profiles found.
                        </td>
                    </tr>
                    <!-- Empty rows to keep table height -->
                    <tr v-for="n in itemsPerPage - paginatedProfiles.length" :key="'empty-' + n"
                        class="h-[40px] border-b">
                        <td colspan="9" class="p-2"></td>
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
            <span>
                Page {{ currentPage }} of {{ totalPages}}
            </span>
            <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages || currentPage === 1"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 transition">
                Next ▶
            </button>
        </div>
    </div>

    <AddChildRecord :mothers="mothers" v-if="showAddChildProfile" @closeAddChildProfile="showAddChildProfile = false" />

    <ChildProfile v-if="showChildProfile" :mothers="mothers" :selectedChildProfile="selectedChildProfile"
        @closeChildProfile="showChildProfile = false" @openMainChild="showMainChild = true" />
</template>
