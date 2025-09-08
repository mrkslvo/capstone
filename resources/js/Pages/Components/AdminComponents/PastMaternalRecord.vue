<script setup>
import { inject, computed } from 'vue'
import { FileCheck } from 'lucide-vue-next'
import PastMaternalRecordWithPrenatalPostnatal from './PastMaternalRecordWithPrenatalPostnatal.vue'

import { useModalStore } from "@/stores/modal"
import ModalWrapper from '../ModalWrapper.vue'
const modal = useModalStore()

function open(record) {
    modal.openModal(PastMaternalRecordWithPrenatalPostnatal, { record })
}

const selectedMaternalProfile = inject("selectedMaternalProfile")
// Only past maternal records
const records = computed(() =>
    (selectedMaternalProfile.value?.maternal_records ?? [])
        .filter(r => r.isPresent === "no")
)
</script>

<template>
    <div class=" p-2 rounded-2xl w-full ">
        <h3 class="text-2xl font-bold text-blue-700 mb-3">
            Past Maternal Records
        </h3>

        <div v-if="records.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <div v-for="(record, index) in records" :key="record.id"
                class="p-5 bg-gradient-to-br from-blue-50 to-white border rounded-2xl shadow-md cursor-pointer transform hover:scale-[1.01] hover:shadow-lg transition-all duration-300 flex items-center gap-2"
                @click="open(record)">
                <FileCheck class=" w-10 h-10 text-blue-500" />
                <div>

                    <h4 class="text-lg font-semibold text-gray-800">
                        Maternal Record #{{ index + 1}}
                    </h4>
                    <p class="text-gray-500 text-sm">Click to view details</p>
                </div>
            </div>
        </div>

        <div v-else class="text-center py-10 text-gray-500">
            No past maternal records found.
        </div>

        <!-- Modal Wrapper -->
        <ModalWrapper />
    </div>
</template>
