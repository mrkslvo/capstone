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
                <span class="text-base font-semibold" x-text="maternalProfileData.birthdate"></span>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Spouse's Name</span>
                <span class="text-base font-semibold" x-text="maternalProfileData.spouse_name"></span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Civil Status</span>
                <span class="text-base font-semibold" x-text="maternalProfileData.civil_status"></span>
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
                <span class="text-base font-semibold" x-text="maternalProfileData.address"></span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Blood Type</span>
                <span class="text-base font-semibold text-gray-600" x-text="maternalProfileData.blood_type"></span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Contact No.</span>
                <span class="text-base font-semibold" x-text="maternalProfileData.philhealth_no"></span>
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
                <span class="text-base font-semibold" x-text="maternalProfileData.philhealth_no"></span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Family Serial No.</span>
                <span class="text-base font-semibold" x-text="maternalProfileData.family_serial_no"></span>
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
                <span class="text-base font-semibold" x-text="maternalProfileData.philhealth_no"></span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Password</span>
                <span class="text-base font-semibold" x-text="maternalProfileData.family_serial_no"></span>
            </div>

        </div>
    </div>


</div>