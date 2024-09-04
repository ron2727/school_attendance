<template>
    <MainContainer page-title="Edit Class">
      <div class="form-wrapper max-w-lg bg-white p-5 rounded">
        <AlertRestore v-if="teacherClass.deleted_at" model="class" @restore="restoreSubmit()"/> 
        <form @submit.prevent="handleSubmit()" class=" space-y-3"> 
          <DropDown>
            <template #trigger>
              <div class=" flex items-center space-x-2">
                <button type="button" class=" px-3 py-1 bg-indigo-600 text-sm text-white rounded-md">Select
                  Teacher</button>
                <div v-if="selectedTeacherName"
                     class=" flex items-center space-x-2">
                  <span class="text-gray-500 text-sm">{{ selectedTeacherName }}</span>
                  <button
                          @click="removeSelectedTeacher()" 
                          type="button" class="py-0.5 px-1.5 rounded-md text-xs text-white bg-gray-500">
                    remove
                 </button>
                </div>
              </div>
              <small v-if="$page.props.errors.user_id" class=" text-xs text-red-600">{{ $page.props.errors.user_id }}</small>
            </template>
            <template #content>
              <div class="w-max p-3 bg-white rounded-md">
                <InputComponent v-model="search" input-label="Search teacher" input-name="search"
                  input-place-holder="Search teacher..."/>
                <div v-if="teachers?.data.length"
                     v-for="teacher in teachers.data"
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
            input-place-holder="Enter subject..." :input-error="$page.props.errors.subject" />
          <InputComponent v-model="form.grade_section" input-label="Grade and section" input-name="grade_section"
            input-place-holder="Enter grade and section..." :input-error="$page.props.errors.grade_section" /> 
          <SelectDateYear v-model="form.academic_year" label="Academic year" name="academic_year"/> 
          <div class="grid grid-cols-2 gap-x-2">
            <InputComponent v-model="form.time_from" input-type="time" input-label="Time from" input-name="time_from"
              input-place-holder="Enter time from..." :input-error="$page.props.errors.time_from" />
            <InputComponent v-model="form.time_to" input-type="time" input-label="Time to" input-name="time_to"
              input-place-holder="Enter time to..." :input-error="$page.props.errors.time_to" />
          </div>
          <div class="flex items-center justify-between mt-5">
               <button v-if="!teacherClass.deleted_at" @click="deleteSubmit()" type="button" class=" text-sm text-red-600">Delete class</button>
               <button type="submit" class=" px-3 py-2 text-sm bg-indigo-600 text-white rounded" :disabled="form.processing">Submit</button>
          </div>
        </form>
      </div>
    </MainContainer>
  </template>
  
  <script setup>
  import DropDown from '../../Shared/DropDown.vue';
  import InputComponent from '../../Shared/InputComponent.vue'; 
  import NoDataMessage from '../../Shared/NoDataMessage.vue';
  import SelectDateYear from '../../Shared/SelectDateYear.vue';
  import AlertRestore from '../../Shared/AlertRestore.vue';
  import { useForm, router } from '@inertiajs/vue3'; 
  import { ref, watch, onMounted } from 'vue';
  import { debounce } from 'lodash';
  
  const props = defineProps({
    teacherClass: Object,
    teachers: Object,
    filters: String
  })
  
  const search = ref(props.filters);
  const selectedTeacherName = ref(`${props.teacherClass.user.firstName} ${props.teacherClass.user.lastName}`);
  
  const form = useForm({
      subject: props.teacherClass.subject,
      user_id: props.teacherClass.user_id,
      grade_section: props.teacherClass.grade_section,
      time_from: '',
      time_to: '',
      academic_year: props.teacherClass.academic_year,
  })
  
  onMounted(() => {
     form.time_from = getTime(props.teacherClass.time_from)
     form.time_to = getTime(props.teacherClass.time_to)
    
     
  })

  watch(search, debounce((newValue) => {
     router
     .get(
            `/classes/${props.teacherClass.id}/edit`, 
           {
               search: newValue
           }, 
           { 
              preserveState: true
           })
  }, 500));
  
  
  const handleSubmit = () => {
    form.put(route('classes.update', {class: props.teacherClass.id}), {preserveState: false})
  }
  
  
  const selectTeacher = (teacher) => {
        form.user_id = teacher.id;
        selectedTeacherName.value = teacher.firstName + ' ' + teacher.lastName;
  }
  
  const removeSelectedTeacher = () => {
    form.user_id = '';
    selectedTeacherName.value = '';
  }
 
  const getTime = (time) => {
    let timeDetails = time.split(' ')

    if (timeDetails[1] === 'pm') {
      timeDetails = timeDetails[0].split(':')
      const updatedHours = Number(timeDetails[0]) + 12;  
      return `${updatedHours}:${timeDetails[1]}` 
    }  
    return timeDetails[0]
  }

  const deleteSubmit = () => {
   const isYes = confirm(`Are you want to delete this class`);
   
   if (isYes) {
      router.delete(route('classes.destroy', {class: props.teacherClass.id}), {preserveState: false}); 
   }
}

const restoreSubmit = () => {
   const isYes = confirm(`Are you want to restore this class`);
   
   if (isYes) {
      router.post(route('classes.restore', {class: props.teacherClass.id}), {preserveState: false}); 
   }
}
  </script>