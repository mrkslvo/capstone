{{-- GROWTH REPORTS --}}
<div x-show="growthReports">
    <div class="bg-white p-4 rounded-lg ">

        <!-- Overall Reports -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

            <!-- Total Measured -->
            <div class="bg-sky-200 p-4 rounded-lg shadow text-sky-900 cursor-pointer hover:bg-sky-300 transition">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-sm">Total Measured</h2>
                        <p class="text-2xl font-bold">5,678</p>
                    </div>
                    <span class="text-xl">📏</span>
                </div>
            </div>

            <!-- Normal -->
            <div class="bg-green-200 p-4 rounded-lg shadow text-green-900 cursor-pointer hover:bg-green-300 transition">
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
            <div class="bg-red-200 p-4 rounded-lg shadow text-red-900 cursor-pointer hover:bg-red-300 transition">
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
                            <td class="px-4 py-2 border-b border-blue-200" x-text="report.maternal"></td>
                            <td class="px-4 py-2 border-b border-blue-200" x-text="report.immunization"></td>
                            <td class="px-4 py-2 border-b border-blue-200" x-text="report.moderate"></td>
                            <td class="px-4 py-2 border-b border-blue-200" x-text="report.growth"></td>
                            <td class="px-4 py-2 border-b border-blue-200" x-text="report.growth"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>