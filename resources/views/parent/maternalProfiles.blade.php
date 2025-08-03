<x-layout>
    <div x-data="maternalInformation()" x-cloak class="flex h-screen bg-blue-50">

        <x-parentSidebar />

        <!-- Main Content -->
        <div class="flex-1 p-3 overflow-auto relative">
            <div class="space-y-3 flex flex-col h-full">
                <x-header>Maternal Profile</x-header>
                <div class=" p-4 h-screen bg-white rounded shadow scrollable relative">

                    <div x-show="showMaternalPage"
                        class="w-full absolute top-0 left-0 h-full bg-white text-gray-800 rounded-lg shadow-xl p-6 z-50 ">

                        <!-- Header -->
                        <div class="w-full flex items-center justify-between border-b border-blue-700 pb-4 px-4">
                            <!-- Tabs -->
                            <div class="space-x-2">
                                <button @click="openMaternalProfile(); isSelected = 'maternalProfile'"
                                    :class="isBtnSelected('maternalProfile')"
                                    class="px-4 py-2 rounded-md font-semibold transition">
                                    Maternal Profile
                                </button>
                                <button @click="openMaternalRecord(); isSelected = 'maternalRecord'"
                                    :class="isBtnSelected('maternalRecord')"
                                    class="px-4 py-2 rounded-md font-semibold transition">
                                    Present Maternal Records
                                </button>
                                <button @click="openPastMaternalRecord(); isSelected = 'pastMaternalRecord'"
                                    :class="isBtnSelected('pastMaternalRecord')"
                                    class="px-4 py-2 rounded-md font-semibold transition">
                                    Past Maternal Records
                                </button>
                            </div>
                        </div>

                        <!-- Maternal Profile Info -->
                        <div x-show="showMaternalProfile">

                            <div class=" border-b border-blue-700 space-y-6 px-4 py-5">

                                <div>
                                    <h1 class=" text-2xl text-blue-900">Personal Information</h1>
                                </div>

                                <!-- Row 1 -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Full Name</span>
                                        <span class="text-base font-semibold" x-text="modalMaternalProfile.name"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Age</span>
                                        <span class="text-base font-semibold" x-text="modalMaternalProfile.age"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Birthdate</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.birthdate"></span>
                                    </div>
                                </div>

                                <!-- Row 2 -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Spouse's Name</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.spouse_name"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Civil Status</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.civil_status"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Classification</span>
                                        <span class="text-base font-semibold text-gray-600">—</span>
                                    </div>
                                </div>

                                <!-- Row 3 -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Address</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.address"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Blood Type</span>
                                        <span class="text-base font-semibold text-gray-600">—</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Contact No.</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.philhealth_no"></span>
                                    </div>

                                </div>
                            </div>

                            <div class=" border-b border-blue-700 space-y-6 px-4 py-5">

                                <div>
                                    <h1 class=" text-2xl text-blue-900">Identification and Eligibility</h1>
                                </div>

                                <!-- Row 4 -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">PhilHealth No.</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.philhealth_no"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Family Serial No.</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.family_serial_no"></span>
                                    </div>

                                </div>
                            </div>

                            <div class="space-y-6 px-4 py-5">

                                <div>
                                    <h1 class=" text-2xl text-blue-900">Account Credentials</h1>
                                </div>

                                <!-- Row 4 -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Username</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.philhealth_no"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Password</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.family_serial_no"></span>
                                    </div>

                                </div>
                            </div>


                        </div>

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
                                                    <input type="date"
                                                        class="mt-1 w-full border border-blue-700 rounded px-2 py-1"
                                                        value="2023-08-10">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium">EDD</label>
                                                    <input type="date"
                                                        class="mt-1 w-full border border-blue-700 rounded px-2 py-1"
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
                                                                class="w-12 border rounded px-1 py-1 text-center border-blue-700"
                                                                value="0">
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
                                                    <select x-model="deliveries"
                                                        class="w-full border rounded px-2 py-1 border-blue-700">
                                                        <option>N/A</option>
                                                        <option>Normal</option>
                                                        <option>CS</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block font-medium mb-1">High-Risk Pregnancy</label>
                                                    <select x-model="risk"
                                                        class="w-full border rounded px-2 py-1 border-blue-700">
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
                                                    <div class="text-sm text-gray-600">BP: <span
                                                            x-text="assessment.bp"></span>,
                                                        Weight:
                                                        <span x-text="assessment.weight"></span>
                                                    </div>
                                                </div>
                                            </template>

                                        </div>
                                    </div>
                                    <div class=" flex gap-2 flex-col">
                                        <h3 class="text-lg font-semibold my-2">Next Growth Schedule</h3>
                                        <div class="flex items-center w-full">
                                            <div class=" flex items-center justify-between gap-2 w-full">
                                                <div class=" flex items-center gap-2">

                                                    <div>
                                                        <label>Date</label>
                                                        <input type="date" name="date" :min="minDate"
                                                            class="border rounded w-full p-2" />
                                                    </div>

                                                    <div>
                                                        <label>Time</label>
                                                        <input type="time" name="time"
                                                            class="border rounded w-full p-2" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Past Maternal Record --}}
                        <div x-show="showPastMaternalRecord">
                            <!-- Right Panel: Prenatal Records -->
                            <div>
                                <div class="my-4">
                                    <h3 class="text-lg font-semibold flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.4 0-8-3.6-8-8s3.6-8 8-8 8 3.6 8 8-3.6 8-8 8zm1-13h-2v6h6v-2h-4z" />
                                        </svg>
                                        Previous Prenatal Records
                                    </h3>
                                </div>

                                <!-- Sample Static Records (You can loop dynamic ones later) -->
                                <div class="text-sm text-gray-700 grid grid-cols-3 gap-3">
                                    <div class="bg-gray-100 p-4 rounded-lg flex items-center gap-3">
                                        <div><img src="/storage/assets/file.png" alt=""></div>
                                        <div>
                                            <p class="font-semibold">Prenatal Record 1: July 15, 2023</p>

                                        </div>
                                    </div>
                                    <div class="bg-gray-100 p-4 rounded-lg flex items-center gap-3">
                                        <div><img src="/storage/assets/file.png" alt=""></div>
                                        <div>
                                            <p class="font-semibold">Prenatal Record 2: July 15, 2023</p>

                                        </div>
                                    </div>
                                    <div class="bg-gray-100 p-4 rounded-lg flex items-center gap-3">
                                        <div><img src="/storage/assets/file.png" alt=""></div>
                                        <div>
                                            <p class="font-semibold">Prenatal Record 3: July 15, 2023</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- View All Prenatal Record --}}
                        <div x-show="viewAllPrenatalRecord">

                            <div class=" bg-white">
                                <div>
                                    <h1 class=" text-2xl my-2">All Prenatal Record</h1>
                                    <h3 class=" text-gray-500">Patient: Maria Dela Cruz</h3>
                                </div>

                                <!-- Table -->
                                <div class="bg-white rounded-lg flex-1 ">
                                    <div class="container mx-auto">
                                        <div class="rounded  border-gray-200 scrollable">
                                            <!-- Sticky Header -->
                                            <table class="table">
                                                <thead class="sticky top-0 z-10">
                                                    <tr class="table-head">
                                                        <th class="p-3">Date</th>
                                                        <th class="p-3">Weight(KG)</th>
                                                        <th class="p-3">BP(MMHG)</th>
                                                        <th class="p-3">FHR(BPM)</th>
                                                        <th class="p-3">FUNDAL HEIGHT(CM)</th>
                                                        <th class="p-3">FETAL POSITION</th>
                                                        <th class="p-3">SWELLING</th>
                                                        <th class="p-3">NUTRITIONAL STATUS</th>
                                                        <th class="p-3">RISK ASSESSMENT</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                            <div class="overflow-y-auto max-h-[50vh]">
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

        <script>
            function maternalInformation() {
                return {
                    // Visibility States
                    showMaternalPage: true,
                    hideMaternalprofile: true,

                    showMaternalProfile: true,
                    showMaternalRecord: false,
                    showPastMaternalRecord: false,
                    viewAllPrenatalRecord: false,

                    // Helper to reset maternal views
                    resetMaternalViews() {
                        this.showMaternalProfile = false;
                        this.showMaternalRecord = false;
                        this.showPastMaternalRecord = false;
                        this.viewAllPrenatalRecord = false;
                    },

                    // View Setters
                    openMaternalProfile() {
                        this.resetMaternalViews();
                        this.showMaternalProfile = true;
                        this.hideMaternalprofile = false;
                    },

                    openMaternalRecord() {
                        this.resetMaternalViews();
                        this.showMaternalRecord = true;
                    },

                    openPastMaternalRecord() {
                        this.resetMaternalViews();
                        this.showPastMaternalRecord = true;
                    },

                    viewAllPrenatalRecordBtn() {
                        this.resetMaternalViews();
                        this.viewAllPrenatalRecord = true;
                    },

                    isSelected: 'maternalProfile',
                    isBtnSelected(btn) {
                        return this.isSelected === btn ? 'bg-blue-700 text-white' : 'bg-blue-100 text-blue-800 hover:bg-blue-700 hover:text-white cursor-pointer';
                    },

                    maternalProfiles: @json($maternalProfiles),
                    viewMaternalProfile(profile) {
                        this.modalMaternalProfile = profile;
                        this.showMaternalModal = true;
                    },
                };
            }
        </script>
</x-layout>
