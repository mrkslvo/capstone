<script setup>
const model = defineModel({
    type: null,
    required: true,
});

defineProps({
    name: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: "text",
    },

    placeholder: String,
    message: String,
});
</script>

<template>
    <div class="w-full">
        <label class="block mb-1 text-sm font-medium ">
            {{ placeholder }}
        </label>

        <div class="relative">
            <!-- Prefix only for contact_number -->
            <span
                v-if="name === 'contact_number'"
                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-sm"
            >
                63+
            </span>

            <!-- Input -->
            <input
                v-model="model"
                :type="type"
                :name="name"
                class="shadow-xs bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5"
                :class="[
                    { '!ring-red-500 border-red-500': message },
                    name === 'contact_number' ? 'pl-10' : '',
                ]"
                :placeholder="placeholder"
            />
        </div>

        <!-- Error -->
        <small v-if="message" class="text-red-500">{{ message }}</small>
    </div>
</template>
