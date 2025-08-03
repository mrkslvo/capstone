<x-layout>
    <title>Maternal Profiles</title>
    <div x-data="maternalInformation()" x-cloak class="flex h-screen bg-blue-50">
        <x-adminSidebar />

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

                    @include('components.admin.maternalProfile.showMaternalPage')

                    @include('components.admin.maternalProfile.addAndUpdateModal')

                    @include('components.successModal')

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
