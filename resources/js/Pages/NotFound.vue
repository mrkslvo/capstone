<script setup>
import { CircleAlert, ArrowLeft } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="fixed inset-0 flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-200">
        <div class="bg-white shadow-xl rounded-2xl px-8 py-12 max-w-md text-center">
            <!-- Icon -->
            <div class="flex items-center justify-center w-16 h-16 mx-auto rounded-full bg-blue-100 text-blue-600">
                <CircleAlert class="w-8 h-8" />
            </div>

            <!-- Title -->
            <h1 class="mt-6 text-3xl font-bold text-gray-800">
                Page not found
            </h1>

            <!-- Subtitle -->
            <p class="mt-3 text-gray-500 text-base leading-relaxed">
                Sorry, the page you are looking for doesn’t exist or has been moved.
            </p>

            <!-- Button -->
            <div class="mt-8">
                <Link href="/"
                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 transition duration-300">
                <ArrowLeft class="w-4 h-4 mr-2" />
                Go back home
                </Link>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Smooth fade-in effect */
div {
    animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
