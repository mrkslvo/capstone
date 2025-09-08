<script setup>
import { ref } from 'vue'
import PostnatalRecord from './PostnatalRecord.vue'
import PrenatalRecord from './PrenatalRecord.vue'

const showPrenatalRecord = ref(true)   // ✅ default is Prenatal
const showPostnatalRecord = ref(false)

const openPostnatalRecord = () => {
  showPostnatalRecord.value = true
  showPrenatalRecord.value = false
}

const openPrenatalRecord = () => {
  showPrenatalRecord.value = true
  showPostnatalRecord.value = false
}
</script>

<template>
  <div>
    <!-- Show Prenatal first -->
    <PrenatalRecord
      v-if="showPrenatalRecord"
      @openPostnatal="openPostnatalRecord"
    />

    <PostnatalRecord
      v-if="showPostnatalRecord"
      @openPrenatal="openPrenatalRecord"
    />
  </div>
</template>
