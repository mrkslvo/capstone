{{-- showMissedPrenatal --}}
<div x-show="showMissedPrenatal" x-cloak>
    <div class=" fixed flex items-center justify-center top-0 z-20 left-0 w-full h-full bg-black/40">
        <div class=" bg-white max-w-[80%] rounded-xl p-6 h-[90%]" x-cloak x-transition>
            <div class=" flex items-center justify-between">
                <h1 class=" text-2xl my-2">Missed Prenatal</h1>
                <button @click="showMissedPrenatal = false"
                    class="text-2xl text-gray-500 hover:text-black cursor-pointer">&times;</button>
            </div>
            <div class="mb-4 flex gap-2 items-center">
                <input x-model="search" type="text" placeholder="Search..."
                    class="w-1/3 border border-gray-300 rounded px-3 py-2" />

                <select x-model="filterAddress" class="px-4 py-2 border border-gray-300 rounded-lg">
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
