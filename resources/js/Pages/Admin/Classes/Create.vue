<template>
  <MainContainer page-title="Create Class">
    <div class="form-wrapper max-w-lg bg-white p-5 rounded">
      <form @submit.prevent="handleSubmit()" class=" space-y-3"> 
        <DropDown>
          <template #trigger>
            <div class="flex items-center space-x-2">
              <button type="button" class=" px-3 py-1 bg-indigo-600 text-sm text-white rounded-md">Select
                Teacher</button>
              <div v-if="selectedTeacherName"
                   class="flex items-center space-x-2">
                <span class="text-gray-500 text-sm">{{ selectedTeacherName }}</span>
                <button
                        @click="removeSelectedTeacher()" 
                        type="button" class="py-0.5 px-1.5 rounded-md text-xs text-white bg-gray-500">
                  remove
               </button>
              </div>
            </div>
            <small v-if="form.errors.user_id" class=" text-xs text-red-600">{{ form.errors.user_id }}</small>
          </template>
          <template #content>
            <div class="w-max p-3 bg-white rounded-md">
              <InputComponent v-model="search" input-label="Search teacher" input-name="search"
                input-place-holder="Search teacher..."/>
              <div v-if="teachers.length"
                   v-for="teacher in teachers"
                   :key="teacher.id"
                   class=" mt-2 bg-white border-t rounded-md">
                <div class=" flex justify-between border-b p-2">
                  <span class=" text-gray-500 text-sm">{{teacher.firstName + ' ' + teacher.lastName}}</span>
                  <input type="radio" name="teacher" @click="selectTeacher(teacher)">
                </div> 
              </div>
              <NoDataMessage v-else>No result found</NoDataMessage>
            </div>
          </template>
        </DropDown>
        <InputComponent v-model="form.subject" input-label="Subject" input-name="subject"
          input-place-holder="Enter subject..." :input-error="form.errors.subject" />
        <InputComponent v-model="form.grade_section" input-label="Grade and section" input-name="grade_section"
          input-place-holder="Enter grade and section..." :input-error="form.errors.grade_section" /> 
        <SelectDateYear v-model="form.academic_year" label="Academic year" name="academic_year"/> 
        <div class="grid grid-cols-2 gap-x-2">
          <InputComponent v-model="form.time_from" input-type="time" input-label="Time from" input-name="time_from"
            input-place-holder="Enter time from..." :input-error="form.errors.time_from" />
          <InputComponent v-model="form.time_to" input-type="time" input-label="Time to" input-name="time_to"
            input-place-holder="Enter time to..." :input-error="form.errors.time_to" />
        </div>
        <ButtonSubmit :processing="form.processing"/>
      </form>
    </div>
  </MainContainer>
</template>

<script setup>
import DropDown from '../../Shared/DropDown.vue';
import InputComponent from '../../Shared/InputComponent.vue'; 
import NoDataMessage from '../../Shared/NoDataMessage.vue';
import SelectDateYear from '../../Shared/SelectDateYear.vue';
import ButtonSubmit from '../../Shared/ButtonSubmit.vue';
import { useForm, router } from '@inertiajs/vue3'; 
import { ref, watch } from 'vue';
import { debounce } from 'lodash';

const props = defineProps({
  teachers: Array,
  filters: String
})

const search = ref(props.filters);
const selectedTeacherName = ref('');

const form = useForm({
    subject: '',
    user_id: '',
    grade_section: '',
    time_from: '',
    time_to: '',
    academic_year: new Date().getFullYear(),
}) 
watch(search, debounce((newValue) => {
   router
   .get(
         route('classes.create'), 
         {
             search: newValue
         }, 
         { 
            preserveState: true
         })
}, 500));


const handleSubmit = () => {
  form.post(route('classes.store'))
}


const selectTeacher = (teacher) => {
      form.user_id = teacher.id;
      selectedTeacherName.value = teacher.firstName + ' ' + teacher.lastName;
}

const removeSelectedTeacher = () => {
  form.user_id = '';
  selectedTeacherName.value = '';
}
</script>