<script setup>
const modelValue = defineModel({
    // this is the value controlled by v-model
    type: [String, Number, null],
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
    placeholder: {
        type: String,
        default: "",
    },
    message: String,
    options: {
        type: Array, // [{ value: 'A+', label: 'A+' }, ...]
        default: () => [],
    },
});
</script>
<template>
    <div class="w-full">

          <label class="block mb-1 text-sm font-medium text-gray-700">
            {{ placeholder }}
        </label>
        <select
            v-model="modelValue"
            :name="name"
            class="border rounded px-3 py-2 w-full bg-transparent"
        >
            <option v-for="opt in options" :key="opt.value" :value="opt.value">
                {{ opt.label }}
            </option>
        </select>

        <p v-if="message" class="text-sm text-red-600 mt-1">
            {{ message }}
        </p>
    </div>
</template>
