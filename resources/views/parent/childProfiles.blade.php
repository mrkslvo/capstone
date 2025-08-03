<x-layout>
    <div x-data="child() " x-cloak x-init="init()" class="flex h-screen bg-blue-50">

        <x-parentSidebar />
        <!-- Main Content -->
        <div class="flex-1 p-3 overflow-auto relative">
            <div class="space-y-3 flex flex-col h-full">

                {{-- HEADER --}}
                <x-header>Child Profile</x-header>

                <div class=" p-4 h-screen bg-white rounded shadow scrollable relative">

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
                                <button @click="openImmunizationRecord();  isSelected = 'immmunizationRecord'"
                                    :class="isBtnSelected('immmunizationRecord')"
                                    class="px-4 py-2 rounded-md font-semibold transition">
                                    Immunization Records
                                </button>
                                <button @click="openGrowthRecord();  isSelected = 'growthRecord'"
                                    :class="isBtnSelected('growthRecord')"
                                    class="px-4 py-2 rounded-md font-semibold transition">
                                    Growth Records
                                </button>
                            </div>

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
                                <div class=" border-b border-blue-700 space-y-3 px-4 py-2">
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


                                </div>

                                {{-- Next Immunization Schedule --}}
                                <div class=" flex gap-2 flex-col col-span-3">
                                    <h3 class="text-lg font-semibold my-2">Next Immunization Schedule</h3>
                                    <div class="flex items-center mb-4 w-full">
                                        <div class=" flex items-center justify-between gap-2 w-full">
                                            <div class=" flex items-center gap-2">

                                                <div>
                                                    <label>Date</label>
                                                    <input type="date" name="date" :min="minDate"
                                                        class="border rounded w-full p-2" />
                                                </div>

                                                <div>
                                                    <label>Time</label>
                                                    <input type="time" name="time" class="border rounded w-full p-2" />
                                                </div>
                                            </div>
                                        </div>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- View All Immunization Record --}}
                        <div x-show="viewAllImmunizationRecord">

                            <div class=" bg-white">
                                <div>
                                    <h1 class=" text-2xl my-2">All Immunization Record</h1>
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
                                                        <th class="p-3">Date</th>
                                                        <th class="p-3">VACCINE / SERVICE</th>
                                                        <th class="p-3">WEIGHT(KG)</th>
                                                        <th class="p-3">HEIGHT(CM)</th>
                                                        <th class="p-3">FTYPE OF FEEDING</th>
                                                        <th class="p-3">NOTES</th>
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
                    </div>
                </div>

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
                    showChildPage: true,
                    hideMaternalprofile: false,
                    showChildProfile: true,
                    showImmunizationRecord: false,
                    showGrowthRecord: false,
                    viewAllImmunizationRecord: false,
                    viewAllGrowthRecord: false,
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

                    // View switching
                    resetViews() {
                        this.showChildProfile = false;
                        this.showImmunizationRecord = false;
                        this.showGrowthRecord = false;
                        this.viewAllImmunizationRecord = false;
                        this.viewAllGrowthRecord = false;
                    },

                    openChildProfile() {
                        this.resetViews();
                        this.showChildProfile = true;
                    },

                    openImmunizationRecord() {
                        this.resetViews();
                        this.showImmunizationRecord = true;
                    },

                    openGrowthRecord() {
                        this.resetViews();
                        this.showGrowthRecord = true;
                    },

                    showAllImmunizationRecords() {
                        this.resetViews();
                        this.viewAllImmunizationRecord = true;
                    },

                    showAllGrowthRecords() {
                        this.resetViews();
                        this.viewAllGrowthRecord = true;
                    },

                    viewChildProfile(childProfile) {
                        this.modalChildProfile = childProfile;
                        this.showChildModal = true;
                    },
                }
            }
        </script>

    </div>
</x-layout>