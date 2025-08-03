<div x-show="showMaternalPage"
    class="w-full absolute top-0 left-0 h-full bg-white text-gray-800 rounded-lg shadow-xl p-6 z-50 ">
    <!-- Header -->
    <div class="w-full flex items-center justify-between border-b border-blue-700 pb-4 px-4">
        <!-- Tabs -->
        <div class="space-x-2">
            <button @click="openMaternalProfile(); isSelected = 'maternalProfile'"
                :class="isBtnSelected('maternalProfile')" class="px-4 py-2 rounded-md font-semibold transition">
                Maternal Profile
            </button>
            <button @click="openMaternalRecord(); isSelected = 'maternalRecord'"
                :class="isBtnSelected('maternalRecord')" class="px-4 py-2 rounded-md font-semibold transition">
                Present Maternal Records
            </button>
            <button @click="openPastMaternalRecord(); isSelected = 'pastMaternalRecord'"
                :class="isBtnSelected('pastMaternalRecord')" class="px-4 py-2 rounded-md font-semibold transition">
                Past Maternal Records
            </button>
        </div>

        <!-- Close Button -->
        <button @click="showMaternalPage = false; hideMaternalprofile = true"
            class="text-3xl text-gray-500 hover:text-gray-800 transition">&times;</button>
    </div>
    @include('components.admin.maternalProfile.maternalProfileInfo')
    @include('components.admin.maternalProfile.presentPrenatalRecord')
    @include('components.admin.maternalProfile.pastMaternalRecord')
    @include('components.admin.maternalProfile.viewAllPrenatalRecord')
    @include('components.admin.maternalProfile.addPrenatalRecord')
</div>
