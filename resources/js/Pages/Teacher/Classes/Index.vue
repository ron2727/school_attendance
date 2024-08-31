<template>
    <MainContainer page-title="My Classes">
       <div class="bg-white p-5 rounded">  
          <!-- <div class=" grid grid-cols-4 gap-5 mb-5" v-if="classes.data.length">
             <Card v-for="teacherClass in classes.data">
                <template #head>
                   <div class=" bg-indigo-600 py-3">
                       <h6>{{ teacherClass.class }}</h6>
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
          <NoDataMessage v-else>No class found</NoDataMessage>  -->
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
     classes: Object, 
 }) 
 </script>