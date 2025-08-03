{{-- Past Maternal Record --}}
<div x-show="showPastMaternalRecord">
    <!-- Right Panel: Prenatal Records -->
    <div>
        <div class="my-4">
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.4 0-8-3.6-8-8s3.6-8 8-8 8 3.6 8 8-3.6 8-8 8zm1-13h-2v6h6v-2h-4z" />
                </svg>
                Previous Prenatal Records
            </h3>
        </div>

        <!-- Sample Static Records (You can loop dynamic ones later) -->
        <div class="text-sm text-gray-700 grid grid-cols-3 gap-3">
            <div class="bg-gray-100 p-4 rounded-lg flex items-center gap-3">
                <div><img src="/storage/assets/file.png" alt=""></div>
                <div>
                    <p class="font-semibold">Prenatal Record 1: July 15, 2023</p>

                </div>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg flex items-center gap-3">
                <div><img src="/storage/assets/file.png" alt=""></div>
                <div>
                    <p class="font-semibold">Prenatal Record 2: July 15, 2023</p>

                </div>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg flex items-center gap-3">
                <div><img src="/storage/assets/file.png" alt=""></div>
                <div>
                    <p class="font-semibold">Prenatal Record 3: July 15, 2023</p>

                </div>
            </div>
        </div>
    </div>
</div>