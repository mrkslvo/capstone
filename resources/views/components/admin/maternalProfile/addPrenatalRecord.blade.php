{{-- ADD NEW PRENATAL RECORD --}}
<div x-show="showAddPrenatalRecordModal">
    <div x-show="showAddPrenatalRecordModal" x-cloak
        class=" fixed top-0 left-0 w-full h-full bg-black/40 flex items-center justify-center">

        <div x-show="showAddPrenatalRecordModal" x-cloak x-transition
            class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md space-y-6">
            <!-- Header -->
            <div class="border-b pb-4">
                <div class=" flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Add New Prenatal Record</h1>

                    <button @click="showAddPrenatalRecordModal = false"
                        class="text-2xl text-gray-500 hover:text-black cursor-pointer">&times;</button>
                </div>
                <p class="text-sm text-gray-500 mt-1">Record new prenatal assessment details for
                    <span class="font-semibold text-gray-700">Mario Dela Cruz</span>
                </p>

            </div>

            <!-- Form -->
            <form class="space-y-6">
                <!-- Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date"
                        class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Weight & Blood Pressure -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Weight
                            (kg)</label>
                        <input type="number" min="0"
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Blood
                            Pressure
                            (mmHg)</label>
                        <input type="text"
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Heart Rate & Fetal Heart Rate -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Heart Rate
                            (bpm)</label>
                        <input type="number" min="0"
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fetal Heart
                            Rate
                            (bpm)</label>
                        <input type="number" min="0"
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Fundal Height & Fetal Position -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fundal
                            Height
                            (cm)</label>
                        <input type="number" min="0"
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fetal
                            Position</label>
                        <input type="text"
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Swelling & Nutritional Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Swelling</label>
                        <input type="text"
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nutritional
                            Status</label>
                        <input type="text"
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Submit Button (optional) -->
                <div class="pt-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">Save
                        Record</button>
                </div>
            </form>
        </div>
    </div>
</div>