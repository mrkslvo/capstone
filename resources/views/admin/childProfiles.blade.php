<x-layout>
    <title>Child Profiles</title>
    <div x-data="child() " x-cloak x-init="init()" class="flex h-screen bg-blue-50">
        <x-adminSidebar />
        <!-- Main Content -->
        <div class="flex-1 p-4 overflow-auto relative">
            <div class="space-y-2 flex flex-col h-full">

                {{-- HEADER --}}
                <x-header>Child Profiles</x-header>

                <div class=" p-4 h-screen bg-white rounded shadow scrollable relative">
                    <div x-show="showFilters" class=" flex items-center space-x-2 mb-4 justify-between">
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
                        <button @click="openAddAndUpdateModal()"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg cursor-pointer">Add Child</button>
                    </div>
                    <div x-data="maternalProfileTable()">
                        <table class="table w-full">
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
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="childProfile in currentPageProfiles" :key="childProfile.id">
                                    <tr @click="openChildPage(childProfile); openChildProfile() "
                                        class="table-body cursor-pointer">
                                        <td class="p-3" x-text="childProfile.child_name"></td>
                                        <td class="p-3" x-text="childProfile.sex"></td>
                                        <td class="p-3" x-text="childProfile.birthdate"></td>
                                        <td class="p-3" x-text="childProfile.length"></td>
                                        <td class="p-3" x-text="childProfile.weight"></td>
                                        <td class="p-3" x-text="childProfile.address"></td>
                                        <td class="p-3" x-text="childProfile.mother_name"></td>
                                        <td class="p-3" x-text="childProfile.father_name"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>

                        <!-- Pagination Controls -->
                        <div class="flex justify-between items-center p-4">
                            <div>
                                Page <span x-text="currentPage"></span> of <span x-text="maxPages"></span> |
                                Total Maternal Profiles: <span x-text="totalProfiles"></span>
                            </div>
                            <div class=" flex items-center gap-4">
                                <button @click="goBack"
                                    class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                                    :disabled="currentPage === 1">Previous</button>
                                <button @click="goNext"
                                    class="px-4 py-2 bg-white text-blue-700 border border-blue-700 rounded shadow-sm font-semibold hover:bg-blue-50 hover:shadow-md transition-all duration-200"
                                    :disabled="currentPage === maxPages">Next</button>
                            </div>
                        </div>
                    </div>


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

                            <!-- Close Button -->
                            <button @click="showChildPage = false, showFilters = true "
                                class="text-3xl text-gray-500 hover:text-gray-800 transition">&times;</button>
                        </div>
                        @include('components.admin.childProfile.childProfileInfo')
                        @include('components.admin.childProfile.addImmunizationRecord')
                        @include('components.admin.childProfile.growthRecord')
                        @include('components.admin.childProfile.immunizationRecord')
                        @include('components.admin.childProfile.addGrowthRecord')
                        @include('components.admin.childProfile.showChildMother')
                        @include('components.admin.childProfile.ViewAllGrowthRecord')
                        @include('components.admin.childProfile.viewAllImmunizationRecord')
                    </div>
                </div>

                @include('components.admin.childProfile.addAndUpdateChildProfile')
                @include('components.successModal')
            </div>
        </div>




        <script>
            function Immunization() {
                return {
                    currentPage: 1,
                    rowsPerPage: 7,
                    immunization: [
                        { id: 1, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 2, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 3, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 4, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 5, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 6, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 7, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 8, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 9, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 10, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 11, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 12, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        // ... Add more data objects as needed
                    ],
                    get totalProfiles() {
                        return this.immunization.length;
                    },
                    get maxPages() {
                        return Math.ceil(this.totalProfiles / this.rowsPerPage);
                    },
                    get currentPageProfiles() {
                        const start = (this.currentPage - 1) * this.rowsPerPage;
                        return this.immunization.slice(start, start + this.rowsPerPage);
                    },
                    goNext() {
                        if (this.currentPage < this.maxPages) this.currentPage++;
                    },
                    goBack() {
                        if (this.currentPage > 1) this.currentPage--;
                    },
                }
            }
        </script>

        <script>
            function growth() {
                return {
                    currentPage: 1,
                    rowsPerPage: 7,
                    growth: [
                        { id: 1, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 2, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 3, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 4, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 5, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 6, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 7, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 8, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 9, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 10, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 11, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        { id: 12, date: '03/10/2024', weight: '60', bp: '110/70', fhr: '140', fundal: '30', position: 'Cephalic', swelling: 'None', nutrition: 'Normal', risk: 'Low' },
                        // ... Add more data objects as needed
                    ],
                    get totalProfiles() {
                        return this.growth.length;
                    },
                    get maxPages() {
                        return Math.ceil(this.totalProfiles / this.rowsPerPage);
                    },
                    get currentPageProfiles() {
                        const start = (this.currentPage - 1) * this.rowsPerPage;
                        return this.growth.slice(start, start + this.rowsPerPage);
                    },
                    goNext() {
                        if (this.currentPage < this.maxPages) this.currentPage++;
                    },
                    goBack() {
                        if (this.currentPage > 1) this.currentPage--;
                    },
                }
            }
        </script>

        <script>
            function maternalProfileTable() {
                return {
                    currentPage: 1,
                    rowsPerPage: 8,
                    profiles: @json($childProfiles),
                    get totalProfiles() {
                        return this.profiles.length;
                    },
                    get maxPages() {
                        return Math.ceil(this.totalProfiles / this.rowsPerPage);
                    },
                    get currentPageProfiles() {
                        const start = (this.currentPage - 1) * this.rowsPerPage;
                        return this.profiles.slice(start, start + this.rowsPerPage);
                    },
                    goNext() {
                        if (this.currentPage < this.maxPages) this.currentPage++;
                    },
                    goBack() {
                        if (this.currentPage > 1) this.currentPage--;
                    },
                }
            }
        </script>

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
                    showImmunizationRecord: false,
                    showGrowthRecord: false,
                    showAddImmunizationRecord: false,
                    viewAllImmunizationRecord: false,
                    showFilters: true,
                    showChildMother: false,
                    viewAllGrowthRecord: false,
                    showAddGrowthRecord: false,
                    addAndUpdateChildProfile: false,
                    showChildModal: false,

                    childProfileData: {},

                    openChildPage(childProfile) {
                        this.childProfileData = { ...childProfile }
                        this.showChildPage = true;
                    },

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
                        this.showImmunizationRecord = false;
                        this.showGrowthRecord = false;
                        this.viewAllImmunizationRecord = false;
                        this.viewAllGrowthRecord = false;
                        this.showFilters = false;
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
                        setTimeout(() => {
                            this.showSuccess = false;
                            window.location.reload();
                        }, 1500);
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