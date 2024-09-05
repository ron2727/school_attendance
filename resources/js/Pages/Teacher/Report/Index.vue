<template>
   <MainContainer page-title="Report">
      <div class="bg-white p-5 rounded">  
         <div class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-5" v-if="classes.length">
           <Link  v-for="teacherClass in classes" 
                  :key="teacherClass.id" 
                  :href="route('teacher.report.generate', {class: teacherClass.id})">
            <Card>
               <template #head>
                  <div class=" flex items-center p-3 space-x-2 bg-indigo-600 rounded-t-lg">
                      <box-icon type='solid' name='book-content' color="white" size="sm"></box-icon>
                      <h6 class=" text-lg font-bold text-white">{{ teacherClass.subject }}</h6>
                  </div>
               </template>
               <template #body> 
                  <div class=" p-3 space-y-2">
                      <div class=" text-xs text-gray-500 ">
                         <span class="font-bold">Academic year:</span>
                         {{ teacherClass.academic_year}}
                      </div>
                      <div class=" text-xs text-gray-500 ">
                         <span class="font-bold">Time:</span>
                         {{ teacherClass.time_from + ' - ' + teacherClass.time_to}}
                      </div>
                  </div>
               </template>
            </Card>
           </Link>
         </div>
         <NoDataMessage v-else>No class found</NoDataMessage> 
      </div>
   </MainContainer>
</template>

<script setup>  
import NoDataMessage from '../../Shared/NoDataMessage.vue';
import Card from '../../Shared/Card.vue'; 
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    classes: Array, 
}) 
</script>