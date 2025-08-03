<x-layout>
    <div x-data="reports() " x-cloak x-init="init()" class="flex h-screen bg-blue-50">

        <x-bnsSidebar />
        <!-- Main Content -->
        <div class="flex-1 p-3 overflow-auto relative">
            <div class="space-y-3 flex flex-col h-full">
                <x-header>Reports</x-header>
                <div class=" p-4 h-screen bg-white rounded shadow scrollable relative">
                    <div
                        class="w-full absolute top-0 left-0 h-full bg-white text-gray-800 rounded-lg shadow-xl p-6 z-50 ">

                        <!-- Header -->
                        <div class="w-full flex items-center justify-between border-b border-blue-700 pb-4 px-4">
                            <!-- Tabs -->
                            <div class="space-x-2">
                                <button @click="openGrowthReports()" :class="growthReports
        ? 'bg-blue-700 text-white'
        : 'bg-blue-100 text-blue-800 hover:bg-blue-700 hover:text-white cursor-pointer'"
                                    class="px-4 py-2 rounded-md font-semibold transition">
                                    Growth Reports
                                </button>
                            </div>
                        </div>

                        {{-- GROWTH REPORTS --}}
                        <div x-show="growthReports">
                            <div class="bg-white p-4 rounded-lg ">

                                <!-- Overall Reports -->
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                                    <!-- Total Measured -->
                                    <div
                                        class="bg-sky-200 p-4 rounded-lg shadow text-sky-900 cursor-pointer hover:bg-sky-300 transition">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h2 class="text-sm">Total Measured</h2>
                                                <p class="text-2xl font-bold">5,678</p>
                                            </div>
                                            <span class="text-xl">📏</span>
                                        </div>
                                    </div>

                                    <!-- Normal -->
                                    <div
                                        class="bg-green-200 p-4 rounded-lg shadow text-green-900 cursor-pointer hover:bg-green-300 transition">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h2 class="text-sm">Normal</h2>
                                                <p class="text-2xl font-bold">5,678</p>
                                            </div>
                                            <span class="text-xl">✅</span>
                                        </div>
                                    </div>

                                    <!-- Underweight -->
                                    <div
                                        class="bg-yellow-200 p-4 rounded-lg shadow text-yellow-900 cursor-pointer hover:bg-yellow-300 transition">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h2 class="text-sm">Underweight</h2>
                                                <p class="text-2xl font-bold">9,101</p>
                                            </div>
                                            <span class="text-xl">📉</span>
                                        </div>
                                    </div>

                                    <!-- Overweight -->
                                    <div
                                        class="bg-red-200 p-4 rounded-lg shadow text-red-900 cursor-pointer hover:bg-red-300 transition">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h2 class="text-sm">Overweight</h2>
                                                <p class="text-2xl font-bold">9,101</p>
                                            </div>
                                            <span class="text-xl">📈</span>
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
                                                <th class="px-4 py-2 ">total children</th>
                                                <th class="px-4 py-2 ">normal</th>
                                                <th class="px-4 py-2 ">underweight</th>
                                                <th class="px-4 py-2 ">overweight</th>
                                                <th class="px-4 py-2 ">missed immunized</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="report in reports" :key="report.name">
                                                <tr>
                                                    <td class="px-4 py-2 border-b border-blue-200" x-text="report.name">
                                                    </td>
                                                    <td class="px-4 py-2 border-b border-blue-200"
                                                        x-text="report.maternal"></td>
                                                    <td class="px-4 py-2 border-b border-blue-200"
                                                        x-text="report.immunization"></td>
                                                    <td class="px-4 py-2 border-b border-blue-200"
                                                        x-text="report.moderate"></td>
                                                    <td class="px-4 py-2 border-b border-blue-200"
                                                        x-text="report.growth"></td>
                                                    <td class="px-4 py-2 border-b border-blue-200"
                                                        x-text="report.growth"></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Total Pregnancies --}}
                        <div x-show="showTotalPregnancies" x-cloak>
                            <div
                                class=" fixed flex items-center justify-center top-0 z-20 left-0 w-full h-full bg-black/40">
                                <div class=" bg-white max-w-[80%] rounded-xl p-6 h-[90%]" x-cloak x-transition>
                                    <div class=" flex items-center justify-between">
                                        <h1 class=" text-2xl my-2">Total Pregnancies</h1>
                                        <button @click="showTotalPregnancies = false"
                                            class="text-2xl text-gray-500 hover:text-black cursor-pointer">&times;</button>
                                    </div>

                                    <div class="mb-4 flex gap-2 items-center">
                                        <input x-model="search" type="text" placeholder="Search..."
                                            class="w-1/3 border border-gray-300 rounded px-3 py-2" />

                                        <select x-model="filterAddress"
                                            class="px-4 py-2 border border-gray-300 rounded-lg">
                                            <option value="">Filter by Purok</option>
                                            <template x-model="filterAddress">
                                                <option x-text="profile" :value="profile"></option>
                                            </template>
                                        </select>
                                    </div>

                                    <!-- Table -->
                                    <div class="bg-white rounded-lg flex-1 ">
                                        <div class="container mx-auto">
                                            <div class="rounded  border-gray-200 scrollable">
                                                <!-- Sticky Header -->
                                                <table class="table">
                                                    <thead class="sticky top-0 z-10">
                                                        <tr class="table-head">
                                                            <th class="p-3">Name</th>
                                                            <th class="p-3">Purok </th>
                                                            <th class="p-3">Age</th>
                                                            <th class="p-3">Last Menstrual Period</th>
                                                            <th class="p-3">Est. Due Date</th>
                                                            <th class="p-3">Risk Factor</th>
                                                            <th class="p-3">Status</th>
                                                        </tr>
                                                    </thead>
                                                </table>

                                                <div class="overflow-y-auto max-h-[60vh]">
                                                    <table class="table">
                                                        <tbody class=" overflow-y-auto">
                                                            <template x-for="assessment in [
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '01/15/2024', type: 'Initial Check-up', bp: '100/60', weight: '55kg'}
                ]" :key="assessment">
                                                                <tr class="table-body">
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- showHighRisks --}}
                        <div x-show="showHighRisks" x-cloak>
                            <div
                                class=" fixed flex items-center justify-center top-0 z-20 left-0 w-full h-full bg-black/40">
                                <div class=" bg-white max-w-[80%] rounded-xl p-6 h-[90%]" x-cloak x-transition>
                                    <div class=" flex items-center justify-between">
                                        <h1 class=" text-2xl my-2">High Risks</h1>
                                        <button @click="showHighRisks = false"
                                            class="text-2xl text-gray-500 hover:text-black cursor-pointer">&times;</button>
                                    </div>

                                    <div class="mb-4 flex gap-2 items-center">
                                        <input x-model="search" type="text" placeholder="Search..."
                                            class="w-1/3 border border-gray-300 rounded px-3 py-2" />

                                        <select x-model="filterAddress"
                                            class="px-4 py-2 border border-gray-300 rounded-lg">
                                            <option value="">Filter by Purok</option>
                                            <template x-model="filterAddress">
                                                <option x-text="profile" :value="profile"></option>
                                            </template>
                                        </select>
                                    </div>

                                    <!-- Table -->
                                    <div class="bg-white rounded-lg flex-1 ">
                                        <div class="container mx-auto">
                                            <div class="rounded  border-gray-200 scrollable">
                                                <!-- Sticky Header -->
                                                <table class="table">
                                                    <thead class="sticky top-0 z-10">
                                                        <tr class="table-head">
                                                            <th class="p-3">Name</th>
                                                            <th class="p-3">Purok </th>
                                                            <th class="p-3">Age</th>
                                                            <th class="p-3">Last Menstrual Period</th>
                                                            <th class="p-3">Est. Due Date</th>
                                                            <th class="p-3">Risk Factor</th>
                                                            <th class="p-3">Status</th>
                                                        </tr>
                                                    </thead>
                                                </table>

                                                <div class="overflow-y-auto max-h-[60vh]">
                                                    <table class="table">
                                                        <tbody class=" overflow-y-auto">
                                                            <template x-for="assessment in [
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '01/15/2024', type: 'Initial Check-up', bp: '100/60', weight: '55kg'}
                ]" :key="assessment">
                                                                <tr class="table-body">
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- showDelivered --}}
                        <div x-show="showDelivered" x-cloak>
                            <div
                                class=" fixed flex items-center justify-center top-0 z-20 left-0 w-full h-full bg-black/40">
                                <div class=" bg-white max-w-[80%] rounded-xl p-6 h-[90%]" x-cloak x-transition>
                                    <div class=" flex items-center justify-between">
                                        <h1 class=" text-2xl my-2">Delivered</h1>
                                        <button @click="showDelivered = false"
                                            class="text-2xl text-gray-500 hover:text-black cursor-pointer">&times;</button>
                                    </div>
                                    <div class="mb-4 flex gap-2 items-center">
                                        <input x-model="search" type="text" placeholder="Search..."
                                            class="w-1/3 border border-gray-300 rounded px-3 py-2" />

                                        <select x-model="filterAddress"
                                            class="px-4 py-2 border border-gray-300 rounded-lg">
                                            <option value="">Filter by Purok</option>
                                            <template x-model="filterAddress">
                                                <option x-text="profile" :value="profile"></option>
                                            </template>
                                        </select>
                                    </div>

                                    <!-- Table -->
                                    <div class="bg-white rounded-lg flex-1 ">
                                        <div class="container mx-auto">
                                            <div class="rounded  border-gray-200 scrollable">
                                                <!-- Sticky Header -->
                                                <table class="table">
                                                    <thead class="sticky top-0 z-10">
                                                        <tr class="table-head">
                                                            <th class="p-3">Name</th>
                                                            <th class="p-3">Purok </th>
                                                            <th class="p-3">Age</th>
                                                            <th class="p-3">Last Menstrual Period</th>
                                                            <th class="p-3">Est. Due Date</th>
                                                            <th class="p-3">Risk Factor</th>
                                                            <th class="p-3">Status</th>
                                                        </tr>
                                                    </thead>
                                                </table>

                                                <div class="overflow-y-auto max-h-[60vh]">
                                                    <table class="table">
                                                        <tbody class=" overflow-y-auto">
                                                            <template x-for="assessment in [
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '01/15/2024', type: 'Initial Check-up', bp: '100/60', weight: '55kg'}
                ]" :key="assessment">
                                                                <tr class="table-body">
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- showMissedPrenatal --}}
                        <div x-show="showMissedPrenatal" x-cloak>
                            <div
                                class=" fixed flex items-center justify-center top-0 z-20 left-0 w-full h-full bg-black/40">
                                <div class=" bg-white max-w-[80%] rounded-xl p-6 h-[90%]" x-cloak x-transition>
                                    <div class=" flex items-center justify-between">
                                        <h1 class=" text-2xl my-2">Missed Prenatal</h1>
                                        <button @click="showMissedPrenatal = false"
                                            class="text-2xl text-gray-500 hover:text-black cursor-pointer">&times;</button>
                                    </div>
                                    <div class="mb-4 flex gap-2 items-center">
                                        <input x-model="search" type="text" placeholder="Search..."
                                            class="w-1/3 border border-gray-300 rounded px-3 py-2" />

                                        <select x-model="filterAddress"
                                            class="px-4 py-2 border border-gray-300 rounded-lg">
                                            <option value="">Filter by Purok</option>
                                            <template x-model="filterAddress">
                                                <option x-text="profile" :value="profile"></option>
                                            </template>
                                        </select>
                                    </div>

                                    <!-- Table -->
                                    <div class="bg-white rounded-lg flex-1 ">
                                        <div class="container mx-auto">
                                            <div class="rounded  border-gray-200 scrollable">
                                                <!-- Sticky Header -->
                                                <table class="table">
                                                    <thead class="sticky top-0 z-10">
                                                        <tr class="table-head">
                                                            <th class="p-3">Name</th>
                                                            <th class="p-3">Purok </th>
                                                            <th class="p-3">Age</th>
                                                            <th class="p-3">Last Menstrual Period</th>
                                                            <th class="p-3">Est. Due Date</th>
                                                            <th class="p-3">Risk Factor</th>
                                                            <th class="p-3">Status</th>
                                                        </tr>
                                                    </thead>
                                                </table>

                                                <div class="overflow-y-auto max-h-[60vh]">
                                                    <table class="table">
                                                        <tbody class=" overflow-y-auto">
                                                            <template x-for="assessment in [
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '01/15/2024', type: 'Initial Check-up', bp: '100/60', weight: '55kg'}
                ]" :key="assessment">
                                                                <tr class="table-body">
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                    <td class="p-3" x-text="assessment.date"></td>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        function reports() {
            return {
                growthReports: true,
                reports: [
                    { name: 'Purok 1', maternal: 120, immunization: 450, moderate: 300, growth: 890, status: 100 },
                    { name: 'Purok 2', maternal: 98, immunization: 380, moderate: 300, growth: 750, status: 56 },
                    { name: 'Purok 3', maternal: 150, immunization: 510, moderate: 300, growth: 920, status: 20 },
                    { name: 'Purok 4', maternal: 75, immunization: 320, moderate: 300, growth: 650, status: 48 },
                    { name: 'Purok 5', maternal: 210, immunization: 600, moderate: 300, growth: 1100, status: 31 },
                ],

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
