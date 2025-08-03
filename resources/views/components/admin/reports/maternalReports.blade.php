<!-- MATERNAL REPORTS -->
<div x-show="maternalReports">

    <div class="bg-white p-4 rounded-lg ">

        <!-- Overall Reports -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

            <!-- Maternal -->
            <div @click="openTotalPregnancies()"
                class="bg-sky-200 p-4 rounded-lg shadow text-sky-900 cursor-pointer hover:bg-sky-300 transition">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-sm">Maternal</h2>
                        <p class="text-2xl font-bold">1,234</p>
                    </div>
                    <span class="text-xl">👩‍🍼</span>
                </div>
            </div>


            <!-- Delivered -->
            <div @click="openDelivered()"
                class="bg-green-200 p-4 rounded-lg shadow text-green-900 cursor-pointer hover:bg-green-300 transition">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-sm">Delivered</h2>
                        <p class="text-2xl font-bold">9,101</p>
                    </div>
                    <span class="text-xl">📦</span>
                </div>
            </div>

            <!-- Missed Prenatal -->
            <div @click="openMissedPrenatal()"
                class="bg-yellow-200 p-4 rounded-lg shadow text-yellow-900 cursor-pointer hover:bg-yellow-300 transition">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-sm">Missed Prenatal</h2>
                        <p class="text-2xl font-bold">9,101</p>
                    </div>
                    <span class="text-xl">📅</span>
                </div>
            </div>

            <!-- High Risks -->
            <div @click="openHighRisks()"
                class="bg-red-200 p-4 rounded-lg shadow text-red-900 cursor-pointer hover:bg-red-300 transition">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-sm">High Risks</h2>
                        <p class="text-2xl font-bold">5,678</p>
                    </div>
                    <span class="text-xl">💉</span>
                </div>
            </div>

        </div>


        <div class="mb-4">
            <input x-model="search" type="text" placeholder="Search..."
                class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border-b border-b-gray-200">
                <thead class="bg-blue-200">
                    <tr>
                        <th class="px-4 py-2 ">Purok Name</th>
                        <th class="px-4 py-2 ">total pregnancies</th>
                        <th class="px-4 py-2 ">High Risks Cases</th>
                        <th class="px-4 py-2 ">Delivered</th>
                        <th class="px-4 py-2 ">Missed Prenatal Visits</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="report in paginatedReports" :key="report.id">
                        <tr>
                            <td class="px-4 py-2 border-b border-blue-200" x-text="report.name">
                            </td>
                            <td class="px-4 py-2 border-b border-blue-200" x-text="report.maternal"></td>
                            <td class="px-4 py-2 border-b border-blue-200" x-text="report.immunization"></td>
                            <td class="px-4 py-2 border-b border-blue-200" x-text="report.moderate"></td>
                            <td class="px-4 py-2 border-b border-blue-200" x-text="report.growth"></td>

                        </tr>
                    </template>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="flex items-center justify-between p-4">
                <div>
                    Page <span x-text="reportCurrentPage"></span> of <span x-text="reportTotalPages"></span>
                    |
                    Total: <span x-text="reportTotal"></span>
                </div>
                <div class=" space-x-2">
                    <button @click="reportPrevPage"
                        class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                        :disabled="reportCurrentPage === 1">Previous</button>
                    <button @click="reportNextPage"
                        class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                        :disabled="reportCurrentPage === reportTotalPages">Next</button>
                </div>
            </div>
        </div>
    </div>

</div>