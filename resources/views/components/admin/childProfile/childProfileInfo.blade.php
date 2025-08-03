<!-- Child Profile Info -->
<div x-show="showChildProfile">

    <div class=" grid grid-cols-2 gap-2">
        {{-- BASIC INFORMATION --}}
        <div class=" border-b border-blue-700 space-y-2 px-4 py-2">
            <div>
                <h1 class=" text-2xl text-blue-900">Basic Information</h1>
            </div>
            <!-- Row 1 -->
            <div class="grid grid-cols-2 gap-2">
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Full Name:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.child_name"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Age:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.age"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Sex:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.sex"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Classification:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.civil_status"></span>
                </div>
            </div>
        </div>

        {{-- CLINIC INFORMATION --}}
        <div class=" border-b border-blue-700 space-y-2 px-4 py-2">
            <div class=" flex items-center justify-between">
                <h1 class=" text-2xl text-blue-900">Clinic Information</h1>
                <div class="flex items-center gap-2">
                    <button @click.stop="openUpdateChildProfile(childProfileData)"
                        class="text-white bg-blue-700 rounded hover:underline cursor-pointer py-1 px-3  flex items-center">Edit</button>
                </div>
            </div>
            <!-- Row 1 -->
            <div class="grid grid-cols-2 gap-2">
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Clinic/Health Center:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.clinic_center"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Barangay:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.barangay"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Purok/Sition:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.purok"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Date of Registration:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.date_of_birth_registration"></span>
                </div>
            </div>
        </div>

        {{-- Mother INFORMATION --}}
        <div @click="showChildMother = true"
            class=" border-b border-blue-700 space-y-2 px-4 cursor-pointer transition-all duration-300 hover:bg-gray-100/90 py-2">
            <div>
                <h1 class=" text-2xl text-blue-900">Mother Information</h1>
            </div>
            <!-- Row 1 -->
            <div class="grid grid-cols-2 gap-2">
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Mother's Name:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.mother_name"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Mother's Occupation:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.mother_occupation"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Mother's Educational
                        Level:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.mother_educational_level"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Mother's No. of
                        Pregnancies:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.mother_no_of_pregnancies"></span>
                </div>
            </div>
        </div>

        {{-- Father INFORMATION --}}
        <div class=" border-b border-blue-700 space-y-2 px-4 py-2">
            <div>
                <h1 class=" text-2xl text-blue-900">Father Information</h1>
            </div>
            <!-- Row 1 -->
            <div class="grid grid-cols-2 gap-2">
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Father's Name:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.father_name"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Father's Occupation:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.father_occupation"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Father's Educational
                        Level:</span>
                    <span class="text-base font-semibold" x-text="childProfileData.father_educational_level"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- BIRTH INFORMATION --}}
    <div class=" space-y-2 px-4 py-2">
        <div>
            <h1 class=" text-2xl text-blue-900">Birth Information</h1>
        </div>
        <!-- Row 1 -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Birthdate:</span>
                <span class="text-base font-semibold" x-text="childProfileData.birthdate"></span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Gestational Age:</span>
                <span class="text-base font-semibold" x-text="childProfileData.gestational_age_at_birth"></span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Type of Birth:</span>
                <span class="text-base font-semibold" x-text="childProfileData.type_of_birth"></span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Birth Order:</span>
                <span class="text-base font-semibold" x-text="childProfileData.birth_order"></span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Birth Weight:</span>
                <span class="text-base font-semibold" x-text="childProfileData.weight"></span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Place of Delivery:</span>
                <span class="text-base font-semibold" x-text="childProfileData.place_of_delivery"></span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Birth Attendant:</span>
                <span class="text-base font-semibold" x-text="childProfileData.birth_attendant"></span>
            </div>
        </div>
    </div>


</div>