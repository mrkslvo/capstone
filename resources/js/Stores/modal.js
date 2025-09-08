// stores/modal.js
import { defineStore } from "pinia";
import { ref,shallowRef } from "vue";

export const useModalStore = defineStore("modal", () => {
    const isOpen = shallowRef(false);
    const component = shallowRef(null);
    const props = ref({});

    function openModal(modalComponent, modalProps = {}) {
        component.value = modalComponent;
        props.value = modalProps;
        isOpen.value = true;
    }

    function closeModal() {
        isOpen.value = false;
        component.value = null;
        props.value = {};
    }

    return { isOpen, component, props, openModal, closeModal };
});
