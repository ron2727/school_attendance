<template>
   <MainContainer page-title="Students">
      <div class="bg-white p-5 rounded">
         <ButtonAdd :href="route('student.create')">
            Add new student
         </ButtonAdd>
         <div class="wrapper-search w-64 mt-5 mb-4">
            <InputComponent v-model="search" input-label="Search" input-name="search" input-place-holder="Search student..." />
         </div>
         <div class=" grid grid-cols-4 gap-5 mb-5" v-if="students.data.length">
            <Card v-for="student in students.data">
               <template #head>
                  <div class=" bg-indigo-600 py-3">
                     <div class=" w-14 h-14 rounded-full bg-white mx-auto"></div>
                  </div>
               </template>
               <template #body>
                  <h6 class=" text-sm py-3 text-gray-500 font-bold text-center">{{ student.firstName + ' ' + student.lastName}}</h6>
                  <div class=" py-3 flex justify-center space-x-2">
                     <Link :href="route('student.edit', { student: student.id })" as="button" type="button" class=" text-xs text-green-600">Edit</Link>
                     <Link :href="route('student.edit', { student: student.id })" as="button" type="button" class=" text-xs text-red-600">Delete</Link>
                  </div>
               </template>
            </Card>
         </div>
         <NoDataMessage v-else>No result found</NoDataMessage>
         <Pagination v-if="students.data.length" :links="students.links" />
      </div>
   </MainContainer>
</template>

<script setup> 
import InputComponent from '../../Shared/InputComponent.vue';
import Pagination from '../../Shared/Pagination.vue';
import NoDataMessage from '../../Shared/NoDataMessage.vue';
import Card from '../../Shared/Card.vue';
import ButtonAdd from '../../Shared/ButtonAdd.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue'  
import { debounce } from 'lodash';

 
const props = defineProps({
    students: Object,
    filters: String,
})

const search = ref(props.filters)


watch(search, debounce((newValue) => {
   router
   .get(
         route('student.index'), 
         {
             search: newValue
         }, 
         {
            preserveScroll: true,
            preserveState: true
         })
}, 500));
</script>