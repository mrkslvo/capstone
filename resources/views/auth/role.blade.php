<x-layout>
    <div class=" w-full h-screen relative overflow-hidden flex items-center justify-center">

        <img class=" h-[1440px] -top-50 absolute -right-80" src="storage/assets/bg.png" alt="">

        <div class="w-[80%] h-5/8 z-10 flex ">
            <div class="h-full  w-1/3 flex items-center justify-center flex-col gap-4 font-bold text-[#193378] ">
                <div class="flex items-center justify-center mb-8 gap-3">
                    <div>

                        <img class="w-15 h-15" src="storage/assets/logo.png" alt="">
                    </div>
                    <h1 class="text-2xl  font-bold text-center">PediaMat</h1>
                </div>
                <a href="/bhw/dashboard"
                    class="block w-4/5 text-center px-4 py-3 transition-all duration-200 border-2 border-[#193378] hover:bg-[#193378] hover:text-white rounded-3xl">
                    BHW
                </a>
                <a href="/bns/dashboard"
                    class="block w-4/5 text-center px-4 py-3 transition-all duration-200 border-2 border-[#193378] hover:bg-[#193378] hover:text-white rounded-3xl">
                    BNS
                </a>
                <a href="/rhu/reports"
                    class="block w-4/5 text-center px-4 py-3 transition-all duration-200 border-2 border-[#193378] hover:bg-[#193378] hover:text-white rounded-3xl">
                    RHU
                </a>
                <a href="/admin/dashboard"
                    class="block w-4/5 text-center px-4 py-3 transition-all duration-200 border-2 border-[#193378] hover:bg-[#193378] hover:text-white rounded-3xl">
                    MIDWIFE/NURSE
                </a>
                <a href="/parent/maternal-profiles"
                    class="block w-4/5 text-center px-4 py-3 transition-all duration-200 border-2 border-[#193378] hover:bg-[#193378] hover:text-white rounded-3xl">
                    PARENT
                </a>
            </div>
        </div>
    </div>
</x-layout>