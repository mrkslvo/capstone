{{-- GROWTH RECORDS --}}
<div x-show="showGrowthRecord">
    <!-- Growth Monitoring Modal -->
    <div x-data="growthMonitoring()" x-show="growthModal" x-init="init()">
        <div class=" p-6">

            <div class="flex w-full flex-col lg:flex-row space-y-6 lg:space-y-0 lg:space-x-6">
                <!-- Left Panel -->
                <div class="w-full">

                    <!-- Chart Tabs -->
                    <div class="flex gap-2 mb-3">
                        <button @click="setChartType('weight')" :class="tabClass('weight')">Weight</button>
                        <button @click="setChartType('height')" :class="tabClass('height')">Height</button>
                        <button @click="setChartType('bmi')" :class="tabClass('bmi')">BMI</button>
                    </div>

                    <!-- Chart -->
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <canvas id="growthChart" height="125"></canvas>
                    </div>
                </div>

                <!-- Right Panel: Records -->
                <div class=" w-[40%]">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Recent Records</h3>
                        <button @click="showAllGrowthRecords()"
                            class="  bg-blue-600 text-white py-2 px-3 cursor-pointer rounded hover:bg-blue-700 text-sm">View
                            All</button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="record in records" :key="record.date">
                            <div class="flex items-start space-x-3">
                                <div class="bg-blue-200 p-2 rounded-md">
                                    <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M10 4H2v16h20V6H12l-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-sm" x-text="record.date"></p>
                                    <p class="text-gray-600 text-sm" x-text="record.details">
                                    </p>
                                </div>
                            </div>
                        </template>
                    </div>
                    <button @click="showAddGrowthRecord = true"
                        class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg flex items-center justify-center gap-2">
                        Add New Record
                    </button>
                </div>
            </div>


            {{-- Next Immunization Schedule --}}
            <div class=" flex gap-2 flex-col col-span-3">
                <h3 class="text-lg font-semibold my-2">Next Growth Schedule</h3>
                <div class="flex items-center w-full">
                    <div class=" flex items-center justify-between gap-2 w-full">
                        <div class=" flex items-center gap-2">

                            <div>
                                <label>Date</label>
                                <input type="date" name="date" :min="minDate" class="border rounded w-full p-2" />
                            </div>

                            <div>
                                <label>Time</label>
                                <input type="time" name="time" class="border rounded w-full p-2" />
                            </div>
                        </div>

                        <div>
                            <button
                                class="w-full bg-green-600 text-white py-2 px-4 font-bold rounded hover:bg-green-600/80 text-sm cursor-pointer">Complete</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>