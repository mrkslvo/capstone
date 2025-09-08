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

// Filtering logic (only fully immunized)
const filteredRecords = computed(() =>
    props.total
        .filter(rec => (rec.immunization_record || []).some(v => v.status === 'fully'))
        .filter((rec) => {
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

// Pagination
const totalPages = computed(() =>
    Math.max(1, Math.ceil(filteredRecords.value.length / perPage.value))
)

const paginatedRecords = computed(() => {
    const start = (currentPage.value - 1) * perPage.value
    return filteredRecords.value.slice(start, start + perPage.value)
})

function goToPage(page) {
    if (page >= 1 && page <= totalPages.value) currentPage.value = page
}
function nextPage() { goToPage(currentPage.value + 1) }
function prevPage() { goToPage(currentPage.value - 1) }

// Reset page when filters/search change
watch([searchTerm, brgyFilter, purokFilter], () => {
    currentPage.value = 1
})

const modal = useModalStore()
function close() { modal.closeModal() }

// Status pill colors
function pillClass(type) {
    return ({
        fully: "bg-green-300 text-green-900",
        partially: "bg-yellow-300 text-yellow-900",
        missed: "bg-red-300 text-red-900",
    }[type] || "bg-slate-300 text-slate-800");
}
</script>

<template>
    <div
        class="p-6 bg-white rounded-2xl shadow-2xl mx-auto relative w-full max-w-[85%] min-h-[85%] overflow-y-auto animate-fadeIn">
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
                <input type="text" v-model="searchTerm" placeholder="🔍 Search name.."
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
                            <th class="p-3 text-left">Child Name</th>
                            <th class="p-3 text-left">Vaccine Name</th>
                            <th class="p-3 text-left">Date Immunized</th>
                            <th class="p-3 text-left">Barangay</th>
                            <th class="p-3 text-left">Purok</th>
                            <th class="p-3 text-left">Mother</th>
                            <th class="p-3 text-left">Father</th>
                            <th class="p-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(record, index) in paginatedRecords" :key="record.id ?? index"
                            class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition h-[40px] border-b">
                            <td class="p-3 truncate">{{ record.child_name }}</td>
                            <td class="p-3 truncate">
                                <div v-for="(vaccine, i) in record.immunization_record.filter(v => v.status === 'fully')"
                                    :key="i">
                                    {{ vaccine.vaccine_name || '—' }}
                                </div>
                            </td>
                            <td class="p-3 truncate">
                                <div v-for="(vaccine, i) in record.immunization_record.filter(v => v.status === 'fully')"
                                    :key="i">
                                    {{ vaccine.date_of_vaccination || '—' }}
                                </div>
                            </td>
                            <td class="p-3 truncate">{{ record.barangay }}</td>
                            <td class="p-3 truncate">{{ record.purok }}</td>
                            <td class="p-3 truncate">{{ record.mother_name }}</td>
                            <td class="p-3 truncate">{{ record.father_name }}</td>
                            <td class="p-3">
                                <div v-for="(vaccine, i) in record.immunization_record.filter(v => v.status === 'fully')"
                                    :key="i">
                                    <span class="text-xs px-2 py-1 rounded font-bold"
                                        :class="pillClass(vaccine.status)">
                                        Fully Immunized
                                    </span>
                                </div>
                            </td>
                        </tr>

                        <!-- Empty rows -->
                        <tr v-for="n in perPage - paginatedRecords.length" :key="'empty-' + n"
                            class="h-[40px] border-b">
                            <td colspan="8" class="p-2"></td>
                        </tr>

                        <!-- No records -->
                        <tr v-if="paginatedRecords.length === 0" class="bg-gray-50 h-[40px]">
                            <td colspan="8" class="p-3 text-center text-gray-500 italic">
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
