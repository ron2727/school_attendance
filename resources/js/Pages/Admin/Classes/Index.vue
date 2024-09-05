<template>
    <MainContainer page-title="Classes">
        <div class=" bg-white p-5 rounded">
            <ButtonAdd :href="route('classes.create')">
                Add new class
            </ButtonAdd>
            <div class="wrapper-search w-52 md:w-64 mt-5 mb-4 space-y-3">
                <div class=" flex items-end space-x-1">
                    <InputComponent v-model="search" input-label="Search" input-name="search" input-place-holder="Search class..." />
                    <FilterInput v-model="trashed"/>
                </div> 
                <SelectDateYear v-model="academic_year" label="Academic Year" />
            </div>
            <div class="w-full mb-5 overflow-x-auto"> 
              <div class="w-max md:w-full border border-b-0 border-gray-200 rounded-md">
                <table class=" table-auto border-collapse w-max md:w-full overflow-hidden">
                    <thead>
                        <tr class=" text-gray-600 text-xs md:text-sm font-bold border-b border-b-gray-200">
                            <td class=" px-3 py-2">Subject</td>
                            <td class=" px-3 py-2">Teacher</td>
                            <td class=" px-3 py-2">Grade & Section</td>
                            <td class=" px-3 py-2">Time</td>
                            <td class=" px-3 py-2">Academic Year</td> 
                        </tr>
                    </thead>
                    <tbody> 
                        <Link
                            as="tr"
                            v-if="classes.data.length" 
                            v-for="teacherClass in classes.data"
                            :href="route('classes.edit', {class: teacherClass.id})"
                            class=" text-gray-500 border-b border-b-gray-200 cursor-pointer hover:bg-gray-50 even:hover:bg-gray-100 even:bg-gray-50">
                            <td class=" px-3 py-2 text-xs md:text-sm">{{ teacherClass.subject }}  <box-icon v-if="teacherClass.deleted_at" type='solid' name='trash-alt' color="gray" size="xs"></box-icon></td>
                            <td class=" px-3 py-2 text-xs md:text-sm">{{ teacherClass.user.firstName + ' ' +
                                teacherClass.user.lastName}}</td>
                            <td class=" px-3 py-2 text-xs md:text-sm">{{ teacherClass.grade_section }}</td>
                            <td class=" px-3 py-2 text-xs md:text-sm">{{ teacherClass.time_from + ' - ' + teacherClass.time_to }}
                            </td>
                            <td class=" px-3 py-2 text-xs md:text-sm">{{ teacherClass.academic_year }}</td>
                            <td class=" px-3 py-2 text-xs md:text-sm">
                                <box-icon name='chevron-right' color="indigo" type='solid' size="sm"></box-icon>
                            </td>
                        </Link> 
                        <tr v-else>
                            <td class="border-b border-b-gray-200" colspan="6">
                                <NoDataMessage>No result found</NoDataMessage>
                            </td>
                        </tr>
                    </tbody>
                </table>
              </div>
            </div>
            <Pagination v-if="classes.data.length" :links="classes.links" />
        </div>
    </MainContainer>
</template>

<script setup>
import InputComponent from '../../Shared/InputComponent.vue';
import Pagination from '../../Shared/Pagination.vue';
import NoDataMessage from '../../Shared/NoDataMessage.vue';
import FilterInput from '../../Shared/FilterInput.vue';
import ButtonAdd from '../../Shared/ButtonAdd.vue';
import SelectDateYear from '../../Shared/SelectDateYear.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue'  
import { debounce } from 'lodash'; 

 
const props = defineProps({
    classes: Object,
    filters: Object,
})

const search = ref(props.filters.search);
const trashed = ref(props.filters.trashed);
const academic_year = ref(props.filters.academic_year);

watch(search, debounce((newValue) => {
    filter({
        search: newValue, 
        trashed: trashed.value, 
        academic_year: academic_year.value
    })
}, 500));
watch(trashed, debounce((newValue) => {
    filter({
        search: search.value, 
        trashed: newValue, 
        academic_year: academic_year.value
    })
}, 500));
watch(academic_year, debounce((newValue) => {
    filter({
        search: search.value, 
        trashed: trashed.value, 
        academic_year: newValue
    })
}, 500));

const filter = (filter) => {
   router.get(route('classes.index'), filter, 
         {
            preserveScroll: true,
            preserveState: true
         })
}
</script>

 