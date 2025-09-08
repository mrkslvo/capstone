<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    show: { type: Boolean, default: false },
    message: { type: String, default: "Action completed successfully!" },
    duration: { type: Number, default: 2000 },
});

const emit = defineEmits(["close", 'closeAddMaternalProfile']);
const isVisible = ref(props.show);

watch(
    () => props.show,
    (newVal) => {
        isVisible.value = newVal;
        if (newVal && props.duration > 0) {
            setTimeout(() => {
                close();
                location.reload();
            }, props.duration);
        }
    }
);

function close() {
    location.reload();
    isVisible.value = false;
    emit("close");
}
</script>

<template>
    <transition name="fade">
        <div
            v-if="isVisible"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50"
        >
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center max-w-sm w-full">
                <div class="text-green-600 text-4xl mb-2">✔</div>
                <h2 class="text-lg font-semibold text-gray-800">{{ message }}</h2>
                <button
                    @click="close"
                    class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                >
                    OK
                </button>
            </div>
        </div>
    </transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
