<template>
    <MainContainer page-title="My Classes / Students">
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
            <div class=" w-72 h-80 p-3 bg-white rounded-md overflow-y-auto">
              <InputComponent v-model="search" input-label="Search teacher" input-name="search"
                input-place-holder="Search student..."/>
              <div v-if="students.length"
                   v-for="student in students"
                   class=" mt-2 bg-white border-t rounded-md">
                <div class=" flex justify-between border-b p-2">
                  <div class=" flex flex-col">
                    <span class=" text-gray-500 text-sm">{{student.firstName + ' ' + student.lastName}}</span>
                    <small class=" text-xs text-gray-400">{{ student.gender }}</small>
                  </div>
                  <input type="radio" name="teacher" @click="selectStudent(student)">
                </div> 
              </div>
              <NoDataMessage v-else>No result found</NoDataMessage>
            </div>
          </template>
        </DropDown> 
          <div v-if="studentsClass.length" 
               class=" grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 my-5">
             <div v-for="student in studentsClass"
                  class=" p-2 border border-gray-200 border-l-4 border-l-indigo-600 rounded-md text-sm text-gray-500">
                <span class=" block">{{ student.firstName + ' ' + student.lastName}}</span>
                <small class=" text-xs text-gray-400">{{ student.gender }}</small>
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
 import Card from '../../Shared/Card.vue';
 import ButtonAdd from '../../Shared/ButtonAdd.vue';
 import { Link, router } from '@inertiajs/vue3';
 import { ref, watch } from 'vue'  
 import { debounce } from 'lodash';
import { filter } from 'lodash';
 
 const props = defineProps({
     teacherClass: Object,
     studentsClass: Array,
     students: Array, 
     filters: String
 }) 

 const search = ref(props.filters); 
 const selectedStudent = ref('');

watch(search, debounce((newValue) => {
   router
   .get(
         route('teacher.classes.students', {class: props.teacherClass.id}), 
         {
             search: newValue
         }, 
         { 
            preserveState: true
         })
}, 500));

const selectStudent = (student) => {
      const isResponseOk = confirm(`Are you sure, you want to add this student ${student.firstName} ${student.lastName} in this class ?`);

      if (isResponseOk) {
        if (checkIfStudentWasInClassAlready(student.id)) { 
            alert('The student was in class already')
        }else{ 
            addStudentToTheClass(student.id)
        } 
      }
}

const addStudentToTheClass = (student_id) => {
    router
   .post(
         route('teacher.classes.students.store'), 
         {
             student_id: student_id, 
             class_id: props.teacherClass.id
         }, 
         { 
            preserveState: false
         })
}
 

const checkIfStudentWasInClassAlready = (student_id) => { 
     const students = props.studentsClass;

     for (let index = 0; index < students.length; index++) {
          const student = students[index]; 

          if (student.id === student_id) {
              return true
          }
     }

     return false;
}
 </script>