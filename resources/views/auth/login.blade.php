<x-layout>
    <div class=" w-full h-screen relative overflow-hidden flex items-center justify-center">

        <img class=" h-[1440px] -top-50 absolute -right-80" src="storage/assets/bg.png" alt="">

        <div class=" absolute left-0 top-10 w-full z-10 flex items-center justify-center gap-4">
            <a href="/" class="flex items-center justify-center gap-4">
                <div>
                    <img class="w-15 h-15" src="storage/assets/logo.png" alt="">
                </div>
                <h1 class="text-3xl  font-bold text-center">PediaMat</h1>
            </a>
        </div>

        <div class="w-full md:w-[80%] h-5/8 z-10 flex ">
            <div class="h-full md:w-1/2  xl:w-1/3 w-full flex items-center justify-center flex-col gap-4">
                <h1 class=" font-bold text-[#193378] text-xl">Login</h1>

                <form action="{{ route('login') }}" method="post" class="w-3/4 space-y-4">
                    @csrf
                    <input type="text" placeholder="Name" name="username"
                        class="w-full px-4 py-2 border placeholder-[#193378]  border-[#193378] rounded-3xl focus:outline-none focus:ring-2 focus:ring-[#193378]" />
                    <input type="password" placeholder="Password" name="password"
                        class="w-full px-4 py-2 border placeholder-[#193378]  border-[#193378] rounded-3xl focus:outline-none focus:ring-2 focus:ring-[#193378]" />

                    <button type="submit"
                        class="w-full px-4 py-2 border text-white bg-[#193378] rounded-3xl cursor-pointer hover:bg-[#4b5d92] ">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>