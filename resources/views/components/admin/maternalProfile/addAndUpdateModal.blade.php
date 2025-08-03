<!-- Unified Maternal Modal -->
<div x-show="addAndUpdateModal" x-cloak class="fixed inset-0 flex items-center h-full justify-center bg-black/40 z-50">
    <div x-show="addAndUpdateModal" x-transition class="bg-white p-8 rounded-lg w-3/4 max-w-4xl space-y-6">

        <!-- Modal Header -->
        <div class="flex justify-between items-center">
            <h3 class="text-xl font-semibold text-gray-800"
                x-text="form.id ? 'Edit Maternal Profile' : 'Register Maternal Profile'"></h3>
            <button @click="addAndUpdateModal = false" class="text-2xl text-gray-500 hover:text-black cursor-pointer">
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
                            <p class="text-sm text-red-600 mt-1 error-message" id="error-spouse_name">
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
                            <input type="text" name="age" x-model="form.age" class="w-full px-4 py-2 border rounded-md">
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
                            <p class="text-sm text-red-600 mt-1 error-message" id="error-contact_number">
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
                            <p class="text-sm text-red-600 mt-1 error-message" id="error-civil_status">
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
                            <p class="text-sm text-red-600 mt-1 error-message" id="error-blood_type">
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
                            <input type="text" name="family_serial_no" x-model="form.family_serial_no"
                                class="w-full px-4 py-2 border rounded-md">
                            <p class="text-sm text-red-600 mt-1 error-message" id="error-family_serial_no"></p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">PhilHealth No.</label>
                            <input type="text" name="philhealth_no" x-model="form.philhealth_no"
                                class="w-full px-4 py-2 border rounded-md">
                            <p class="text-sm text-red-600 mt-1 error-message" id="error-philhealth_no">
                            </p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Eligibility</label>
                        <div class="flex gap-4 mt-2">
                            <template x-for="option in ['nhts', '4ps', 'ips', 'non-nhts']" :key="option">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" :value="option" name="nhts_status" x-model="form.nhts_status">
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
                                <input type="text" x-model="form.username" class="w-full px-4 py-2 border rounded-md">
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Password</label>
                                <input type="password" x-model="form.password" placeholder="Leave blank to keep current"
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