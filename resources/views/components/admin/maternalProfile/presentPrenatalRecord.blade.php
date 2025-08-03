{{-- Present Maternal Record --}}
<div x-show="showMaternalRecord">
    <!-- Maternal Record Details Modal -->
    <div x-data="{ showModal: true, tt: ['TT1'], deliveries: 'N/A', risk: 'Low' }"
        class=" flex items-center justify-center">
        <div class="w-full  p-6 rounded-lg  relative  ">

            <!-- Details Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Medical & Pregnancy -->
                <div class="col-span-2 bg-white border border-blue-700 rounded-lg p-4 shadow">
                    <h3 class="text-lg font-semibold mb-4">Medical & Pregnancy Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">LMP</label>
                            <input type="date" class="mt-1 w-full border border-blue-700 rounded px-2 py-1"
                                value="2023-08-10">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">EDD</label>
                            <input type="date" class="mt-1 w-full border border-blue-700 rounded px-2 py-1"
                                value="2024-05-17">
                        </div>
                    </div>

                    <!-- OB Score -->
                    <div class="mt-4">
                        <label class="block font-medium mb-1">OB Score</label>
                        <div class="flex gap-2">
                            <template x-for="(label, index) in ['G', 'T', 'P', 'A', 'L']">
                                <div class="flex items-center gap-1">
                                    <span x-text="label + ':'"></span>
                                    <input type="number"
                                        class="w-12 border rounded px-1 py-1 text-center border-blue-700" value="0">
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- TT Status -->
                    <div class="mt-4">
                        <label class="block font-medium mb-1">TT/Td Status</label>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="ttLevel in ['TT1','TT2','TT3','TT4','TT5']">
                                <label class="flex items-center gap-1">
                                    <input type="checkbox" :value="ttLevel" x-model="tt">
                                    <span x-text="ttLevel"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <!-- Dropdowns -->
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block font-medium mb-1">Past Deliveries</label>
                            <select x-model="deliveries" class="w-full border rounded px-2 py-1 border-blue-700">
                                <option>N/A</option>
                                <option>Normal</option>
                                <option>CS</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">High-Risk Pregnancy</label>
                            <select x-model="risk" class="w-full border rounded px-2 py-1 border-blue-700">
                                <option>Low</option>
                                <option>Moderate</option>
                                <option>High</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Assessment -->
                <div class="bg-white border rounded-lg p-4 shadow border-blue-700">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-semibold">Recent Assessment</h3>
                        <button @click="viewAllPrenatalRecordBtn()"
                            class="  bg-blue-600 text-white py-2 px-3 cursor-pointer rounded hover:bg-blue-700 text-sm">View
                            All</button>
                    </div>
                    <template x-for="assessment in [
                    { date: '03/10/2024', type: 'Prenatal Visit', bp: '110/70', weight: '60kg' },
                    { date: '02/12/2024', type: 'Prenatal Visit', bp: '100/70', weight: '58kg' },
                    { date: '01/15/2024', type: 'Initial Check-up', bp: '100/60', weight: '55kg' }
                ]" :key="assessment.date">
                        <div class="border-t py-2 border-blue-700">
                            <div class="font-medium" x-text="assessment.date"></div>
                            <div class="text-sm" x-text="assessment.type"></div>
                            <div class="text-sm text-gray-600">BP: <span x-text="assessment.bp"></span>,
                                Weight:
                                <span x-text="assessment.weight"></span>
                            </div>
                        </div>
                    </template>
                    <button @click="showAddPrenatalRecordModalBtn()"
                        class="w-full bg-blue-600 text-white mt-4 py-2 rounded hover:bg-blue-700 text-sm cursor-pointer">+
                        Add New Record</button>
                </div>
            </div>
            <div class=" flex gap-2 flex-col">
                <h3 class="text-lg font-semibold my-2">Next Prenatal Schedule</h3>
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