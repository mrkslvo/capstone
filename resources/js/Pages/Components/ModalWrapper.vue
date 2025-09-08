<!-- components/ModalWrapper.vue -->
<script setup>
import { useModalStore } from '@/stores/modal'
const modal = useModalStore()
</script>


<template>
    <Teleport to="body">
        <div v-if="modal.isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div>
                <component :is="modal.component" v-bind="modal.props" />
            </div>
        </div>
    </Teleport>
</template>
