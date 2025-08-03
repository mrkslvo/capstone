<!-- ✅ Success Modal -->
<div x-show="showSuccess" x-cloak
    class="fixed inset-0 flex items-center justify-center bg-black/40 bg-opacity-50 z-[999]">
    <div x-show="showSuccess" x-transition class="bg-white px-6 py-4 rounded-lg shadow-lg max-w-sm w-full text-center">
        <p class="text-green-600 font-semibold text-lg" x-text="successMessage"></p>
    </div>
</div>