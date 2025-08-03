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
                            <p x-text="errors.purok" class="text-sm text-red-600 mt-1 error-message" id="error-purok">
                            </p>
                        </div>
                    </div>

                    <div class=" grid grid-cols-1">
                        <label for="">Complete Address of Family</label>
                        <x-form.inputField name="address" placeholder="Complete Address of Family"
                            model="form.address" />
                        <p x-text="errors.address" class="text-sm text-red-600 mt-1 error-message" id="error-address">
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class=" grid grid-cols-1">
                            <label for="">Child's Name</label>
                            <x-form.inputField name="child_name" placeholder="Child's Name" model="form.child_name" />
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
                            <p x-text="errors.sex" class="text-sm text-red-600 mt-1 error-message" id="error-sex"></p>
                        </div>

                        <div>
                            <label for="">Age</label>
                            <x-form.inputField name="age" type="number" placeholder="Age" model="form.age" />
                            <p x-text="errors.age" class="text-sm text-red-600 mt-1 error-message" id="error-age"></p>
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
                                <input type="text" name="mother_name" id="mother_name" x-model="form.mother_name"
                                    x-on:input="search = form.mother_name; filterMothers()" x-on:focus="show = true"
                                    x-on:click.away="show = false" autocomplete="off" placeholder="Mother's Name"
                                    class="w-full border rounded px-3 py-2">

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
                                <p x-text="errors.mother_occupation" class="text-sm text-red-600 mt-1 error-message"
                                    id="error-mother_occupation"></p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class=" grid grid-cols-1">
                                <label for="">Educational Level</label>
                                <x-form.inputField name="mother_educational_level" placeholder="Educational Level"
                                    model="form.mother_educational_level" />
                                <p x-text="errors.mother_educational_level"
                                    class="text-sm text-red-600 mt-1 error-message" id="error-mother_educational_level">
                                </p>
                            </div>
                            <div class=" grid grid-cols-1">
                                <label for="">No. of Pregnancies</label>
                                <x-form.inputField name="mother_no_of_pregnancies" placeholder="No. of Pregnancies"
                                    type="number" model="form.mother_no_of_pregnancies" />
                                <p x-text="errors.mother_no_of_pregnancies"
                                    class="text-sm text-red-600 mt-1 error-message" id="error-mother_no_of_pregnancies">
                                </p>
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
                                <p x-text="errors.father_occupation" class="text-sm text-red-600 mt-1 error-message"
                                    id="error-father_occupation"></p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class=" grid grid-cols-1">
                                <label for="">Educational Level</label>
                                <x-form.inputField name="father_educational_level" placeholder="Educational Level"
                                    model="form.father_educational_level" />
                                <p x-text="errors.father_educational_level"
                                    class="text-sm text-red-600 mt-1 error-message" id="error-father_educational_level">
                                </p>
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
                        <x-form.inputField name="gestational_age_at_birth" placeholder="Gestational Age at Birth"
                            model="form.gestational_age_at_birth" type="number" />
                        <p x-text="errors.gestational_age_at_birth" class="text-sm text-red-600 mt-1 error-message"
                            id="error-gestational_age_at_birth">
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
                            <x-form.inputField :step="0.1" name="weight" placeholder="Birth Weight (kg)" type="number"
                                model="form.weight" />
                            <p x-text="errors.weight" class="text-sm text-red-600 mt-1 error-message" id="error-weight">
                            </p>
                        </div>
                        <div>
                            <label>Birth Length (cm)</label>
                            <x-form.inputField :step="0.1" name="length" placeholder="Birth Length (cm)" type="number"
                                model="form.length" />
                            <p x-text="errors.length" class="text-sm text-red-600 mt-1 error-message" id="error-length">
                            </p>
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
                        <x-form.inputField name="date_of_birth_registration" placeholder="Date of Birth Registration"
                            type="date" model="form.date_of_birth_registration" />
                        <p x-text="errors.date_of_birth_registration" class="text-sm text-red-600 mt-1 error-message"
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
