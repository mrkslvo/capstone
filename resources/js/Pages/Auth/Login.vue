<script setup>
import login from '../../../images/login.jpg'
import logo from '../../../images/logo.png'
import TextInput from '../Components/TextInput.vue'

import { useForm } from '@inertiajs/vue3';

const form = useForm({
    username: '',
    password: '',
})

const submit = () => {
    form.post(route("login"), {
        onSuccess: () => {
            form.reset();
        },
    });
}

</script>

<template>

    <Head title="Login" />
    <div class="h-full flex items-center justify-center relative overflow-hidden">
        <!-- Background image -->
        <div class="absolute inset-0">
            <img :src="login" alt="Login Background" class="w-full h-full object-cover">
        </div>
        <div class=" w-full md:w-[65%] px-3 mx-auto flex items-center justify-center md:justify-end ">
            <div class=" bg-white shadow-xl rounded-lg w-full max-w-md p-8 z-10 col-span-1">
                <!-- Logo and Title -->
                <div class="flex items-center justify-center gap-2 mb-6">
                    <div class=" w-10">
                        <img :src="logo" alt="">
                    </div>
                    <h1 class="text-3xl font-bold mt-2">PediaMat</h1>
                </div>

                <!-- Welcome Message -->
                <h2 class="text-center text-lg font-bold">Welcome Back!</h2>
                <p class="text-center text-gray-500 mb-6 text-sm">Please enter your credentials to log in.</p>

                <!-- Login Form -->
                <form @submit.prevent="submit" class="space-y-4">
                    <!-- CSRF Token if using Laravel -->

                    <!-- Username -->
                    <TextInput placeholder="Username" name="username" v-model="form.username"
                        :message="form.errors.username" />
                    <TextInput type="password" placeholder="Password" name="password" v-model="form.password"
                        :message="form.errors.password" />

                    <!-- Sign In Button -->
                    <button type="submit" :disabled="form.processing" :class="[
                        'w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition',
                        form.processing ? 'cursor-wait bg-blue-500' : 'hover:bg-blue-700 cursor-pointer'
                    ]">
                        <span v-if="form.processing">Logging In...</span>
                        <span v-else>Login</span>
                    </button>
                </form>

                <!-- Footer -->
                <p class="mt-6 text-center text-xs text-gray-400">&copy; 2024 PediaMat. All rights reserved.</p>
            </div>
        </div>

    </div>

</template>
