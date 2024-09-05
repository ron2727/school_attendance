<template>
   <MainContainer page-title="Teachers">
      <div class="bg-white p-5 rounded">
         <ButtonAdd :href="route('teacher.create')">
            Add new teacher
         </ButtonAdd>
         <div class="wrapper-search flex items-end space-x-2 w-64 mt-5 mb-4">
            <InputComponent v-model="search" input-label="Search" input-name="search" input-place-holder="Search student..." />
            <FilterInput v-model="trashed"/>
         </div>
         <div class=" grid grid-cols-4 gap-5 mb-5" v-if="teachers.data.length">
            <Link v-for="teacher in teachers.data" :key="teacher.id" :href="route('teacher.edit', { teacher: teacher.id })" as="button" type="button" class=" text-xs text-green-600">
            <Card>
               <template #head>
                  <div class=" relative bg-indigo-600 py-3 rounded-t-lg">
                     <div class="mx-auto w-12 h-12 bg-white rounded-full flex justify-center items-center">
                        <box-icon type='solid' name='user' color="indigo" size="sm"></box-icon>
                     </div>
                     <box-icon v-if="teacher.deleted_at" type='solid' name='trash-alt' color="white" size="sm" class="absolute top-0 right-0 m-2" ></box-icon>
                  </div>
               </template>
               <template #body>
                  <h6 class=" text-sm py-3 text-gray-500 font-bold text-center">{{ teacher.firstName + ' ' + teacher.lastName}}</h6>
               </template>
            </Card>
            </Link>
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
import FilterInput from '../../Shared/FilterInput.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue'  
import { debounce } from 'lodash';

 
const props = defineProps({
    teachers: Object,
    filters: Object,
})

const search = ref(props.filters.search)
const trashed = ref(props.filters.trashed)


watch(search, debounce((newValue) => {
    filter({search: newValue, trashed: trashed.value})
}, 500));
watch(trashed, debounce((newValue) => {
    filter({search: search.value, trashed: newValue})
}, 500));

const filter = (filter) => {
   router.get(route('teacher.index'), filter, 
         {
            preserveScroll: true,
            preserveState: true
         })
}
</script>