<script setup>
import { CircleX } from 'lucide-vue-next'
import { useModalStore } from '@/stores/modal'
import { ref, computed, watch } from 'vue'

const props = defineProps({
    title: String,
    message: String,
    total: { type: Array, default: () => [] }
})

const perPage = ref(8)
const searchTerm = ref("")
const brgyFilter = ref("All Barangay")
const purokFilter = ref("All Purok")
const currentPage = ref(1)

// Unique dropdown options
function getUniquePuroks() {
    const unique = [...new Set(props.total.map(m => m.purok).filter(Boolean))]
    return ["All Purok", ...unique]
}
function getUniqueBrgy() {
    const unique = [...new Set(props.total.map(m => m.barangay).filter(Boolean))]
    return ["All Barangay", ...unique]
}

// Filtering logic
const filteredRecords = computed(() =>
    props.total.filter((rec) => {
        const matchesSearch =
            !searchTerm.value ||
            Object.values(rec).some((val) =>
                String(val ?? "").toLowerCase().includes(searchTerm.value.toLowerCase())
            )

        const matchesBrgy =
            brgyFilter.value === "All Barangay" || rec.barangay === brgyFilter.value

        const matchesPurok =
            purokFilter.value === "All Purok" || rec.purok === purokFilter.value

        return matchesSearch && matchesBrgy && matchesPurok
    })
)

const totalPages = computed(() =>
    Math.max(1, Math.ceil(filteredRecords.value.length / perPage.value))
)

const paginatedRecords = computed(() => {
    const start = (currentPage.value - 1) * perPage.value
    return filteredRecords.value.slice(start, start + perPage.value)
})

function goToPage(page) {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page
    }
}
function nextPage() {
    goToPage(currentPage.value + 1)
}
function prevPage() {
    goToPage(currentPage.value - 1)
}

// Reset page when filters/search change
watch([searchTerm, brgyFilter, purokFilter], () => {
    currentPage.value = 1
})

const modal = useModalStore()
function close() {
    modal.closeModal()
}
</script>

<template>
    <div
        class="p-6 bg-white rounded-2xl shadow-2xl relative w-full mx-auto max-w-[85%] min-h-[85%] overflow-y-auto animate-fadeIn">
        <div class="w-full h-full bg-white flex flex-col gap-4">
            <!-- Header -->
            <div class="w-full flex items-center justify-between">
                <h2 class="text-xl font-bold">{{ title }}</h2>
                <h2 class="text-xl font-bold">{{ message }}</h2>
                <button @click="close" class="text-gray-500">
                    <CircleX class="text-blue-700 hover:text-red-700 smooth" />
                </button>
            </div>

            <!-- Filters -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <input type="text" v-model="searchTerm"
                    placeholder="🔍 Search name, birth, brgy, purok, number, status..."
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />

                <select v-model="brgyFilter"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option :value="item" v-for="item in getUniqueBrgy()" :key="item">
                        {{ item }}
                    </option>
                </select>

                <select v-model="purokFilter"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option :value="item" v-for="item in getUniquePuroks()" :key="item">
                        {{ item }}
                    </option>
                </select>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg border">
                <table class="w-full text-sm table-fixed border-collapse">
                    <thead class="bg-blue-600 text-white sticky top-0 z-10">
                        <tr>
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-left">Birthdate</th>
                            <th class="p-3 text-left">Barangay</th>
                            <th class="p-3 text-left">Purok</th>
                            <th class="p-3 text-left">Contact No.</th>
                            <th class="p-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(record, index) in paginatedRecords" :key="record.id ?? index"
                            class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition h-[40px] border-b">
                            <td class="p-3 truncate">{{ record.name }}</td>
                            <td class="p-3 truncate">{{ record.birthdate }}</td>
                            <td class="p-3 truncate">{{ record.barangay }}</td>
                            <td class="p-3 truncate">{{ record.purok }}</td>
                            <td class="p-3 truncate">0{{ record.contact_number }}</td>
                            <td class="p-3 truncate">{{ record.status }}</td>
                        </tr>

                        <!-- Empty rows -->
                        <tr v-for="n in perPage - paginatedRecords.length" :key="'empty-' + n"
                            class="h-[40px] border-b">
                            <td colspan="6" class="p-2"></td>
                        </tr>

                        <!-- No records -->
                        <tr v-if="paginatedRecords.length === 0" class="bg-gray-50 h-[40px]">
                            <td colspan="6" class="p-3 text-center text-gray-500 italic">
                                No records found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-between items-center mt-6 text-sm">
                <span class="text-gray-600">
                    Page {{ currentPage }} of {{ totalPages }} | Total: {{ filteredRecords.length }}
                </span>
                <div class="space-x-2">
                    <button @click="prevPage" :disabled="currentPage === 1"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 transition">
                        ◀ Prev
                    </button>
                    <button @click="nextPage" :disabled="currentPage === totalPages"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 transition">
                        Next ▶
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
