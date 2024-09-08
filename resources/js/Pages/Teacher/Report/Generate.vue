<template>
    <MainContainer page-title="Report / Generate">
        <div class=" max-w-xl bg-white p-5 rounded"> 
            <div class="flex justify-between">
               <InputComponent v-model="search" input-label="Date" input-name="date" input-type="date"/>
               <div class="flex flex-col" v-if="generated.length">
                  <span class=" text-xs md:text-sm text-gray-500 mt-1 mb-2 font-bold">Export to</span>
                  <div class="flex space-x-2"> 
                     <ExportButton route-name="teacher.report.generated" :fields="exportFields('pdf')" color="bg-red-600">PDF</ExportButton>
                     <ExportButton route-name="teacher.report.generated" :fields="exportFields('excel')" color="bg-green-600">Excel</ExportButton>
                   </div>
               </div> 
            </div>
            <div class="border border-b-0 border-gray-200 rounded-md my-5">
                <table class=" border-collapse w-full overflow-hidden">
                    <thead>
                        <tr class=" text-gray-600 text-xs md:text-sm font-bold border-b border-b-gray-200">  
                            <td class=" px-3 py-2">Student</td>
                            <td class=" px-3 py-2">Status</td>
                            <td class=" px-3 py-2">Attendance date</td> 
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="generated.length" 
                            v-for="generate in generated" 
                            class=" text-gray-500 border-b border-b-gray-200 even:bg-gray-50">
                            <td class=" px-3 py-2 text-xs md:text-sm">{{ generate.student.firstName + ' ' + generate.student.lastName}}</td>
                            <td class=" px-3 py-2 text-xs md:text-sm">{{ generate.status }}</td>
                            <td class=" px-3 py-2 text-xs md:text-sm">{{ generate.date}} </td> 
                        </tr>
                        <tr v-else>
                            <td class=" border-b border-gray-200" colspan="6">
                                <NoDataMessage>No result found</NoDataMessage>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> 
        </div>
    </MainContainer>
</template>

<script setup>
import InputComponent from '../../Shared/InputComponent.vue'; 
import NoDataMessage from '../../Shared/NoDataMessage.vue';
import ExportButton from '../../Shared/ExportButton.vue'; 
import { router } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue'  
import { debounce } from 'lodash'; 

 
const props = defineProps({
    generated: Array, 
    teacherClass: Object,
    filters: String,
})

const search = ref(props.filters);

onMounted(() => {
    if (!props.filters) {
        search.value = getDateToday();
    }
})
  
watch(search, debounce((newValue) => {
    router
   .get(
          route('teacher.report.generate', {class: props.teacherClass.id}), 
         {
             search: newValue
         }, 
         {
            preserveScroll: true,
            preserveState: true
       });

}, 500)); 

const getDateToday = () => {
    const today = new Date(); 

    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}

const exportFields = (export_type) => {
     
     return {
              class_id: props.teacherClass.id,
              date: search.value,  
              export_type: export_type,
            };
}
</script>

 