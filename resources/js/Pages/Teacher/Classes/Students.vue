<template>
  <MainContainer page-title="My Classes / Students"> 
    <Modal title="Selected students" :modal-show="selectedStudentModal" @close-modal="selectedStudentModal = false">
      <template #body>
        <div class="grid grid-cols-2 gap-2" v-if="Object.values(selectedStudents).length">
          <div v-for="student in selectedStudents" :key="student.id">
            <div :class="[student.exist ? 'border-l-red-600' : 'border-l-indigo-600']"
                  class=" relative p-2 border border-gray-200 border-l-4 rounded-md text-sm text-gray-500">
              <span class=" block text-xs md:text-sm">{{ student.firstName + ' ' + student.lastName }}</span>
              <small class=" text-[10px] md:text-xs text-gray-400">{{ student.gender }}</small>
              <span v-if="student.exist"
                class=" inline-block absolute bottom-0 right-0 h-max px-[4px] m-1 text-white text-[10px] bg-red-600 rounded-md">Exist</span>
              <button type="button" class=" absolute top-0 right-0 m-1" @click="removeStudent(student.id)"><box-icon
                  name='x' size="xs"></box-icon></button>
            </div>
            <small v-if="student.exist" class=" text-red-600 text-[10px] md:text-xs">This student already in class</small>
          </div>
        </div>
        <NoDataMessage v-else>No selected student</NoDataMessage>
      </template>
      <template #footer v-if="Object.values(selectedStudents).length">
        <div class=" flex justify-end space-x-3">
          <button type="button" class="px-3 py-2 text-xs md:text-sm bg-red-600 text-white rounded"
            @click="removeAllStudents">Cancel</button>
          <button type="button" class="px-3 py-2 text-xs md:text-sm bg-indigo-600 text-white rounded"
            @click="addStudentToTheClass">Submit</button>
        </div>
      </template>
    </Modal>
    <div class="max-w-3xl bg-white p-5 rounded">
      <h6 class="mb-2 text-2xl font-bold text-gray-600">{{ teacherClass.subject }}</h6>
      <div class="mb-2 text-xs text-gray-500 ">
        <span class="font-bold">Total Students: </span>
        {{ studentsClass.length }}
      </div>
      <div class="mb-5 text-xs text-gray-500 ">
        <span class="font-bold">Time: </span>
        {{ teacherClass.time_from + ' - ' + teacherClass.time_to}}
      </div>
      <DropDown>
        <template #trigger>
          <div class=" flex items-center space-x-2">
            <button type="button" class=" px-3 py-1 bg-indigo-600 text-sm text-white rounded-md">Add
              student</button>
          </div>
        </template>
        <template #content>
          <div class=" relative w-72 h-80 p-3 bg-white rounded-md overflow-y-auto">
            <InputComponent v-model="search" input-label="Search teacher" input-name="search"
              input-place-holder="Search student..." />
            <button @click="selectedStudentModal = true" type="button"
              class=" sticky top-0 left-0 mt-2 px-3 py-1 text-sm text-white bg-indigo-600 rounded-md">Add
              student/s</button> 
             <div v-if="students.length" v-for="student in students" :key="student.id"
              class=" mt-2 bg-white border-t rounded-md">
              <div class=" flex justify-between border-b p-2">
                <div class=" flex flex-col">
                  <span class=" text-gray-500 text-xs md:text-sm">{{student.firstName + ' ' + student.lastName}}</span>
                  <small class=" text-[10px] md:text-xs text-gray-400">{{ student.gender }}</small>
                </div>
                <input type="checkbox" :checked="selected(student)" @click="selectStudent(student)">
              </div>
            </div>
            <NoDataMessage v-else>No result found</NoDataMessage>
          </div>
        </template>
      </DropDown>
      <div v-if="studentsClass.length" class=" grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 my-5">
        <div v-for="student in studentsClass"
          class=" p-2 border border-gray-200 border-l-4 border-l-indigo-600 rounded-md text-sm text-gray-500">
          <span class=" block text-xs md:text-sm">{{ student.firstName + ' ' + student.lastName}}</span>
          <small class=" text-[10px] md:text-xs text-gray-400">{{ student.gender }}</small>
        </div>
      </div>
      <NoDataMessage v-else>No student found</NoDataMessage>
    </div>
  </MainContainer>
</template>
 
 <script setup> 
 import InputComponent from '../../Shared/InputComponent.vue';
 import DropDown from '../../Shared/DropDown.vue';
 import NoDataMessage from '../../Shared/NoDataMessage.vue';
 import Modal from '../../Shared/Modal.vue';  
 import { Link, router } from '@inertiajs/vue3';
 import { ref, watch } from 'vue'  
 import { debounce } from 'lodash'; 
 
 const selectedStudentModal = ref(false)
 const modal2 = ref(false)

 const props = defineProps({
     teacherClass: Object,
     studentsClass: Array,
     students: Array, 
     filters: String
 }) 

 const search = ref(props.filters); 
 const selectedStudents = ref({}); 

watch(search, debounce((newValue) => {
   router.get( 
         route('teacher.classes.students', {class: props.teacherClass.id}), 
         {
             search: newValue
         }, 
         { 
            preserveState: true
         })
}, 500));

const selectStudent = (student) => { 
      if (!selectedStudents.value[student.id]) { 
          selectedStudents.value[student.id] = student;
      }else{
          delete selectedStudents.value[student.id]
      } 
}

const addStudentToTheClass = () => {
       if (!checkIfThereStudentWasInTheClass()) { 
            router.post(route('teacher.classes.students.store'), 
            {
               students: selectedStudents.value, 
               class_id: props.teacherClass.id
            }, 
            { 
               preserveState: false
            })
       } 
}
 

const checkIfThereStudentWasInTheClass = () => { 
     
     const studentsWasInClass = props.studentsClass.filter(student => selectedStudents.value[student.id])
     
     if (studentsWasInClass.length) { 
        studentsWasInClass.forEach(student => {
           if (selectedStudents.value[student.id]) {
              selectedStudents.value[student.id].exist = true;  
           }
        });  
        console.log(selectedStudents.value); 
        return true
     }  
     return false;
}


const selected = (student) => {
     
  return selectedStudents.value[student.id];
}
 
const removeStudent = (student_id) => {
   delete selectedStudents.value[student_id];
}

const removeAllStudents = () => {
    selectedStudents.value = {}
    modalShow.value = false;
}
 </script> 