{{-- View All Immunization Record --}}
<div x-show="viewAllImmunizationRecord" x-data="Immunization()">

    <div class=" bg-white">
        <div>
            <h1 class=" text-2xl my-2">All Immunization Record</h1>
            <h3 class=" text-green-500 text-xl">Child: Maria Dela Cruz</h3>
        </div>
        <table class="table w-full">
            <thead>
                <tr class="table-head">
                <tr class="table-head">
                    <th class="p-3">Date</th>
                    <th class="p-3">VACCINE / SERVICE</th>
                    <th class="p-3">WEIGHT(KG)</th>
                    <th class="p-3">HEIGHT(CM)</th>
                    <th class="p-3">FTYPE OF FEEDING</th>
                    <th class="p-3">NOTES</th>
                </tr>
                </tr>
            </thead>
            <tbody>
                <template x-for="immunization in currentPageProfiles" :key="immunization.id">
                    <tr class="table-body">
                        <td class="p-3" x-text="immunization.date"></td>
                        <td class="p-3" x-text="immunization.date"></td>
                        <td class="p-3" x-text="immunization.date"></td>
                        <td class="p-3" x-text="immunization.date"></td>
                        <td class="p-3" x-text="immunization.date"></td>
                        <td class="p-3" x-text="immunization.date"></td>
                    </tr>
                </template>
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="flex justify-between items-center p-4">
            <div>
                Page <span x-text="currentPage"></span> of <span x-text="maxPages"></span> |
                Total Maternal Profiles: <span x-text="totalProfiles"></span>
            </div>
            <div class=" flex items-center gap-4">
                <button @click="goBack"
                    class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                    :disabled="currentPage === 1">Previous</button>
                <button @click="goNext"
                    class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                    :disabled="currentPage === maxPages">Next</button>
            </div>
        </div>
    </div>
</div>