<x-layout>
    <title>Reports</title>
    <div x-data="reports() " x-cloak x-init="init()" class="flex h-screen bg-blue-50">
        <x-adminSidebar />
        <!-- Main Content -->
        <div class="flex-1 p-4 overflow-auto relative">
            <div class="space-y-3 flex flex-col h-full">
                <x-header>Reports</x-header>
                <div class=" p-4 h-screen bg-white rounded shadow scrollable relative">
                    <div
                        class="w-full absolute top-0 left-0 h-full bg-white text-gray-800 rounded-lg shadow-xl p-6 z-50 ">

                        <!-- Header -->
                        <div class="w-full flex items-center justify-between border-b border-blue-700 pb-4 px-4">
                            <!-- Tabs -->
                            <div class="space-x-2">
                                <button @click="openMaternalReports()" :class="maternalReports
        ? 'bg-blue-700 text-white'
        : 'bg-blue-100 text-blue-800 hover:bg-blue-700 hover:text-white cursor-pointer'"
                                    class="px-4 py-2 rounded-md font-semibold transition">
                                    Maternal Reports
                                </button>
                                <button @click="openImmunizationReports()" :class="immunizationReports
        ? 'bg-blue-700 text-white'
        : 'bg-blue-100 text-blue-800 hover:bg-blue-700 hover:text-white cursor-pointer'"
                                    class="px-4 py-2 rounded-md font-semibold transition">
                                    Immunization Reports
                                </button>
                                <button @click="openGrowthReports()" :class="growthReports
        ? 'bg-blue-700 text-white'
        : 'bg-blue-100 text-blue-800 hover:bg-blue-700 hover:text-white cursor-pointer'"
                                    class="px-4 py-2 rounded-md font-semibold transition">
                                    Growth Reports
                                </button>
                            </div>
                        </div>

                        @include('components.admin.reports.maternalReports')
                        @include('components.admin.reports.growthReports')
                        @include('components.admin.reports.immunizationReports')
                        @include('components.admin.reports.highRisks')
                        @include('components.admin.reports.delivered')
                        @include('components.admin.reports.totalPregnancies')
                        @include('components.admin.reports.missedPrenatal')

                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        function reports() {
            return {
                maternalReports: true,
                immunizationReports: false,
                growthReports: false,

                // Reports data and pagination
                reportCurrentPage: 1,
                reportPerPage: 6,
                reports: [
                    { id: 1, name: 'Purok 1', maternal: 120, immunization: 450, moderate: 300, growth: 890, status: 100 },
                    { id: 2, name: 'Purok 2', maternal: 120, immunization: 450, moderate: 300, growth: 890, status: 100 },
                    { id: 3, name: 'Purok 3', maternal: 120, immunization: 450, moderate: 300, growth: 890, status: 100 },
                    { id: 4, name: 'Purok 4', maternal: 120, immunization: 450, moderate: 300, growth: 890, status: 100 },
                    { id: 5, name: 'Purok 5', maternal: 120, immunization: 450, moderate: 300, growth: 890, status: 100 },
                    { id: 6, name: 'Purok 6', maternal: 120, immunization: 450, moderate: 300, growth: 890, status: 100 },
                    { id: 7, name: 'Purok 7', maternal: 120, immunization: 450, moderate: 300, growth: 890, status: 100 },
                    { id: 8, name: 'Purok 8', maternal: 120, immunization: 450, moderate: 300, growth: 890, status: 100 },
                    { id: 9, name: 'Purok 9', maternal: 120, immunization: 450, moderate: 300, growth: 890, status: 100 },
                    { id: 10, name: 'Purok 10', maternal: 120, immunization: 450, moderate: 300, growth: 890, status: 100 },
                    { id: 11, name: 'Purok 11', maternal: 120, immunization: 450, moderate: 300, growth: 890, status: 100 },
                    { id: 12, name: 'Purok 12', maternal: 120, immunization: 450, moderate: 300, growth: 890, status: 100 },
                    // ... up to Purok 14
                ],

                get reportTotal() {
                    return this.reports.length;
                },
                get reportTotalPages() {
                    return Math.ceil(this.reportTotal / this.reportPerPage);
                },
                get paginatedReports() {
                    const start = (this.reportCurrentPage - 1) * this.reportPerPage;
                    return this.reports.slice(start, start + this.reportPerPage);
                },
                reportNextPage() {
                    if (this.reportCurrentPage < this.reportTotalPages) this.reportCurrentPage++;
                },
                reportPrevPage() {
                    if (this.reportCurrentPage > 1) this.reportCurrentPage--;
                },

                openMaternalReports() {
                    this.maternalReports = true;
                    this.immunizationReports = false;
                    this.growthReports = false;
                },


                openImmunizationReports() {
                    this.maternalReports = false;
                    this.immunizationReports = true;
                    this.growthReports = false;
                },

                openGrowthReports() {
                    this.maternalReports = false;
                    this.immunizationReports = false;
                    this.growthReports = true;
                },

                showTotalPregnancies: false,
                showHighRisks: false,
                showDelivered: false,
                showMissedPrenatal: false,
                openTotalPregnancies() {
                    this.showTotalPregnancies = true;
                },
                openHighRisks() {
                    this.showHighRisks = true;
                },
                openDelivered() {
                    this.showDelivered = true;
                },
                openMissedPrenatal() {
                    this.showMissedPrenatal = true;
                },
            }
        }
    </script>
</x-layout>