<!-- SHOW CHILD'S MOTHER -->
<div x-show="showChildMother">
    <div x-show="showChildMother" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
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
                    <span class="text-base font-semibold" x-text="modalMaternalProfile.name"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Age</span>
                    <span class="text-base font-semibold" x-text="modalMaternalProfile.age"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Birthdate</span>
                    <span class="text-base font-semibold" x-text="modalMaternalProfile.birthdate"></span>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Spouse's Name</span>
                    <span class="text-base font-semibold" x-text="modalMaternalProfile.spouse_name"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Civil Status</span>
                    <span class="text-base font-semibold" x-text="modalMaternalProfile.civil_status"></span>
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
                    <span class="text-base font-semibold" x-text="modalMaternalProfile.address"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Blood Type</span>
                    <span class="text-base font-semibold text-gray-600">—</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Contact No.</span>
                    <span class="text-base font-semibold" x-text="modalMaternalProfile.philhealth_no"></span>
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
                        <span class="text-base font-semibold" x-text="modalMaternalProfile.philhealth_no"></span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-medium text-gray-500">Family Serial No.</span>
                        <span class="text-base font-semibold" x-text="modalMaternalProfile.family_serial_no"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>