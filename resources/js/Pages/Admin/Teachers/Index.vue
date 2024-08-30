<template>
   <MainContainer page-title="Teachers">
      <div class="bg-white p-5 rounded">
         <ButtonAdd :href="route('teacher.create')">
            Add new teacher
         </ButtonAdd>
         <div class="wrapper-search w-64 mt-5 mb-4">
            <InputComponent v-model="search" input-label="Search" input-name="search" input-place-holder="Search teacher..." />
         </div>
         <div class=" grid grid-cols-4 gap-5 mb-5" v-if="teachers.data.length">
            <Card v-for="teacher in teachers.data">
               <template #head>
                  <div class=" bg-indigo-600 py-3">
                     <div class=" w-14 h-14 rounded-full bg-white mx-auto"></div>
                  </div>
               </template>
               <template #body>
                  <h6 class=" text-sm py-3 text-gray-500 font-bold text-center">{{ teacher.firstName + ' ' + teacher.lastName}}</h6>
                  <div class=" py-3 flex justify-center space-x-2">
                     <Link :href="route('teacher.edit', { teacher: teacher.id })" as="button" type="button" class=" text-xs text-green-600">Edit</Link>
                     <Link :href="route('teacher.edit', { teacher: teacher.id })" as="button" type="button" class=" text-xs text-red-600">Delete</Link>
                  </div>
               </template>
            </Card>
         </div>
         <NoDataMessage v-else>No result found</NoDataMessage>
         <Pagination v-if="teachers.data.length" :links="teachers.links" />
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
    teachers: Object,
    filters: String,
})

const search = ref(props.filters)


watch(search, debounce((newValue) => {
   router
   .get(
         route('teacher.index'), 
         {
             search: newValue
         }, 
         {
            preserveScroll: true,
            preserveState: true
         })
}, 500));
</script>