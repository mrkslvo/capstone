{{-- ADD GROWTH RECORD --}}
<div x-show="showAddGrowthRecord">
    <div x-show="showAddGrowthRecord" x-cloak
        class=" fixed top-0 left-0 w-full h-full bg-black/40 flex items-center justify-center">

        <div x-show="showAddGrowthRecord" x-cloak x-transition
            class="w-2/5  mx-auto p-6 bg-white rounded-lg shadow-md space-y-6">
            <!-- Header -->
            <div class="border-b border-blue-700 pb-4">
                <div class=" flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Add new Growth Record</h1>

                    <button @click="showAddGrowthRecord = false"
                        class="text-2xl text-gray-500 hover:text-black cursor-pointer">&times;</button>
                </div>
                <p class="text-sm text-gray-500 mt-1">Record new prenatal assessment details for
                    <span class="font-semibold text-gray-700">Mario Dela Cruz</span>
                </p>

            </div>

            <!-- Form -->
            <form class="space-y-6">

                <!-- Date & Age in Months -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date"
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Age in
                            Months</label>
                        <input type="number" min="0"
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Weight, Height, BMI -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Weight
                            (kg)</label>
                        <input type="number" min="0" step="any"
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Height
                            (cm)</label>
                        <input type="number" min="0" step="any"
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">BMI</label>
                        <input type="number" min="0" step="any"
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Supplements Given -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Supplements
                        Given</label>
                    <input type="text"
                        class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Assessment -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Assessment</label>
                    <input type="text"
                        class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <input type="text"
                        class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Submit Button -->
                <div class="pt-4 flex items-center justify-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">
                        Save Record
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>