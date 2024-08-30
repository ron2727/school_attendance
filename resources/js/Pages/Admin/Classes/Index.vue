<template>
    <MainContainer page-title="Classes">
        <div class=" bg-white p-5 rounded">
           <ButtonAdd :href="route('classes.create')">
              Add new class
           </ButtonAdd>
           <div class="wrapper-search w-64 mt-5 mb-4 space-y-3">
             <InputComponent v-model="search" input-label="Search" input-name="search" input-place-holder="Search class..." />

             <SelectDateYear v-model="academic_year" label="Academic Year"/>
           </div>
           <!-- <div class=" grid grid-cols-4 gap-5 mb-5" v-if="teachers.data.length">
            <Link  v-for="teacher in teachers.data" :key="teacher.id" :href="route('teacher.edit', { teacher: teacher.id })" as="a">
            <Card>
               <template #head>
                  <div class=" bg-indigo-600 py-3">
                     <div class=" w-14 h-14 rounded-full bg-white mx-auto"></div>
                  </div>
               </template>
               <template #body>
                  <h6 class=" text-sm py-3 text-gray-500 font-bold text-center">{{ teacher.firstName + ' ' + teacher.lastName}}</h6>
                  <div class="p-2">
                     <p class=" text-xs text-gray-500 mb-2"><span class="font-bold">Classes</span>: {{ getClasses(teacher.classes) }}</p> 
                     <p class=" text-xs text-gray-500"><span class="font-bold">Academic year</span>: {{ teacher.classes[0]?.academic_year }}</p> 
                  </div>
               </template>
            </Card>
            </Link> 
           </div>
           <NoDataMessage v-else>No result found</NoDataMessage>
           <Pagination v-if="teachers.data.length" :links="teachers.links" /> -->
        </div>
    </MainContainer>
</template>

<script setup>
import InputComponent from '../../Shared/InputComponent.vue';
import Pagination from '../../Shared/Pagination.vue';
import NoDataMessage from '../../Shared/NoDataMessage.vue';
import Card from '../../Shared/Card.vue';
import ButtonAdd from '../../Shared/ButtonAdd.vue';
import SelectDateYear from '../../Shared/SelectDateYear.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue'  
import { debounce } from 'lodash';
import { forEach } from 'lodash';

 
const props = defineProps({
    classes: Object,
    filters: Object,
})

const search = ref(props.filters.search);
const academic_year = ref(props.filters.academic_year);

watch(search, debounce((newValue) => {
   submitFilter(newValue, academic_year.value)
}, 500));

watch(academic_year, debounce((newValue) => {
    submitFilter(search.value, newValue)
}, 500));

const submitFilter = (searchVal, academicYearVal) => {
    router
   .get(
         route('classes.index'), 
         {
             search: searchVal,
             academic_year: academicYearVal
         }, 
         {
            preserveScroll: true,
            preserveState: true
         })
}

const getClasses = (classes) => {
      const classSubject = classes.map(schoolClass => schoolClass.subject)
      const uniqueClasses = [...new Set(classSubject)].join(', ')
      return uniqueClasses;
}
</script>

 