{{-- Total Pregnancies Modal --}}
<div x-show="showTotalPregnancies" x-cloak>
    <div class="fixed flex items-center justify-center top-0 z-20 left-0 w-full h-full bg-black/40">
        <div class="bg-white w-[80%] h-[90%] rounded-xl p-6 flex flex-col" x-data="totalPregnancies()" x-cloak
            x-transition>

            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl">Total Pregnancies</h1>
                <button @click="showTotalPregnancies = false"
                    class="text-2xl text-gray-500 hover:text-black cursor-pointer">&times;</button>
            </div>

            <!-- Filter Inputs -->
            <div class="flex gap-2 items-center mb-4">
                <input x-model="searchPregnancies" type="text" placeholder="Search by Type..."
                    class="w-1/3 border border-gray-300 rounded px-3 py-2" />
                <select x-model="filterAddress" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Filter by Purok</option>
                    <template x-for="purok in purokList" :key="purok">
                        <option :value="purok" x-text="purok"></option>
                    </template>
                </select>
            </div>

            <!-- Table container grows and scrolls if needed -->
            <div class=" h-full">
                <table class="w-full text-sm text-left">
                    <thead class="bg-blue-200">
                        <tr>
                            <th class="p-3">Name</th>
                            <th class="p-3">Purok</th>
                            <th class="p-3">Age</th>
                            <th class="p-3">Last Menstrual Period</th>
                            <th class="p-3">Est. Due Date</th>
                            <th class="p-3">Risk Factor</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="assessment in paginatedTotalPregnancies" :key="assessment.id">
                            <tr>
                                <td class="p-3" x-text="assessment.name ?? 'Maria Dela Cruz'"></td>
                                <td class="p-3" x-text="assessment.purok ?? 'Purok 1'"></td>
                                <td class="p-3" x-text="assessment.age ?? '29'"></td>
                                <td class="p-3" x-text="assessment.lmp ?? assessment.date"></td>
                                <td class="p-3" x-text="assessment.edd ?? '2024-12-01'"></td>
                                <td class="p-3" x-text="assessment.risk ?? 'Low'"></td>
                                <td class="p-3" x-text="assessment.type"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Pagination fixed at bottom -->
            <div class="flex items-center justify-between pt-4 mt-4 border-t">
                <div>
                    Page <span x-text="totalPregnanciesCurrentPage"></span> of
                    <span x-text="totalPregnanciesTotalPages"></span> |
                    Total: <span x-text="totalPregnanciesTotal"></span>
                </div>
                <div class="space-x-2">
                    <button @click="totalPregnanciesPrevPage"
                        class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                        :disabled="totalPregnanciesCurrentPage === 1">Previous</button>
                    <button @click="totalPregnanciesNextPage"
                        class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                        :disabled="totalPregnanciesCurrentPage === totalPregnanciesTotalPages">Next</button>
                </div>
            </div>

        </div>
    </div>

</div>


<script>
    function totalPregnancies() {
        return {
            searchPregnancies: '',
            filterAddress: '',
            totalPregnanciesCurrentPage: 1,
            totalPregnanciesPerPage: 9,
            totalPregnancies: [
                { id: 1, name: 'Anna Cruz', purok: 'Purok 1', age: 28, lmp: '2023-08-01', edd: '2024-05-08', type: 'Prenatal Visit', risk: 'Low' },
                { id: 2, name: 'Jessa Ramos', purok: 'Purok 2', age: 33, lmp: '2023-07-15', edd: '2024-04-22', type: 'Prenatal Visit', risk: 'High' },
                { id: 3, name: 'May Ortega', purok: 'Purok 3', age: 25, lmp: '2023-09-01', edd: '2024-06-10', type: 'Prenatal Visit', risk: 'Moderate' },
                { id: 4, name: 'May Ortega', purok: 'Purok 3', age: 25, lmp: '2023-09-01', edd: '2024-06-10', type: 'Prenatal Visit', risk: 'Moderate' },
                { id: 5, name: 'May Ortega', purok: 'Purok 3', age: 25, lmp: '2023-09-01', edd: '2024-06-10', type: 'Prenatal Visit', risk: 'Moderate' },
                { id: 6, name: 'May Ortega', purok: 'Purok 3', age: 25, lmp: '2023-09-01', edd: '2024-06-10', type: 'Prenatal Visit', risk: 'Moderate' },
                { id: 7, name: 'May Ortega', purok: 'Purok 3', age: 25, lmp: '2023-09-01', edd: '2024-06-10', type: 'Prenatal Visit', risk: 'Moderate' },
                { id: 8, name: 'May Ortega', purok: 'Purok 3', age: 25, lmp: '2023-09-01', edd: '2024-06-10', type: 'Prenatal Visit', risk: 'Moderate' },
                { id: 9, name: 'May Ortega', purok: 'Purok 3', age: 25, lmp: '2023-09-01', edd: '2024-06-10', type: 'Prenatal Visit', risk: 'Moderate' },
                { id: 10, name: 'May Ortega', purok: 'Purok 3', age: 25, lmp: '2023-09-01', edd: '2024-06-10', type: 'Prenatal Visit', risk: 'Moderate' },
                { id: 11, name: 'May Ortega', purok: 'Purok 3', age: 25, lmp: '2023-09-01', edd: '2024-06-10', type: 'Prenatal Visit', risk: 'Moderate' },
                { id: 12, name: 'May Ortega', purok: 'Purok 3', age: 25, lmp: '2023-09-01', edd: '2024-06-10', type: 'Prenatal Visit', risk: 'Moderate' },
            ],

            get purokList() {
                return [...new Set(this.totalPregnancies.map(p => p.purok))];
            },
            get filteredReports() {
                return this.totalPregnancies.filter(p =>
                    (!this.searchPregnancies || (
                        (p.type && p.type.toLowerCase().includes(this.searchPregnancies.toLowerCase())) ||
                        (p.name && p.name.toLowerCase().includes(this.searchPregnancies.toLowerCase()))
                    )) &&
                    (!this.filterAddress || p.purok === this.filterAddress)
                );
            },

            get totalPregnanciesTotal() {
                return this.filteredReports.length;
            },

            get totalPregnanciesTotalPages() {
                return Math.ceil(this.totalPregnanciesTotal / this.totalPregnanciesPerPage);
            },

            get paginatedTotalPregnancies() {
                const start = (this.totalPregnanciesCurrentPage - 1) * this.totalPregnanciesPerPage;
                return this.filteredReports.slice(start, start + this.totalPregnanciesPerPage);
            },

            totalPregnanciesNextPage() {
                if (this.totalPregnanciesCurrentPage < this.totalPregnanciesTotalPages) {
                    this.totalPregnanciesCurrentPage++;
                }
            },

            totalPregnanciesPrevPage() {
                if (this.totalPregnanciesCurrentPage > 1) {
                    this.totalPregnanciesCurrentPage--;
                }
            }
        }
    }
</script>
