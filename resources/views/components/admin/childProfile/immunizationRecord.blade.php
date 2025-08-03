{{-- Immunization Record --}}
<div x-show="showImmunizationRecord">
    <!-- Immunization and Recent Visits -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
        <!-- Immunization Details -->
        <div class="border border-blue-700 rounded-lg p-6 md:col-span-2">
            <h3 class="font-semibold mb-4">Immunization Details</h3>

            <div class="mb-4">
                <p class="font-medium mb-1">Vaccination Status</p>
                <div class="flex flex-wrap gap-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked class="accent-blue-600" /> BCG
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked class="accent-blue-600" /> Hep B
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" class="accent-blue-600" /> Penta
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" class="accent-blue-600" /> OPV
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" class="accent-blue-600" /> IPV
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Past Vaccine Reactions</label>
                    <select class="w-full border border-gray-300 rounded px-3 py-2">
                        <option selected>None</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Current Health Status</label>
                    <select class="w-full border border-gray-300 rounded px-3 py-2">
                        <option selected>Good</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Recent Visits -->
        <div class="border border-blue-700 rounded-lg p-6">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold">Recent Visits</h3>
                <button @click="showAllImmunizationRecords()"
                    class="  bg-blue-600 text-white py-2 px-3 cursor-pointer rounded hover:bg-blue-700 text-sm">View
                    All</button>
            </div>

            <div class="space-y-3 text-sm">
                <div class="border-b border-blue-700 pb-2">
                    <p class="font-medium">03/10/2024</p>
                    <p>BCG Vaccine</p>
                    <p class="text-gray-500 text-xs">Weight: 5.5kg | Height: 58cm</p>
                </div>
                <div class="border-b border-blue-700 pb-2">
                    <p class="font-medium">02/12/2024</p>
                    <p>Hepatitis B Vaccine</p>
                    <p class="text-gray-500 text-xs">Weight: 5.0kg | Height: 55cm</p>
                </div>
                <div>
                    <p class="font-medium">01/15/2024</p>
                    <p>Initial Check-up</p>
                    <p class="text-gray-500 text-xs">Weight: 4.5kg | Height: 52cm</p>
                </div>
            </div>

            <div class="mt-4">
                <button @click="showAddImmunizationRecord = true"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded flex justify-center items-center gap-2">
                    Add New Record
                </button>
            </div>
        </div>

        {{-- Next Immunization Schedule --}}
        <div class=" flex gap-2 flex-col col-span-3">
            <h3 class="text-lg font-semibold my-2">Next Immunization Schedule</h3>
            <div class="flex items-center mb-4 w-full">
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