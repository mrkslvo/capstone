<script setup>
const emit = defineEmits(["close"]);
</script>

<template>
  <transition
    enter-active-class="transition-transform duration-300"
    enter-from-class="translate-x-full"
    enter-to-class="translate-x-0"
    leave-active-class="transition-transform duration-300"
    leave-from-class="translate-x-0"
    leave-to-class="translate-x-full"
  >
    <div
      class="fixed top-0 right-0 w-[20%] h-full bg-red-400 shadow-lg z-10"
    >
      <button
        class="m-4 px-3 py-1 bg-white rounded shadow hover:bg-gray-100"
        @click="emit('close')"
      >
        Close
      </button>
    </div>
  </transition>
</template>
