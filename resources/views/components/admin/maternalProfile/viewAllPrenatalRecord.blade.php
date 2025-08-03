{{-- View All Prenatal Record --}}
<div x-show="viewAllPrenatalRecord">

    <div class=" bg-white">
        <div>
            <h1 class=" text-2xl my-2">All Prenatal Record</h1>
            <h3 class=" text-green-500 text-xl">Patient: Maria Dela Cruz</h3>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg flex-1">
            <div class="container mx-auto">
                <div class="rounded border-gray-200">
                    <!-- Sticky Header -->
                    <table class="table w-full">
                        <thead class="sticky top-0 z-10 bg-white">
                            <tr class="table-head">
                                <th class="p-3">Date</th>
                                <th class="p-3">Weight(KG)</th>
                                <th class="p-3">BP(MMHG)</th>
                                <th class="p-3">FHR(BPM)</th>
                                <th class="p-3">FUNDAL HEIGHT(CM)</th>
                                <th class="p-3">FETAL POSITION</th>
                                <th class="p-3">SWELLING</th>
                                <th class="p-3">NUTRITIONAL STATUS</th>
                                <th class="p-3">RISK ASSESSMENT</th>
                            </tr>
                        </thead>
                    </table>

                    <!-- Scrollable Table Body -->
                    <div class="overflow-y-auto max-h-[50vh]">
                        <table class="table w-full">
                            <tbody>
                                <template x-for="assessment in paginatedAssessments" :key="assessment.id">
                                    <tr class="table-body">
                                        <td class="p-3" x-text="assessment.date"></td>
                                        <td class="p-3" x-text="assessment.weight"></td>
                                        <td class="p-3" x-text="assessment.bp"></td>
                                        <td class="p-3" x-text="assessment.fhr"></td>
                                        <td class="p-3" x-text="assessment.fundal"></td>
                                        <td class="p-3" x-text="assessment.position"></td>
                                        <td class="p-3" x-text="assessment.swelling"></td>
                                        <td class="p-3" x-text="assessment.nutrition"></td>
                                        <td class="p-3" x-text="assessment.risk"></td>
                                        <td class="p-3">
                                            <span class="px-2 py-1 text-xs font-semibold rounded"
                                                :class="statusColors[assessment.risk]">
                                                <span x-text="assessment.risk" class=" capitalize"></span>
                                            </span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>


                    <!-- Pagination -->
                    <div class="flex justify-between items-center p-4">
                        <div>
                            Page <span x-text="assessmentCurrentPage"></span> of <span
                                x-text="assessmentTotalPages"></span> |
                            Total: <span x-text="assessmentTotal"></span>
                        </div>
                        <div class=" space-x-2">
                            <button @click="assessmentPrevPage"
                                class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                                :disabled="assessmentCurrentPage === 1">Previous</button>
                            <button @click="assessmentNextPage"
                                class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                                :disabled="assessmentCurrentPage === assessmentTotalPages">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>