<script setup>
// MODAL STATE
import AddUser from "../Components/AdminComponents/AddUser.vue";
import { useModalStore } from "@/stores/modal"
import ModalWrapper from "../Components/ModalWrapper.vue";
const modal = useModalStore()

function openAddUser() {
    modal.openModal(AddUser)
}
function openUpdateUser(user) {
    modal.openModal(AddUser, { user: user })
}

import { ref, computed } from "vue";

const props = defineProps({
    users: {
        type: Array,
        default: () => [],
    },
});


// --- Search & Filter ---
const searchQuery = ref("");
const selectedPurok = ref("All Purok");
const selectedRole = ref("All Role");

const purokOptions = computed(() => {
    const unique = new Set(props.users.map((u) => String(u.purok ?? "")));
    return ["All Purok", ...unique];
});

const roleOptions = computed(() => {
    const unique = new Set(props.users.map((u) => String(u.role ?? "")));
    return ["All Role", ...unique];
});

const filteredUsers = computed(() =>
    props.users.filter((user) => {
        const username = String(user.username ?? "").toLowerCase();
        const purok = String(user.purok ?? "").toLowerCase();
        const fullname = String(user.fullname ?? "").toLowerCase();
        const role = String(user.role ?? "").toLowerCase();
        const search = searchQuery.value.toLowerCase();

        const matchesSearch =
            username.includes(search) ||
            purok.includes(search) ||
            fullname.includes(search) ||
            role.includes(search);

        const matchesPurok =
            selectedPurok.value === "All Purok" ||
            String(user.purok ?? "") === selectedPurok.value;

        const matchesRole =
            selectedRole.value === "All Role" ||
            String(user.role ?? "") === selectedRole.value;

        return matchesSearch && matchesPurok && matchesRole;
    })
);

// --- Pagination ---
const currentPage = ref(1);
const itemsPerPage = ref(11);

const totalPages = computed(() =>
    Math.max(1, Math.ceil(filteredUsers.value.length / itemsPerPage.value))
);

const paginatedUsers = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return filteredUsers.value.slice(start, start + itemsPerPage.value);
});

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};
</script>


<template>

    <Head title="User" />
    <InputText placeholder="Overridden" class="p-8!" />
    <div class="flex flex-col gap-4 h-full">
        <div class="flex flex-col gap-4 bg-white p-4 rounded-2xl shadow h-full">
            <!-- Filters -->
            <div class="flex flex-col sm:flex-row gap-3 justify-between items-center">
                <div class="flex flex-wrap gap-2 items-center">
                    <input v-model="searchQuery" type="text" placeholder="🔍 Search by fullname or role..."
                        class="border border-slate-300 rounded-lg px-3 py-2 w-60 focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" />
                    <select v-model="selectedPurok"
                        class="border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 transition">
                        <option v-for="purok in purokOptions" :key="purok">
                            {{ purok }}
                        </option>
                    </select>
                    <select v-model="selectedRole"
                        class="border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 transition">
                        <option v-for="role in roleOptions" :key="role">
                            {{ role }}
                        </option>
                    </select>
                </div>

                <button @click="openAddUser()"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow">
                    + Register
                </button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg border">
                <table class="w-full text-sm table-fixed border-collapse">
                    <thead class="bg-blue-600 text-white sticky top-0 z-10">
                        <tr>
                            <th class="p-3 text-left">Full name</th>
                            <th class="p-3 text-left">Purok</th>
                            <th class="p-3 text-left">Role</th>
                            <th class="p-3 text-left">Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(profile, index) in paginatedUsers" :key="index" @click="openUpdateUser(profile)"
                           class=" border-y hover:bg-blue-50 cursor-pointer h-12 ">
                            <td class="p-3 truncate">{{ profile.fullname }}</td>
                            <td class="p-3 truncate">{{ profile.purok }}</td>
                            <td class="p-3 truncate">{{ profile.role }}</td>
                            <td class="p-3 truncate">
                                0{{ profile.contact_number.slice(0, 1) }}-{{ profile.contact_number.slice(1, 4) }}-{{
                                    profile.contact_number.slice(4, 7) }}-{{ profile.contact_number.slice(7, 10) }}
                            </td>
                        </tr>

                        <tr v-if="paginatedUsers.length === 0" class="h-12">
                            <td colspan="4" class="text-center text-gray-500 italic">
                                No profiles found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <!-- Pagination Controls -->
            <div v-if="filteredUsers.length > itemsPerPage" class="flex justify-between items-center mt-3">
                <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:bg-slate-300 disabled:text-gray-500">
                    Prev
                </button>
                <span class="text-slate-700 font-medium">Page {{ currentPage }} of {{ totalPages }}</span>
                <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:bg-slate-300 disabled:text-gray-500">
                    Next
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Wrapper -->
    <ModalWrapper />
</template>
