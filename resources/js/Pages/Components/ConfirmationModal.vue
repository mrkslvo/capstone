<script setup>
const props = defineProps({
    show: Boolean,
    title: { type: String, default: "Confirm Action" },
    name: { type: String, default: "none" },
    message: { type: String, default: "Are you sure?" },
});

const emit = defineEmits(["confirm", "cancel"]);
</script>

<template>
    <div v-if="show" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
        <div class="bg-white rounded-xl shadow-lg p-6 w-[90%] max-w-md">
            <h2 class="text-lg uppercase  font-semibold mb-2"><span class="text-green-500">{{ name }}</span> {{ title }}</h2>
            <p class="text-gray-600 mb-4">{{ message }}</p>

            <div class="flex justify-end gap-3">
                <button class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400" @click="$emit('cancel')">
                    Cancel
                </button>
                <button class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700" @click="$emit('confirm')">
                    Yes, Confirm
                </button>
            </div>
        </div>
    </div>
</template>
