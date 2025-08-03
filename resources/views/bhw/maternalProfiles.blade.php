<x-layout>
    <title>Maternal Profiles</title>
    <div x-data="maternalInformation()" x-cloak class="flex h-screen bg-blue-50">
        <x-bhwSidebar />

        <!-- Main Content -->
        <div class="flex-1 p-4 overflow-auto relative">
            <div class="space-y-2 flex flex-col h-full">
                <x-header>Maternal Profiles</x-header>
                <div class=" p-4 h-screen bg-white rounded shadow scrollable relative">
                    <div x-show="hideMaternalprofile" class="flex items-center justify-between mb-4">
                        <div class=" flex items-center gap-2">
                            <input type="text" x-model="search" class="px-4 py-2 border border-gray-300 rounded-lg"
                                placeholder="Search...">
                            <select class="px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">Filter by Address</option>
                                <template>
                                    <option>sample</option>
                                </template>
                            </select>
                            <select class="px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">Filter by Age</option>
                                <template>
                                    <option>sample</option>
                                </template>
                            </select>
                        </div>
                        <button @click="openAddModal()"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg cursor-pointer">+ Register</button>
                    </div>
                    <table class="table">
                        <thead>
                            <tr class="table-head">
                                <th class="p-3">Name</th>
                                <th class="p-3">Age</th>
                                <th class="p-3">Birthday</th>
                                <th class="p-3">Address</th>
                                <th class="p-3">Spouse</th>
                                <th class="p-3">Contact No.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="maternalProfile in paginatedMaternalProfiles" :key="maternalProfile.id">
                                <tr class="table-body"
                                    @click=" openMaternalPage(maternalProfile); hideFilters = false, openMaternalProfile() ">
                                    <td class="p-3" x-text="maternalProfile.name"></td>
                                    <td class="p-3" x-text="maternalProfile.age"></td>
                                    <td class="p-3" x-text="maternalProfile.birthdate"></td>
                                    <td class="p-3" x-text="maternalProfile.address"></td>
                                    <td class="p-3" x-text="maternalProfile.spouse_name"></td>
                                    <td class="p-3" x-text="maternalProfile.contact_number">
                                    </td>
                                </tr>
                            </template>

                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="flex items-center justify-between p-4">
                        <div>
                            Page <span x-text="maternalCurrentPage"></span> of <span x-text="maternalTotalPages"></span>
                            |
                            Total: <span x-text="maternalTotal"></span>
                        </div>
                        <div class=" space-x-2">
                            <button @click="maternalPrevPage"
                                class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                                :disabled="maternalCurrentPage === 1">Previous</button>
                            <button @click="maternalNextPage"
                                class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                                :disabled="maternalCurrentPage === maternalTotalPages">Next</button>
                        </div>
                    </div>


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

                            <!-- Close Button -->
                            <button @click="showMaternalPage = false; hideMaternalprofile = true"
                                class="text-3xl text-gray-500 hover:text-gray-800 transition">&times;</button>
                        </div>

                        <!-- Maternal Profile Info -->
                        <div x-show="showMaternalProfile">
                            <div class=" border-b border-blue-700 space-y-6 px-4 py-5">
                                <div class=" flex items-center justify-between">
                                    <h1 class=" text-2xl text-blue-900">Personal Information</h1>
                                    <div class="flex items-center gap-2">
                                        <button @click.stop="openUpdateMaternalProfile(maternalProfileData)"
                                            class="text-white bg-blue-700 rounded hover:underline cursor-pointer py-1 px-3  flex items-center">Edit</button>
                                    </div>
                                </div>

                                <!-- Row 1 -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Full Name</span>
                                        <span class="text-base font-semibold" x-text="maternalProfileData.name"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Age</span>
                                        <span class="text-base font-semibold" x-text="maternalProfileData.age"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Birthdate</span>
                                        <span class="text-base font-semibold"
                                            x-text="maternalProfileData.birthdate"></span>
                                    </div>
                                </div>

                                <!-- Row 2 -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Spouse's Name</span>
                                        <span class="text-base font-semibold"
                                            x-text="maternalProfileData.spouse_name"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Civil Status</span>
                                        <span class="text-base font-semibold"
                                            x-text="maternalProfileData.civil_status"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Classification</span>
                                        <span class="text-base font-semibold text-gray-60 uppercase"
                                            x-text="maternalProfileData.nhts_status"></span>
                                    </div>
                                </div>

                                <!-- Row 3 -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Address</span>
                                        <span class="text-base font-semibold"
                                            x-text="maternalProfileData.address"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Blood Type</span>
                                        <span class="text-base font-semibold text-gray-600"
                                            x-text="maternalProfileData.blood_type"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Contact No.</span>
                                        <span class="text-base font-semibold"
                                            x-text="maternalProfileData.philhealth_no"></span>
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
                                            x-text="maternalProfileData.philhealth_no"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Family Serial No.</span>
                                        <span class="text-base font-semibold"
                                            x-text="maternalProfileData.family_serial_no"></span>
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
                                            x-text="maternalProfileData.philhealth_no"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Password</span>
                                        <span class="text-base font-semibold"
                                            x-text="maternalProfileData.family_serial_no"></span>
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
                                                        <input type="date" name="date" :min="minDate"
                                                            class="border rounded w-full p-2" />
                                                    </div>

                                                    <div>
                                                        <label>Time</label>
                                                        <input type="time" name="time"
                                                            class="border rounded w-full p-2" />
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
                                    <h3 class=" text-green-500 text-xl">Patient: Maria Dela Cruz</h3>
                                </div>

                                <!-- Table -->
                                <div class="bg-white rounded-lg flex-1">
                                    <div class="container mx-auto">
                                        <div class="rounded border-gray-200">
                                            <!-- Sticky Header -->
                                            <table class="table w-full">
                                                <thead class="sticky top-0 z-10 bg-white">
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

                                            <!-- Scrollable Table Body -->
                                            <div class="overflow-y-auto max-h-[50vh]">
                                                <table class="table w-full">
                                                    <tbody>
                                                        <template x-for="assessment in paginatedAssessments"
                                                            :key="assessment.id">
                                                            <tr class="table-body">
                                                                <td class="p-3" x-text="assessment.date"></td>
                                                                <td class="p-3" x-text="assessment.weight"></td>
                                                                <td class="p-3" x-text="assessment.bp"></td>
                                                                <td class="p-3" x-text="assessment.fhr"></td>
                                                                <td class="p-3" x-text="assessment.fundal"></td>
                                                                <td class="p-3" x-text="assessment.position"></td>
                                                                <td class="p-3" x-text="assessment.swelling"></td>
                                                                <td class="p-3" x-text="assessment.nutrition"></td>
                                                                <td class="p-3" x-text="assessment.risk"></td>
                                                                <td class="p-3">
                                                                    <span
                                                                        class="px-2 py-1 text-xs font-semibold rounded"
                                                                        :class="statusColors[assessment.risk]">
                                                                        <span x-text="assessment.risk"
                                                                            class=" capitalize"></span>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </div>


                                            <!-- Pagination -->
                                            <div class="flex justify-between items-center p-4">
                                                <div>
                                                    Page <span x-text="assessmentCurrentPage"></span> of <span
                                                        x-text="assessmentTotalPages"></span> |
                                                    Total: <span x-text="assessmentTotal"></span>
                                                </div>
                                                <div class=" space-x-2">
                                                    <button @click="assessmentPrevPage"
                                                        class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                                                        :disabled="assessmentCurrentPage === 1">Previous</button>
                                                    <button @click="assessmentNextPage"
                                                        class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                                                        :disabled="assessmentCurrentPage === assessmentTotalPages">Next</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

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
                                                <label
                                                    class="block text-sm font-medium text-gray-700 mb-1">Swelling</label>
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

                    </div>

                    <!-- View Maternal Profile Modal -->
                    <div x-show="showMaternalModal" x-cloak
                        class="fixed inset-0 h-full bg-black/40 flex items-center justify-center z-50">
                        <div x-show="showMaternalModal" x-transition
                            class="bg-white rounded-xl shadow-xl max-w-5xl w-full p-8">
                            <!-- Header -->
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl font-semibold">Maternal Information</h2>
                                <button @click="showMaternalModal = false"
                                    class="text-2xl text-gray-500 hover:text-black cursor-pointer">&times;</button>
                            </div>

                            <p class="text-sm text-gray-500 mb-6">
                                Detailed profile of <span x-text="modalMaternalProfile.name"></span>
                            </p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Left Panel: Personal Information -->
                                <div>
                                    <!-- Personal Details -->
                                    <div class="mb-4">
                                        <h3 class="text-lg font-semibold flex items-center gap-2">
                                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                                            </svg>
                                            Personal Details
                                        </h3>
                                    </div>

                                    <div class="grid grid-cols-2 gap-y-3 text-sm text-gray-700 ">

                                        <div class=" flex flex-col gap-2">
                                            <p><span class="font-semibold">Full Name:</span> <span
                                                    x-text="modalMaternalProfile.name"></span></p>
                                            <p><span class="font-semibold">Age:</span> <span
                                                    x-text="modalMaternalProfile.age"></span></p>
                                            <p><span class="font-semibold">Spouse's Name:</span> <span
                                                    x-text="modalMaternalProfile.spouse_name"></span></p>
                                            <p><span class="font-semibold">Birthdate:</span> <span
                                                    x-text="modalMaternalProfile.birthdate"></span></p>
                                        </div>
                                        <div class=" flex flex-col gap-2">
                                            <p><span class="font-semibold">Civil Status:</span> <span
                                                    x-text="modalMaternalProfile.civil_status"></span></p>
                                            <p class="flex items-center gap-1">
                                                <span class="font-semibold">NHTS:</span>
                                                <span
                                                    class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs font-bold"
                                                    x-text="modalMaternalProfile.nhts_status"></span>
                                            </p>

                                            <p class="col-span-2"><span class="font-semibold">Address:</span> <span
                                                    x-text="modalMaternalProfile.address"></span></p>
                                            <p class="flex items-center gap-1">
                                                <span class="font-semibold">Blood Type:</span>
                                                <span
                                                    class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs font-bold"
                                                    x-text="modalMaternalProfile.blood_type"></span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Identification & Eligibility -->
                                    <div class="border-t mt-6 pt-4 space-y-3">
                                        <h3 class="text-lg font-semibold flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2c-5.5 0-10 4.5-10 10s10 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.4 0-8-3.6-8-8s3.6-8 8-8 8 3.6 8 8-3.6 8-8 8z" />
                                            </svg>
                                            Identification & Eligibility
                                        </h3>
                                        <div class="grid grid-cols-2 gap-y-2 text-sm text-gray-700">
                                            <p><span class="font-semibold">Family Serial No.:</span> <span
                                                    x-text="modalMaternalProfile.family_serial_no"></span></p>
                                            <p><span class="font-semibold">PhilHealth No.:</span> <span
                                                    x-text="modalMaternalProfile.philhealth_no"></span></p>
                                        </div>
                                    </div>

                                    <!-- Account Credentials -->
                                    <div class="border-t mt-6 pt-4 space-y-3">
                                        <h3 class="text-lg font-semibold flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M5 4v3h5V4H5zm1 2V5h3v1H6zm7-2v3h6V4h-6zm1 2V5h4v1h-4zM5 9v3h5V9H5zm1 2v-1h3v1H6zm7-2v3h6V9h-6zm1 2v-1h4v1h-4zM5 14v3h5v-3H5zm1 2v-1h3v1H6zm7-2v3h6v-3h-6zm1 2v-1h4v1h-4z" />
                                            </svg>
                                            Account Credentials
                                        </h3>
                                        <div class="grid grid-cols-2 gap-y-2 text-sm text-gray-700">
                                            <p><span class="font-semibold">Username:</span></p>
                                            <p><span class="font-semibold">Password:</span></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Panel: Prenatal Records -->
                                <div>
                                    <div class="mb-4">
                                        <h3 class="text-lg font-semibold flex items-center gap-2">
                                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.4 0-8-3.6-8-8s3.6-8 8-8 8 3.6 8 8-3.6 8-8 8zm1-13h-2v6h6v-2h-4z" />
                                            </svg>
                                            Previous Prenatal Records
                                        </h3>
                                    </div>

                                    <!-- Sample Static Records (You can loop dynamic ones later) -->
                                    <div class="space-y-4 text-sm text-gray-700">
                                        <div class="bg-gray-100 p-4 rounded-lg">
                                            <p class="font-semibold">Check-up Date: July 15, 2023</p>
                                            <p>Weight: 65kg, Blood Pressure: 120/80 mmHg</p>
                                            <p>Notes: Patient is healthy, prescribed prenatal vitamins.</p>
                                        </div>
                                        <div class="bg-gray-100 p-4 rounded-lg">
                                            <p class="font-semibold">Check-up Date: June 10, 2023</p>
                                            <p>Weight: 63kg, Blood Pressure: 118/78 mmHg</p>
                                            <p>Notes: Advised to increase fluid intake.</p>
                                        </div>
                                        <div class="bg-gray-100 p-4 rounded-lg">
                                            <p class="font-semibold">Check-up Date: May 5, 2023</p>
                                            <p>Weight: 61kg, Blood Pressure: 115/75 mmHg</p>
                                            <p>Notes: Initial consultation, standard tests ordered.</p>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <button
                                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg flex justify-center items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 4v16h16M4 4h16v16M4 8h16" />
                                            </svg>
                                            View All Records
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Unified Maternal Modal -->
                    <div x-show="addAndUpdateModal" x-cloak
                        class="fixed inset-0 flex items-center h-full justify-center bg-black/40 z-50">
                        <div x-show="addAndUpdateModal" x-transition
                            class="bg-white p-8 rounded-lg w-3/4 max-w-4xl space-y-6">

                            <!-- Modal Header -->
                            <div class="flex justify-between items-center">
                                <h3 class="text-xl font-semibold text-gray-800"
                                    x-text="form.id ? 'Edit Maternal Profile' : 'Register Maternal Profile'"></h3>
                                <button @click="addAndUpdateModal = false"
                                    class="text-2xl text-gray-500 hover:text-black cursor-pointer">
                                    &times;
                                </button>
                            </div>

                            <!-- Form -->
                            <form @submit.prevent="form.id ? updateMaternalProfile() : addMaternalProfile()">
                                @csrf
                                @method('POST')
                                <div class="grid grid-cols-2 gap-6">
                                    <!-- Left -->
                                    <div class="space-y-4">
                                        <h4 class="text-lg font-medium text-gray-700">Personal and Contact Information
                                        </h4>
                                        <input type="text" name="user_id" x-model="form.user_id"
                                            class="w-full px-4 py-2 border rounded-md hidden">
                                        <div class="grid grid-cols-2 gap-2">

                                            <div>
                                                <label class="text-sm text-gray-600">Name</label>
                                                <input type="text" name="name" x-model="form.name"
                                                    class="w-full px-4 py-2 border rounded-md">
                                                <p class="text-sm text-red-600 mt-1 error-message" id="error-name"></p>
                                            </div>
                                            <div>
                                                <label class="text-sm text-gray-600">Spouse's Name</label>
                                                <input type="text" name="spouse_name" x-model="form.spouse_name"
                                                    class="w-full px-4 py-2 border rounded-md">
                                                <p class="text-sm text-red-600 mt-1 error-message"
                                                    id="error-spouse_name">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <label class="text-sm text-gray-600">Birthdate</label>
                                                <input type="date" name="birthdate" x-model="form.birthdate"
                                                    class="w-full px-4 py-2 border rounded-md">
                                                <p class="text-sm text-red-600 mt-1 error-message" id="error-birthdate">
                                                </p>
                                            </div>
                                            <div>
                                                <label class="text-sm text-gray-600">Age</label>
                                                <input type="text" name="age" x-model="form.age"
                                                    class="w-full px-4 py-2 border rounded-md">
                                                <p class="text-sm text-red-600 mt-1 error-message" id="error-age"></p>
                                            </div>
                                        </div>

                                        <div class=" grid grid-cols-2 gap-2">

                                            {{-- Address --}}
                                            <div>
                                                <label class="text-sm text-gray-600">Address</label>
                                                <input type="text" name="address" x-model="form.address"
                                                    class="w-full px-4 py-2 border rounded-md">
                                                <p class="text-sm text-red-600 mt-1 error-message" id="error-address">
                                                </p>
                                            </div>

                                            {{-- Contact Number --}}
                                            <div>
                                                <label class="text-sm text-gray-600">Contact Number</label>
                                                <input type="text" name="contact_number" x-model="form.contact_number"
                                                    class="w-full px-4 py-2 border rounded-md">
                                                <p class="text-sm text-red-600 mt-1 error-message"
                                                    id="error-contact_number">
                                                </p>
                                            </div>
                                        </div>

                                        <div class=" grid grid-cols-2 gap-2">
                                            {{-- Civil Status --}}
                                            <div>
                                                <label class="text-sm text-gray-600">Civil Status</label>
                                                <select x-model="form.civil_status" name="civil_status"
                                                    class="w-full px-4 py-2 border rounded-md">
                                                    <option value="" disabled>Select Status</option>
                                                    <option>Single</option>
                                                    <option>Married</option>
                                                    <option>Widowed</option>
                                                    <option>Separated</option>
                                                </select>
                                                <p class="text-sm text-red-600 mt-1 error-message"
                                                    id="error-civil_status">
                                                </p>
                                            </div>

                                            {{-- BloodType --}}
                                            <div>
                                                <label class="text-sm text-gray-600">Blood Type</label>
                                                <select x-model="form.blood_type" name="blood_type"
                                                    class="w-full px-4 py-2 border rounded-md">
                                                    <option value="" disabled>Select Type</option>
                                                    <option>A+</option>
                                                    <option>A-</option>
                                                    <option>B+</option>
                                                    <option>B-</option>
                                                    <option>AB+</option>
                                                    <option>AB-</option>
                                                    <option>O+</option>
                                                    <option>O-</option>
                                                </select>
                                                <p class="text-sm text-red-600 mt-1 error-message"
                                                    id="error-blood_type">
                                                </p>
                                            </div>
                                        </div>


                                    </div>

                                    <!-- Right -->
                                    <div class="space-y-4">
                                        <h4 class="text-lg font-medium text-gray-700">Identification & Eligibility</h4>

                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <label class="text-sm text-gray-600">Family Serial No.</label>
                                                <input type="text" name="family_serial_no"
                                                    x-model="form.family_serial_no"
                                                    class="w-full px-4 py-2 border rounded-md">
                                                <p class="text-sm text-red-600 mt-1 error-message"
                                                    id="error-family_serial_no"></p>
                                            </div>
                                            <div>
                                                <label class="text-sm text-gray-600">PhilHealth No.</label>
                                                <input type="text" name="philhealth_no" x-model="form.philhealth_no"
                                                    class="w-full px-4 py-2 border rounded-md">
                                                <p class="text-sm text-red-600 mt-1 error-message"
                                                    id="error-philhealth_no">
                                                </p>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="text-sm text-gray-600">Eligibility</label>
                                            <div class="flex gap-4 mt-2">
                                                <template x-for="option in ['nhts', '4ps', 'ips', 'non-nhts']"
                                                    :key="option">
                                                    <label class="flex items-center space-x-2">
                                                        <input type="radio" :value="option" name="nhts_status"
                                                            x-model="form.nhts_status">
                                                        <span class="uppercase" x-text="option"></span>
                                                    </label>
                                                </template>


                                            </div>
                                            <p class="text-sm text-red-600 mt-1 error-message" id="error-nhts_status">
                                            </p>
                                        </div>

                                        <!-- Optional Account Info -->
                                        <div class="space-y-2 mt-6">
                                            <h4 class="text-lg font-medium text-gray-700 border-b pb-2">Account
                                                Credentials
                                            </h4>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <label class="text-sm text-gray-600">Username</label>
                                                    <input type="text" x-model="form.username"
                                                        class="w-full px-4 py-2 border rounded-md">
                                                </div>
                                                <div>
                                                    <label class="text-sm text-gray-600">Password</label>
                                                    <input type="password" x-model="form.password"
                                                        placeholder="Leave blank to keep current"
                                                        class="w-full px-4 py-2 border rounded-md">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="flex justify-end gap-3 mt-6">
                                    <button type="button" @click="addAndUpdateModal = false; clearErrors()"
                                        class="px-4 py-2 border rounded hover:bg-gray-100 cursor-pointer">Cancel</button>
                                    <button type="submit" :disabled="isLoading"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 cursor-pointer">
                                        <span x-show="!isLoading">Save</span>
                                        <span x-show="isLoading">Saving...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ✅ Success Modal -->
                    <div x-show="showSuccess" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-black/40 bg-opacity-50 z-[999]">
                        <div x-show="showSuccess" x-transition
                            class="bg-white px-6 py-4 rounded-lg shadow-lg max-w-sm w-full text-center">
                            <p class="text-green-600 font-semibold text-lg" x-text="successMessage"></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script>
            function maternalInformation() {
                return {
                    maternalProfiles: @json($maternalProfiles),
                    // Maternal Profiles
                    maternalCurrentPage: 1,
                    maternalPerPage: 8,

                    // Assessment Records
                    assessmentCurrentPage: 1,
                    assessmentPerPage: 7,
                    assessments: [
                        { id: 1, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 2, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 3, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 4, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 5, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'High' },
                        { id: 6, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 7, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 8, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 9, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 10, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Medium' },
                        { id: 11, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 12, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        // ... more assessments
                    ],

                    // MATERAL Computed
                    get maternalTotal() {
                        return this.maternalProfiles.length;
                    },
                    get maternalTotalPages() {
                        return Math.ceil(this.maternalTotal / this.maternalPerPage);
                    },
                    get paginatedMaternalProfiles() {
                        const start = (this.maternalCurrentPage - 1) * this.maternalPerPage;
                        return this.maternalProfiles.slice(start, start + this.maternalPerPage);
                    },
                    maternalNextPage() {
                        if (this.maternalCurrentPage < this.maternalTotalPages) this.maternalCurrentPage++;
                    },
                    maternalPrevPage() {
                        if (this.maternalCurrentPage > 1) this.maternalCurrentPage--;
                    },

                    // ASSESSMENT Computed
                    get assessmentTotal() {
                        return this.assessments.length;
                    },
                    get assessmentTotalPages() {
                        return Math.ceil(this.assessmentTotal / this.assessmentPerPage);
                    },
                    get paginatedAssessments() {
                        const start = (this.assessmentCurrentPage - 1) * this.assessmentPerPage;
                        return this.assessments.slice(start, start + this.assessmentPerPage);
                    },
                    assessmentNextPage() {
                        if (this.assessmentCurrentPage < this.assessmentTotalPages) this.assessmentCurrentPage++;
                    },
                    assessmentPrevPage() {
                        if (this.assessmentCurrentPage > 1) this.assessmentCurrentPage--;
                    },


                    statusColors: {
                        'Low': 'bg-green-100 text-green-700',
                        'Medium': 'bg-orange-100 text-orange-700',
                        'High': 'bg-red-200 text-red-700',
                    },

                    // Visibility States
                    showMaternalPage: false,
                    hideMaternalprofile: true,

                    openMaternalPage(maternalProfile) {
                        this.maternalProfileData = { ...maternalProfile }
                        this.showMaternalPage = true;
                    },

                    showMaternalProfile: true,
                    showMaternalRecord: false,
                    showPastMaternalRecord: false,
                    showAddPrenatalRecordModal: false,
                    viewAllPrenatalRecord: false,

                    maternalProfileData: {},

                    // Helper to reset maternal views
                    resetMaternalViews() {
                        this.showMaternalProfile = false;
                        this.showMaternalRecord = false;
                        this.showPastMaternalRecord = false;
                        this.viewAllPrenatalRecord = false;
                        this.showAddPrenatalRecordModal = false;
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

                    showAddPrenatalRecordModalBtn() {
                        this.showAddPrenatalRecordModal = true;
                    },

                    viewAllPrenatalRecordBtn() {
                        this.resetMaternalViews();
                        this.viewAllPrenatalRecord = true;
                    },

                    isSelected: 'maternalProfile',
                    isBtnSelected(btn) {
                        return this.isSelected === btn ? 'bg-blue-700 text-white' : 'bg-blue-100 text-blue-800 hover:bg-blue-700 hover:text-white cursor-pointer';
                    },


                    // Form state
                    form: {
                        id: null,
                        user_id: '',
                        name: '',
                        spouse_name: '',
                        birthdate: '',
                        age: '',
                        address: '',
                        contact_number: '',
                        civil_status: '',
                        philhealth_no: '',
                        family_serial_no: '',
                        nhts_status: '',
                        blood_type: '',
                    },

                    // UI State
                    addAndUpdateModal: false,
                    isLoading: false,
                    showSuccess: false,
                    successMessage: '',
                    showMaternalModal: false,
                    modalMaternalProfile: null,

                    // Filters
                    search: '',
                    filterRole: '',
                    filterStatus: '',

                    // Filtered list
                    filteredMaternalProfiles() {
                        return this.maternalProfiles.filter(maternalProfile => {
                            return (
                                (!this.search || maternalProfile.name.toLowerCase().includes(this.search.toLowerCase())) &&
                                (!this.filterRole || maternalProfile.role === this.filterRole) &&
                                (!this.filterStatus || maternalProfile.status === this.filterStatus)
                            );
                        });
                    },

                    resetForm() {
                        this.form = {
                            id: null,
                            user_id: '',
                            name: '',
                            spouse_name: '',
                            birthdate: '',
                            age: '',
                            address: '',
                            contact_number: '',
                            civil_status: '',
                            philhealth_no: '',
                            family_serial_no: '',
                            nhts_status: '',
                            blood_type: '',

                        };
                        $('.error-message').text('');
                        $('input, select').removeClass('border-red-500');
                    },

                    // Modal handling
                    openAddModal() {
                        this.resetForm();
                        this.addAndUpdateModal = true;
                    },

                    openUpdateMaternalProfile(maternalProfile) {
                        this.form = { ...maternalProfile };
                        this.addAndUpdateModal = true;
                    },

                    viewMaternalProfile(profile) {
                        this.modalMaternalProfile = profile;
                        this.showMaternalModal = true;
                    },

                    // Add Maternal Profile
                    async addMaternalProfile() {
                        this.isLoading = true;
                        this.clearErrors();

                        if (!this.validateForm()) {
                            this.isLoading = false;
                            return;
                        }

                        try {
                            const res = await fetch('{{ route("maternal.store") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json', // ✅ Add this
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(this.form)
                            });

                            const data = await res.json();
                            this.maternalProfiles.unshift(data.maternalProfile);
                            this.addAndUpdateModal = false;
                            this.triggerSuccess(data.message);
                        } catch (error) {
                            console.error('Add user failed:', error);
                        } finally {
                            this.isLoading = false;
                        }
                    },

                    // Update Maternal Profile
                    async updateMaternalProfile() {
                        this.isLoading = true;
                        this.clearErrors();

                        if (!this.validateForm(true)) {
                            this.isLoading = false;
                            return;
                        }

                        try {
                            const res = await fetch('/admin/maternal-profiles/' + this.form.id, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(this.form)
                            });

                            const data = await res.json();
                            const index = this.maternalProfiles.findIndex(u => u.id === this.form.id);
                            if (index !== -1) this.maternalProfiles[index] = data.maternalProfile;

                            this.addAndUpdateModal = false;
                            this.triggerSuccess(data.message);
                        } catch (error) {
                            console.error('Update user failed:', error);
                        } finally {
                            this.isLoading = false;
                        }
                    },

                    triggerSuccess(message) {
                        this.successMessage = message;
                        this.showSuccess = true;
                        setTimeout(() => {
                            this.showSuccess = false;
                            window.location.reload();
                        }, 1500);
                    },


                    // Clear validation errors
                    clearErrors() {
                        $('.error-message').text('');
                        $('input, select, textarea').removeClass('border-red-500');
                    },

                    validateForm(isUpdate = false) {
                        let hasError = false;

                        // Name
                        if (!this.form.name) {
                            $('#error-name').text('Name is required.');
                            $('[name="name"]').addClass('border-red-500');
                            hasError = true;
                        }

                        // Spouse Name
                        if (!this.form.spouse_name) {
                            $('#error-spouse_name').text('Spouse name is required.');
                            $('[name="spouse_name"]').addClass('border-red-500');
                            hasError = true;
                        }

                        // Birthdate
                        if (!this.form.birthdate) {
                            $('#error-birthdate').text('Birthdate is required.');
                            $('[name="birthdate"]').addClass('border-red-500');
                            hasError = true;
                        }

                        // Age
                        if (!this.form.age || isNaN(this.form.age)) {
                            $('#error-age').text('Valid age is required.');
                            $('[name="age"]').addClass('border-red-500');
                            hasError = true;
                        }

                        // Address
                        if (!this.form.address) {
                            $('#error-address').text('Address is required.');
                            $('[name="address"]').addClass('border-red-500');
                            hasError = true;
                        }

                        // Contact Number
                        if (!this.form.contact_number) {
                            $('#error-contact_number').text('Contact number is required.');
                            $('[name="contact_number"]').addClass('border-red-500');
                            hasError = true;
                        }

                        // Civil Status
                        if (!this.form.civil_status) {
                            $('#error-civil_status').text('Civil status is required.');
                            $('[name="civil_status"]').addClass('border-red-500');
                            hasError = true;
                        }

                        // PhilHealth No.
                        if (!this.form.philhealth_no) {
                            $('#error-philhealth_no').text('PhilHealth number is required.');
                            $('[name="philhealth_no"]').addClass('border-red-500');
                            hasError = true;
                        }

                        // Family Serial No.
                        if (!this.form.family_serial_no) {
                            $('#error-family_serial_no').text('Family Serial Number is required.');
                            $('[name="family_serial_no"]').addClass('border-red-500');
                            hasError = true;
                        }

                        // Eligibility
                        if (!this.form.nhts_status) {
                            $('#error-nhts_status').text('Eligibility is required.');
                            $('[name="nhts_status"]').addClass('border-red-500');
                            hasError = true;
                        }

                        // Blood Type
                        if (!this.form.blood_type) {
                            $('#error-blood_type').text('Blood Type is required.');
                            $('[name="blood_type"]').addClass('border-red-500');
                            hasError = true;
                        }

                        return !hasError;
                    }

                };
            }
        </script>




</x-layout>