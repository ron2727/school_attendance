<template>
    <div v-if="modalShow" ref="modal" @click="closeModal($event)" class="modal fixed top-0 left-0 z-[999999] flex justify-center w-screen h-screen overflow-hidden text-gray-700 bg-black/20">
       <div class="modal-dialog max-w-96 w-full mt-16 h-max">
          <div ref="modalContent" class="modal-content flex flex-col bg-white border rounded-lg divide-y">
            <div class="modal-header flex justify-between items-center py-2 px-4"> 
               <h4 class="modal-title text-lg font-bold">{{title}}</h4>
               <button type="button" @click="$emit('closeModal')"><box-icon name='x' size="sm"></box-icon></button>
            </div>
            <div class="modal-body max-h-80 p-4 overflow-y-auto">
               <slot name="body"></slot>
            </div>
            <div class="modal-footer p-4">
                <slot name="footer"></slot>
            </div>
          </div>
       </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
defineProps({
    title: String,
    modalShow: Boolean
})
const emits = defineEmits(['closeModal']);

const modal = ref(null);  

const closeModal = (event) => {
    if (event.target === modal.value) {
       emits('closeModal')
    } 
}

</script>
 