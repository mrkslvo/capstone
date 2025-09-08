<script setup>
// MODAL STATE
import { useModalStore } from '@/stores/modal'
const modal = useModalStore()
function close() {
    modal.closeModal()
}

import { ref, watch, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "../TextInput.vue";
import SelectInput from '../SelectInput.vue';
import SuccessModal from "../SuccessModal.vue";
const showSuccess = ref(false);
const successMessage = ref("");

const props = defineProps({
    user: {
        type: Object
    }
});

// Role options
const roleOption = [
    { value: "admin", label: "Admin" },
    { value: "bns", label: "BNS" },
    { value: "rhu", label: "RHU" },
    { value: "parent", label: "Parent" },
    { value: "bhw", label: "BHW" },
];

// Form using useForm
const form = useForm({
    firstname: "",
    lastname: "",
    role: "",
    purok: "",
    username: "",
    contact_number: "",
    password: "",
    password_confirmation: "",
});

// Prefill form if editing
onMounted(() => {
    if (props.user) {
        form.firstname = props.user.firstname || "";
        form.lastname = props.user.lastname || "";
        form.role = props.user.role || "";
        form.purok = props.user.purok || "";
        form.username = props.user.username || "";
        form.contact_number = props.user.contact_number || "";
        // Password fields left empty for security
    }
});


// Submit form
const submitForm = () => {
    if (props.user) {
        // Update existing user
        form.put(route("user.update", props.user.id), {
            onSuccess: () => {
                successMessage.value = "User update successfully!";
                showSuccess.value = true; // show modal
                form.reset();
            },
        });
    } else {
        // Create new user
        form.post(route("user.store"), {
            onSuccess: () => {
                successMessage.value = "User added successfully!";
                showSuccess.value = true; // show modal
                form.reset();
            },
        });
    }
};

</script>

<template>
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 px-4">
        <div class="bg-white rounded-2xl shadow-lg w-full max-w-lg p-6 relative">
            <h2 class="text-2xl font-semibold mb-5 text-gray-800 text-center">
                {{ props.user ? "Update User" : "Register User" }}
            </h2>

            <form @submit.prevent="submitForm" class="flex flex-col gap-4">
                <div class=" grid grid-cols-2 gap-2">
                    <TextInput placeholder="Firstname" name="firstname" v-model="form.firstname"
                        :message="form.errors.firstname" />
                    <TextInput placeholder="Lastname" name="lastname" v-model="form.lastname"
                        :message="form.errors.lastname" />
                </div>
                <div class=" grid grid-cols-2 gap-2">
                    <TextInput placeholder="Purok" name="purok" v-model="form.purok" :message="form.errors.purok" />
                    <SelectInput v-model="form.role" placeholder="Select Role" name="role" :options="roleOption"
                        :message="form.errors.role" />
                </div>
                <div class=" grid grid-cols-2 gap-2">
                    <TextInput placeholder="Username" name="username" v-model="form.username"
                        :message="form.errors.username" />
                    <TextInput placeholder="Contact No." name="contact_number" v-model="form.contact_number"
                        :message="form.errors.contact_number" />
                </div>

                <div class=" grid grid-cols-2 gap-2">
                    <!-- Passwords only required for adding -->
                    <TextInput v-if="!props.user" placeholder="Password" name="password" type="password"
                        v-model="form.password" :message="form.errors.password" />
                    <TextInput v-if="!props.user" placeholder="Confirm Password" name="password_confirmation"
                        type="password" v-model="form.password_confirmation" />
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" @click="close"
                        class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 text-gray-800">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 text-white">
                        {{ form.processing ? 'Saving...' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- ✅ Success Modal OUTSIDE the form modal -->
    <SuccessModal :show="showSuccess" :message="successMessage" @close="
        showSuccess = false;
    location.reload();
    " />
</template>
