<template>
    <MainContainer page-title="Classes">
        <div class=" bg-white p-5 rounded">
            <ButtonAdd :href="route('classes.create')">
                Add new class
            </ButtonAdd>
            <div class="wrapper-search w-64 mt-5 mb-4 space-y-3">
                <InputComponent v-model="search" input-label="Search" input-name="search" input-place-holder="Search class..." />

                <SelectDateYear v-model="academic_year" label="Academic Year" />
            </div>
            <div class="border border-b-0 border-gray-200 rounded-md mb-5">
                <table class=" table-auto border-collapse w-full overflow-hidden">
                    <thead>
                        <tr class=" text-gray-600 text-sm font-bold border-b border-b-gray-200">
                            <td class=" px-3 py-2">Subject</td>
                            <td class=" px-3 py-2">Teacher</td>
                            <td class=" px-3 py-2">Grade & Section</td>
                            <td class=" px-3 py-2">Time</td>
                            <td class=" px-3 py-2">Academic Year</td> 
                        </tr>
                    </thead>
                    <tbody>
<!--                         
                        <Link :href="route('classes.edit', {class: teacherClass.id})" as="a"> -->
                        <Link
                            as="tr"
                            v-if="classes.data.length" 
                            v-for="teacherClass in classes.data"
                           :href="route('classes.edit', {class: teacherClass.id})"
                            class=" text-gray-500 border-b border-b-gray-200 cursor-pointer hover:bg-gray-50 even:hover:bg-gray-100 even:bg-gray-50">
                            <td class=" px-3 py-2 text-sm">{{ teacherClass.subject }}</td>
                            <td class=" px-3 py-2 text-sm">{{ teacherClass.user.firstName + ' ' +
                                teacherClass.user.lastName}}</td>
                            <td class=" px-3 py-2 text-sm">{{ teacherClass.grade_section }}</td>
                            <td class=" px-3 py-2 text-sm">{{ teacherClass.time_from + ' - ' + teacherClass.time_to }}
                            </td>
                            <td class=" px-3 py-2 text-sm">{{ teacherClass.academic_year }}</td>
                            <td class=" px-3 py-2 text-sm">
                                <box-icon name='chevron-right' color="indigo" type='solid' size="sm"></box-icon>
                            </td>
                        </Link>
                        <!-- </Link> -->
                        <tr v-else>
                            <td class="border-b border-b-gray-200" colspan="6">
                                <NoDataMessage>No result found</NoDataMessage>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination v-if="classes.data.length" :links="classes.links" />
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

 