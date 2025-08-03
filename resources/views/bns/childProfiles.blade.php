<x-layout>
    <div x-data="child() " x-cloak x-init="init()" class="flex h-screen bg-blue-50">

        <x-bnsSidebar />
        <!-- Main Content -->
        <div class="flex-1 p-3 overflow-auto relative">
            <div class="space-y-3 flex flex-col h-full">

                {{-- HEADER --}}
                <x-header>Child Profiles</x-header>
                <div class=" p-4 h-screen bg-white rounded shadow scrollable relative">

                    <div x-show="showFilters" class=" grid grid-cols-2">
                        <div class=" flex items-center gap-2">
                            <input type="text" x-model="search" class="px-4 py-2 border border-gray-300 rounded-lg"
                                placeholder="Search...">

                            <select x-model="filterAddress" class="px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">Filter by Address</option>
                                <template x-model="filterAddress">
                                    <option x-text="profile" :value="profile"></option>
                                </template>
                            </select>

                            <select x-model="filterAge" class="px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">Filter by Age</option>
                                <template x-for="profile in [...new Set(allMaternalProfiles.map(p => p.age))]">
                                    <option x-text="profile" :value="profile"></option>
                                </template>
                            </select>
                        </div>

                        <div class=" flex items-center justify-end">
                            <button @click="openAddAndUpdateModal()"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg cursor-pointer">Add Child</button>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr class="table-head">
                                <th class="p-3">Name</th>
                                <th class="p-3">Sex</th>
                                <th class="p-3">Birthdate</th>
                                <th class="p-3">Birth Length</th>
                                <th class="p-3">Birth Weight</th>
                                <th class="p-3">Address</th>
                                <th class="p-3">Mother</th>
                                <th class="p-3">Father</th>
                                <th class="p-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="childProfile in childProfiles" :key="childProfile.id">
                                <tr @click="showChildPage = true, openChildProfile() "
                                    class="table-body cursor-pointer">
                                    <td class="p-3" x-text="childProfile.child_name"></td>
                                    <td class="p-3" x-text="childProfile.sex"></td>
                                    <td class="p-3" x-text="childProfile.birthdate"></td>
                                    <td class="p-3" x-text="childProfile.length"></td>
                                    <td class="p-3" x-text="childProfile.weight"></td>
                                    <td class="p-3" x-text="childProfile.address"></td>
                                    <td class="p-3" x-text="childProfile.mother_name"></td>
                                    <td class="p-3" x-text="childProfile.father_name"></td>
                                    <td class="p-3">
                                        {{-- <button @click="viewChildProfile(childProfile)"
                                            class="text-blue-600 cursor-pointer p-2"><img src="storage/assets/view.png"
                                                alt=""></button> --}}
                                        <button @click.stop="openUpdateChildProfile(childProfile)"
                                            class=" cursor-pointer z-50">
                                            <img src="{{ asset('/storage/assets/edit.png') }}" alt="Edit">
                                        </button>
                                    </td>
                                </tr>
                            </template>

                        </tbody>
                    </table>

                    <div x-show="showChildPage"
                        class="w-full absolute top-0 left-0 h-full bg-white text-gray-800 rounded-lg shadow-xl p-6 z-50 ">

                        <!-- Header -->
                        <div class="w-full flex items-center justify-between border-b border-blue-700 pb-4 px-4">
                            <!-- Tabs -->
                            <div class="space-x-2">
                                <button @click="openChildProfile();  isSelected = 'childProfile'"
                                    :class="isBtnSelected('childProfile')"
                                    class="px-4 py-2 rounded-md font-semibold transition">
                                    Child Profile
                                </button>
                                <button @click="openGrowthRecord();  isSelected = 'growthRecord'"
                                    :class="isBtnSelected('growthRecord')"
                                    class="px-4 py-2 rounded-md font-semibold transition">
                                    Growth Records
                                </button>
                            </div>

                            <!-- Close Button -->
                            <button @click="showChildPage = false, showFilters = true "
                                class="text-3xl text-gray-500 hover:text-gray-800 transition">&times;</button>
                        </div>

                        <!-- Child Profile Info -->
                        <div x-show="showChildProfile">

                            <div class=" grid grid-cols-2 gap-2">
                                {{-- BASIC INFORMATION --}}
                                <div class=" border-b border-blue-700 space-y-3 px-4 py-2">
                                    <div>
                                        <h1 class=" text-2xl text-blue-900">Basic Information</h1>
                                    </div>
                                    <!-- Row 1 -->
                                    <div class="grid grid-cols-1 gap-2">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Full Name:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.name"></span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Age:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.age"></span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Sex:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.birthdate"></span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Classification:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.birthdate"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- CLINIC INFORMATION --}}
                                <div class=" border-b border-blue-700 space-y-3 px-4 py-2">
                                    <div>
                                        <h1 class=" text-2xl text-blue-900">Clinic Information</h1>
                                    </div>
                                    <!-- Row 1 -->
                                    <div class="grid grid-cols-1 gap-2">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Clinic/Health Center:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.name"></span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Barangay:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.age"></span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Purok/Sition:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.birthdate"></span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Date of Registration:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.birthdate"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Mother INFORMATION --}}
                                <div @click="showChildMother = true"
                                    class=" border-b border-blue-700 space-y-3 px-4 cursor-pointer transition-all duration-300 hover:bg-gray-100/90 py-2">
                                    <div>
                                        <h1 class=" text-2xl text-blue-900">Mother Information</h1>
                                    </div>
                                    <!-- Row 1 -->
                                    <div class="grid grid-cols-1 gap-2">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Mother's Name:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.name"></span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Mother's Occupation:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.name"></span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Mother's Educational
                                                Level:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.age"></span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Mother's No. of
                                                Pregnancies:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.birthdate"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Father INFORMATION --}}
                                <div class=" border-b border-blue-700 space-y-3 px-4 py-2">
                                    <div>
                                        <h1 class=" text-2xl text-blue-900">Father Information</h1>
                                    </div>
                                    <!-- Row 1 -->
                                    <div class="grid grid-cols-1 gap-2">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Father's Name:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.name"></span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Father's Occupation:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.name"></span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Father's Educational
                                                Level:</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.age"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- BIRTH INFORMATION --}}
                            <div class=" space-y-6 px-4 py-2">
                                <div>
                                    <h1 class=" text-2xl text-blue-900">Birth Information</h1>
                                </div>
                                <!-- Row 1 -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Birthdate:</span>
                                        <span class="text-base font-semibold" x-text="modalMaternalProfile.name"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Gestational Age:</span>
                                        <span class="text-base font-semibold" x-text="modalMaternalProfile.age"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Type of Birth:</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.birthdate"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Birth Order:</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.birthdate"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Birth Weight:</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.birthdate"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Place of Delivery:</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.birthdate"></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-500">Birth Attendant:</span>
                                        <span class="text-base font-semibold"
                                            x-text="modalMaternalProfile.birthdate"></span>
                                    </div>
                                </div>
                            </div>


                        </div>

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
                                                <button @click="setChartType('weight')"
                                                    :class="tabClass('weight')">Weight</button>
                                                <button @click="setChartType('height')"
                                                    :class="tabClass('height')">Height</button>
                                                <button @click="setChartType('bmi')"
                                                    :class="tabClass('bmi')">BMI</button>
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
                                                            <svg class="w-6 h-6 text-gray-700" fill="currentColor"
                                                                viewBox="0 0 24 24">
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

                        <!-- SHOW CHILD'S MOTHER -->
                        <div x-show="showChildMother">
                            <div x-show="showChildMother" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                <!-- Modal Container -->
                                <div @click.outside="showChildMother = false" x-transition
                                    class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto p-6 space-y-6">

                                    <!-- Header -->
                                    <div class="flex justify-between items-center border-b border-blue-700 pb-2">
                                        <h1 class="text-2xl font-bold text-blue-900">Mother's Information</h1>
                                        <button @click="showChildMother = false"
                                            class="text-3xl text-gray-500 hover:text-gray-800 transition cursor-pointer">&times;</button>
                                    </div>

                                    <!-- Row 1 -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Full Name</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.name"></span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-500">Age</span>
                                            <span class="text-base font-semibold"
                                                x-text="modalMaternalProfile.age"></span>
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

                                    <!-- Identification & Eligibility -->
                                    <div>
                                        <h1 class="text-2xl font-bold text-blue-900 border-t  border-blue-700 pt-4">
                                            Identification and
                                            Eligibility</h1>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
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
                                </div>
                            </div>

                        </div>

                        {{-- View All Growth Record --}}
                        <div x-show="viewAllGrowthRecord">

                            <div class=" bg-white">
                                <div>
                                    <h1 class=" text-2xl my-2">All Growht Record</h1>
                                    <h3 class=" text-gray-500">Child: Maria Dela Cruz</h3>
                                </div>

                                <!-- Table -->
                                <div class="bg-white rounded-lg flex-1 ">
                                    <div class="container mx-auto">
                                        <div class="rounded  border-gray-200 scrollable">
                                            <!-- Sticky Header -->
                                            <table class="table">
                                                <thead class="sticky top-0 z-10">
                                                    <tr class="table-head">
                                                        <th class="p-3">NAME</th>
                                                        <th class="p-3">AGE(mos)</th>
                                                        <th class="p-3">WEIGHT(kg)</th>
                                                        <th class="p-3">HEIGHT(cm)</th>
                                                        <th class="p-3">BMI</th>
                                                        <th class="p-3">NUTRITIONAL STATUS</th>
                                                        <th class="p-3">ASSESSMENT</th>
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
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1">Assessment</label>
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

                    </div>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div x-show="addAndUpdateChildProfile" x-cloak
            class="fixed h-full inset-0 flex items-center justify-center bg-black/40 z-50 scrollable">
            <div x-show="addAndUpdateChildProfile" x-transition x-cloak
                class="bg-white rounded-lg shadow-lg w-full max-w-6xl p-8 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold mb-4"
                        x-text="form.id ? 'Update Child Registration Form' : 'Child Registration Form'"></h2>
                    <button @click="addAndUpdateChildProfile = false; clearErrors()"
                        class="text-gray-600 hover:text-black text-2xl">&times;</button>
                </div>

                <form @submit.prevent="form.id ? updateChildProfile() : addChildProfile()">
                    @csrf
                    @method('POST')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Left Side -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold flex items-center gap-2">Clinic & Child Information
                            </h3>
                            <div class="grid grid-cols-3 gap-4">
                                <div class=" grid grid-cols-1">
                                    <label for="">Clinic/Health Center</label>
                                    <x-form.inputField name="clinic_center" placeholder="Clinic/Health Center"
                                        model="form.clinic_center" />
                                    <p x-text="errors.clinic_center" class="text-sm text-red-600 mt-1 error-message"
                                        id="error-clinic_center"></p>
                                </div>
                                <div class=" grid grid-cols-1">
                                    <label for="">Barangay</label>
                                    <x-form.inputField name="barangay" placeholder="Barangay" model="form.barangay" />
                                    <p x-text="errors.barangay" class="text-sm text-red-600 mt-1 error-message"
                                        id="error-barangay"></p>
                                </div>
                                <div class=" grid grid-cols-1">
                                    <label for="">Purok/Sitio</label>
                                    <x-form.inputField name="purok" placeholder="Purok/Sitio" model="form.purok" />
                                    <p x-text="errors.purok" class="text-sm text-red-600 mt-1 error-message"
                                        id="error-purok"></p>
                                </div>
                            </div>

                            <div class=" grid grid-cols-1">
                                <label for="">Complete Address of Family</label>
                                <x-form.inputField name="address" placeholder="Complete Address of Family"
                                    model="form.address" />
                                <p x-text="errors.address" class="text-sm text-red-600 mt-1 error-message"
                                    id="error-address"></p>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div class=" grid grid-cols-1">
                                    <label for="">Child's Name</label>
                                    <x-form.inputField name="child_name" placeholder="Child's Name"
                                        model="form.child_name" />
                                    <p x-text="errors.child_name" class="text-sm text-red-600 mt-1 error-message"
                                        id="error-child_name">
                                    </p>
                                </div>
                                <div class=" grid grid-cols-1">
                                    <label for="">Child's No.</label>
                                    <x-form.inputField name="child_no" placeholder="Child's No." model="form.child_no"
                                        type="number" />
                                    <p x-text="errors.child_no" class="text-sm text-red-600 mt-1 error-message"
                                        id="error-child_no"></p>
                                </div>
                                <div class=" grid grid-cols-1">
                                    <label for="">Family No.</label>
                                    <x-form.inputField name="family_no" placeholder="Family No" model="form.family_no"
                                        type="number" />
                                    <p x-text="errors.family_no" class="text-sm text-red-600 mt-1 error-message"
                                        id="error-family_no"></p>
                                </div>
                            </div>

                            <div class=" grid grid-cols-2">
                                <div class="grid grid-cols-1">
                                    <label>Sex</label>
                                    <div class="grid grid-cols-2">
                                        <label class="flex items-center gap-1">
                                            <input type="radio" name="sex" value="male" x-model="form.sex" />
                                            Male
                                        </label>
                                        <label class="flex items-center gap-1">
                                            <input type="radio" name="sex" value="female" x-model="form.sex" />
                                            Female
                                        </label>
                                    </div>
                                    <p x-text="errors.sex" class="text-sm text-red-600 mt-1 error-message"
                                        id="error-sex"></p>
                                </div>

                                <div>
                                    <label for="">Age</label>
                                    <x-form.inputField name="age" type="number" placeholder="Age" model="form.age" />
                                    <p x-text="errors.age" class="text-sm text-red-600 mt-1 error-message"
                                        id="error-age"></p>
                                </div>
                            </div>

                            <div>
                                <label>Classification</label>
                                <select name="civil_status" class="w-full px-4 py-2 border rounded-md"
                                    x-model="form.civil_status">
                                    <option value="" disabled>Select classification</option>
                                    <option value="nhts">NHTS</option>
                                    <option value="ip's">Ip's</option>
                                    <option value="4p's">4P'S</option>
                                    <option value="non-nhts">NON-NHTS</option>
                                </select>
                                <p x-text="errors.civil_status" class="text-sm text-red-600 mt-1 error-message"
                                    id="error-civil_status"></p>
                            </div>

                            <h3 class="text-lg font-semibold flex items-center gap-2">Mother's Information</h3>

                            <div class=" space-y-2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="grid grid-cols-1 relative">
                                        <label for="mother_name">Mother's Name</label>

                                        <!-- Input bound to form.mother_name -->
                                        <input type="text" name="mother_name" id="mother_name"
                                            x-model="form.mother_name"
                                            x-on:input="search = form.mother_name; filterMothers()"
                                            x-on:focus="show = true" x-on:click.away="show = false" autocomplete="off"
                                            placeholder="Mother's Name" class="w-full border rounded px-3 py-2">

                                        <p x-text="errors.mother_name" class="text-sm text-red-600 mt-1 error-message"
                                            id="error-mother_name">
                                        </p>

                                        <!-- Dropdown suggestions -->
                                        <ul x-show="show && filtered.length > 0"
                                            class="absolute top-full left-0 w-full mt-1 border border-gray-300 bg-white shadow-md rounded z-50 max-h-48 overflow-y-auto">
                                            <template x-for="(name, index) in filtered" :key="index">
                                                <li x-text="name"
                                                    x-on:click="form.mother_name = name; search = name; show = false"
                                                    class="px-3 py-2 hover:bg-gray-100 cursor-pointer"></li>
                                            </template>
                                        </ul>
                                    </div>



                                    <div class=" grid grid-cols-1">
                                        <label for="">Occupation</label>
                                        <x-form.inputField name="mother_occupation" placeholder="Occupation"
                                            model="form.mother_occupation" />
                                        <p x-text="errors.mother_occupation"
                                            class="text-sm text-red-600 mt-1 error-message"
                                            id="error-mother_occupation"></p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class=" grid grid-cols-1">
                                        <label for="">Educational Level</label>
                                        <x-form.inputField name="mother_educational_level"
                                            placeholder="Educational Level" model="form.mother_educational_level" />
                                        <p x-text="errors.mother_educational_level"
                                            class="text-sm text-red-600 mt-1 error-message"
                                            id="error-mother_educational_level"></p>
                                    </div>
                                    <div class=" grid grid-cols-1">
                                        <label for="">No. of Pregnancies</label>
                                        <x-form.inputField name="mother_no_of_pregnancies"
                                            placeholder="No. of Pregnancies" type="number"
                                            model="form.mother_no_of_pregnancies" />
                                        <p x-text="errors.mother_no_of_pregnancies"
                                            class="text-sm text-red-600 mt-1 error-message"
                                            id="error-mother_no_of_pregnancies"></p>
                                    </div>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold flex items-center gap-2">Father's Information</h3>
                            <div class=" space-y-2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class=" grid grid-cols-1">
                                        <label for="">Father's Name</label>
                                        <x-form.inputField name="father_name" placeholder="Father's Name"
                                            model="form.father_name" />
                                        <p x-text="errors.father_name" class="text-sm text-red-600 mt-1 error-message"
                                            id="error-father_name"></p>
                                    </div>
                                    <div class=" grid grid-cols-1">
                                        <label for="">Occupation</label>
                                        <x-form.inputField name="father_occupation" placeholder="Occupation"
                                            model="form.father_occupation" />
                                        <p x-text="errors.father_occupation"
                                            class="text-sm text-red-600 mt-1 error-message"
                                            id="error-father_occupation"></p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class=" grid grid-cols-1">
                                        <label for="">Educational Level</label>
                                        <x-form.inputField name="father_educational_level"
                                            placeholder="Educational Level" model="form.father_educational_level" />
                                        <p x-text="errors.father_educational_level"
                                            class="text-sm text-red-600 mt-1 error-message"
                                            id="error-father_educational_level"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side -->
                        <div class="space-y-4">
                            <h3 class="font-semibold">Birth Information</h3>
                            <div>
                                <label>Date</label>
                                <x-form.inputField name="birthdate" type="date" model="form.birthdate" />
                                <p x-text="errors.birthdate" class="text-sm text-red-600 mt-1 error-message"
                                    id="error-birthdate"></p>
                            </div>
                            <div>
                                <label>Gestational Age at Birth</label>
                                <x-form.inputField name="gestational_age_at_birth"
                                    placeholder="Gestational Age at Birth" model="form.gestational_age_at_birth"
                                    type="number" />
                                <p x-text="errors.gestational_age_at_birth"
                                    class="text-sm text-red-600 mt-1 error-message" id="error-gestational_age_at_birth">
                                </p>
                            </div>


                            <div>
                                <label>Type Of Birth</label>
                                <x-form.select name="type_of_birth" model="form.type_of_birth">
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="normal">Normal</option>
                                    <option value="cesarean">Cesarean</option>
                                </x-form.select>
                                <p x-text="errors.type_of_birth" class="text-sm text-red-600 mt-1 error-message"
                                    id="error-type_of_birth"></p>
                            </div>
                            <div>
                                <label>Birth Order</label>
                                <x-form.inputField name="birth_order" placeholder="Birth Order" model="form.birth_order"
                                    type="number" />
                                <p x-text="errors.birth_order" class="text-sm text-red-600 mt-1 error-message"
                                    id="error-birth_order"></p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label>Birth Weight (kg)</label>
                                    <x-form.inputField :step="0.1" name="weight" placeholder="Birth Weight (kg)"
                                        type="number" model="form.weight" />
                                    <p x-text="errors.weight" class="text-sm text-red-600 mt-1 error-message"
                                        id="error-weight"></p>
                                </div>
                                <div>
                                    <label>Birth Length (cm)</label>
                                    <x-form.inputField :step="0.1" name="length" placeholder="Birth Length (cm)"
                                        type="number" model="form.length" />
                                    <p x-text="errors.length" class="text-sm text-red-600 mt-1 error-message"
                                        id="error-length"></p>
                                </div>
                            </div>
                            <div>
                                <label>Place of Delivery</label>
                                <x-form.select name="place_of_delivery" model="form.place_of_delivery">
                                    <option value="" disabled selected>Select Place</option>
                                    <option value="home">Home</option>
                                    <option value="hospital">Hospital</option>
                                </x-form.select>
                                <p x-text="errors.place_of_delivery" class="text-sm text-red-600 mt-1 error-message"
                                    id="error-place_of_delivery"></p>
                            </div>
                            <div>
                                <label>Birth Attendant</label>
                                <x-form.select name="birth_attendant" model="form.birth_attendant">
                                    <option value="" disabled selected>Select Birth Attendant</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="midwife">Midwife</option>
                                </x-form.select>
                                <p x-text="errors.birth_attendant" class="text-sm text-red-600 mt-1 error-message"
                                    id="error-birth_attendant">
                                </p>
                            </div>
                            <div>
                                <label>Date of Birth Registration</label>
                                <x-form.inputField name="date_of_birth_registration"
                                    placeholder="Date of Birth Registration" type="date"
                                    model="form.date_of_birth_registration" />
                                <p x-text="errors.date_of_birth_registration"
                                    class="text-sm text-red-600 mt-1 error-message"
                                    id="error-date_of_birth_registration"></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="addAndUpdateChildProfile = false; clearErrors()"
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

        <!-- AlpineJS Data -->
        <script>
            function growthMonitoring() {
                let chart = null;
                return {
                    growthModal: true,
                    chartType: 'height',
                    records: [
                        { date: 'July 10, 2023', details: '18.5kg, 110cm - Annual check-up' },
                        { date: 'January 5, 2023', details: '17.8kg, 105cm - Feeling well' },
                        { date: 'July 12, 2022', details: '16.9kg, 100cm - Annual check-up' },
                        { date: 'January 3, 2022', details: '16.0kg, 95cm - Follow-up' },
                    ],

                    init() {
                        this.renderChart();
                    },

                    setChartType(type) {
                        this.chartType = type;
                        this.renderChart();
                    },

                    tabClass(type) {
                        return this.chartType === type
                            ? 'px-4 py-1 bg-blue-100 text-blue-600 rounded-full text-sm'
                            : 'px-4 py-1 bg-gray-200 text-gray-600 rounded-full text-sm';
                    },

                    renderChart() {
                        const ctx = document.getElementById('growthChart').getContext('2d');
                        if (chart) chart.destroy();

                        const labels = this.records.map(r => r.date);
                        let data = [];

                        if (this.chartType === 'weight') {
                            data = this.records.map(r => parseFloat(r.details.split(',')[0]));
                        } else if (this.chartType === 'height') {
                            data = this.records.map(r => parseFloat(r.details.split(',')[1]));
                        } else {
                            data = [15.3, 15.2, 14.9, 14.5]; // Fallback sample BMI
                        }

                        chart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels,
                                datasets: [{
                                    label: this.chartType.toUpperCase(),
                                    data,
                                    fill: false,
                                    borderColor: 'rgb(59, 130, 246)',
                                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                                    tension: 0.4,
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: { legend: { display: false } },
                                scales: { y: { beginAtZero: false } }
                            }
                        });
                    }
                };
            }
        </script>


        <script>
            function child() {
                return {
                    // Visibility States
                    showChildPage: false,
                    hideMaternalprofile: false,
                    showChildProfile: false,
                    showGrowthRecord: false,
                    showFilters: true,
                    showChildMother: false,
                    viewAllGrowthRecord: false,
                    showAddGrowthRecord: false,
                    addAndUpdateChildProfile: false,
                    showChildModal: false,

                    isSelected: 'childProfile',
                    isBtnSelected(btn) {
                        return this.isSelected === btn ? 'bg-blue-700 text-white' : 'bg-blue-100 text-blue-800 hover:bg-blue-700 hover:text-white cursor-pointer';
                    },

                    // Data & Modal
                    childProfiles: @json($childProfiles),
                    mothers: @json($mothers),
                    existingMothers: [],
                    modalChildProfile: null,

                    // Form
                    form: {
                        id: null,
                        clinic_center: '', barangay: '', purok: '', address: '',
                        child_name: '', child_no: '', family_no: '', sex: '', age: '', civil_status: '',
                        mother_name: '', mother_occupation: '', mother_educational_level: '', mother_no_of_pregnancies: '',
                        father_name: '', father_occupation: '', father_educational_level: '',
                        birthdate: '', gestational_age_at_birth: '', type_of_birth: '', birth_order: '',
                        weight: '', length: '', place_of_delivery: '', birth_attendant: '', date_of_birth_registration: ''
                    },

                    // Form helpers
                    search: '',
                    filtered: [],
                    show: false,
                    isLoading: false,
                    showSuccess: false,
                    successMessage: '',
                    errors: {},

                    init() {
                        this.existingMothers = this.mothers.map(m => m.name);
                        console.log(this.existingMothers);
                    },

                    // View switching
                    resetViews() {
                        this.showChildProfile = false;
                        this.showGrowthRecord = false;
                        this.viewAllGrowthRecord = false;
                        this.showFilters = false;
                    },

                    openChildProfile() {
                        this.resetViews();
                        this.showChildProfile = true;
                    },

                    openGrowthRecord() {
                        this.resetViews();
                        this.showGrowthRecord = true;
                    },

                    showAllGrowthRecords() {
                        this.resetViews();
                        this.viewAllGrowthRecord = true;
                    },

                    // Modal handling
                    openAddAndUpdateModal() {
                        this.resetForm();
                        this.addAndUpdateChildProfile = true;
                    },

                    openUpdateChildProfile(childProfile) {
                        this.form = { ...childProfile };
                        this.addAndUpdateChildProfile = true;
                    },

                    viewChildProfile(childProfile) {
                        this.modalChildProfile = childProfile;
                        this.showChildModal = true;
                    },

                    // Search and filter
                    filterMothers() {
                        this.filtered = this.existingMothers.filter(name =>
                            name.toLowerCase().includes(this.search.toLowerCase())
                        );
                    },

                    selectMother(name) {
                        this.search = name;
                        this.show = false;
                    },

                    // Form handling
                    resetForm() {
                        Object.keys(this.form).forEach(key => this.form[key] = '');
                        this.form.id = null;
                        $('.error-message').text('');
                        $('input, select').removeClass('border-red-500');
                    },

                    clearErrors() {
                        $('.error-message').text('');
                        $('input, select, textarea').removeClass('border-red-500');
                    },

                    validateForm(isUpdate = false) {
                        this.errors = {};
                        let hasError = false;

                        const requiredFields = [
                            'clinic_center', 'barangay', 'purok', 'address', 'child_no', 'family_no', 'sex', 'age',
                            'civil_status', 'mother_occupation', 'mother_educational_level', 'mother_no_of_pregnancies',
                            'father_name', 'father_occupation', 'father_educational_level', 'birthdate',
                            'gestational_age_at_birth', 'type_of_birth', 'birth_order', 'weight', 'length',
                            'place_of_delivery', 'birth_attendant', 'date_of_birth_registration'
                        ];

                        // Validate required fields
                        requiredFields.forEach(field => {
                            if (!this.form[field]) {
                                this.errors[field] = 'Field is required.';
                                hasError = true;
                            }
                        });

                        // Validate child name
                        const name = this.form.child_name?.trim().toLowerCase();
                        if (!name) {
                            this.errors.child_name = 'Child name is required.';
                            hasError = true;
                        } else {
                            const nameExists = this.childProfiles.some(child =>
                                child.child_name.toLowerCase() === name &&
                                (!isUpdate || child.id !== this.form.id)
                            );
                            if (nameExists) {
                                this.errors.child_name = 'Child name already exists.';
                                hasError = true;
                            }
                        }

                        // Validate mother name
                        const mother = this.form.mother_name?.trim();
                        if (!mother) {
                            this.errors.mother_name = 'Mother name is required.';
                            hasError = true;
                        } else if (!this.existingMothers.includes(mother)) {
                            this.errors.mother_name = 'Mother name does not exist.';
                            hasError = true;
                        }

                        return !hasError;
                    },

                    // Success message
                    triggerSuccess(message) {
                        this.successMessage = message;
                        this.showSuccess = true;
                        setTimeout(() => this.showSuccess = false, 1500);
                    },

                    // Store
                    async addChildProfile() {
                        this.isLoading = true;
                        this.clearErrors();

                        if (!this.validateForm()) {
                            this.isLoading = false;
                            return;
                        }

                        try {
                            const res = await fetch('{{ route("child.store") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(this.form)
                            });

                            const data = await res.json();
                            this.childProfiles.unshift(data.childProfile);
                            this.addAndUpdateChildProfile = false;
                            this.triggerSuccess(data.message);
                        } catch (error) {
                            console.error('Add child failed:', error);
                        } finally {
                            this.isLoading = false;
                        }
                    },

                    // Update
                    async updateChildProfile() {
                        this.isLoading = true;
                        this.clearErrors();

                        if (!this.validateForm(true)) {
                            this.isLoading = false;
                            return;
                        }

                        try {
                            const res = await fetch('/admin/child-profiles/' + this.form.id, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(this.form)
                            });

                            const data = await res.json();
                            const index = this.childProfiles.findIndex(u => u.id === this.form.id);
                            if (index !== -1) this.childProfiles[index] = data.childProfile;

                            this.addAndUpdateChildProfile = false;
                            this.triggerSuccess(data.message);
                        } catch (error) {
                            console.error('Update child failed:', error);
                        } finally {
                            this.isLoading = false;
                        }
                    },
                }
            }
        </script>

    </div>
</x-layout>