<template>
    <MainContainer page-title="Mark Attendance / Students">
       <div class="max-w-3xl bg-white p-5 rounded">  
        <h6 class="mb-2 text-2xl font-bold text-gray-600">{{ teacherClass.subject }}</h6>
        <div class="mb-2 text-xs text-gray-500 "> 
            <span class="font-bold">Total Students: </span> 
            {{ studentsClass.length }}
        </div>
        <div class="mb-5 text-xs text-gray-500 "> 
            <span class="font-bold">Date of attendance: </span> 
            {{ dateToday }}
        </div> 
          <div v-if="studentsClass.length" 
               class=" grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 my-5">
            <div  v-for="student in studentsClass">
                <div class=" p-2 border border-gray-200 border-l-4 border-l-indigo-600 rounded-md text-sm text-gray-500">
                   <span class=" block">{{ student.firstName + ' ' + student.lastName}}</span>
                   <small class=" text-xs text-gray-400">{{ student.gender }}</small>
                   <div class="select-status flex justify-end">
                      <select name="" id="" v-model="form.students[student.id]" class="px-0.5 text-xs border border-gray-300 outline-indigo-600 rounded-md">
                        <option value="present" selected>present</option>
                        <option value="absent">absent</option>
                      </select>
                   </div>
                </div> 
            </div>
             <div class=" col-span-2 md:col-span-3 lg:col-span-4 flex justify-end">
                <button v-if="!isClassHasAttendance" 
                       @click="handleSubmit()" 
                       :disabled="form.processing" 
                       type="button" 
                       class=" px-3 py-1 text-sm text-white bg-indigo-600 rounded-md">Submit</button>
                <button v-else 
                        @click="handleSubmitUpdate()" 
                        :disabled="form.processing" 
                        type="button" 
                        class=" px-3 py-1 text-sm text-white bg-indigo-600 rounded-md">Update</button>
             </div>
          </div>   
          <NoDataMessage v-else>No student found</NoDataMessage>
       </div>
    </MainContainer>
 </template>
 
 <script setup>  
 import NoDataMessage from '../../Shared/NoDataMessage.vue'; 
 import { Link, router, useForm } from '@inertiajs/vue3';
 import { ref, watch, onMounted } from 'vue'   

 const props = defineProps({
     teacherClass: Object,
     studentsClass: Array, 
     isClassHasAttendance: Boolean,
     attendances: Array,
     dateToday: String,
 }) 
 

 const form = useForm({
    class_id: props.teacherClass.id,
    students: {}
 }) 

 onMounted(() => {
    if (props.isClassHasAttendance) {
        putStudentAttendaceInForm()
    }else{
        putStudentInForm()
    }
 })

  
 
 const handleSubmit = () => {
    console.log(form)
    form.post(route('teacher.attendance.students.store'), {preserveState: false})
 }

 const handleSubmitUpdate = () => {
    console.log(form)
    form.put(route('teacher.attendance.students.update'), {preserveState: false})
 }

 const putStudentInForm = () => {
     const students = props.studentsClass  
     students.forEach(student => form.students[student.id] = 'present');
 }

 const putStudentAttendaceInForm = () => {
     const attendances = props.attendances  
     attendances.forEach(attendance => form.students[attendance.student_id] = attendance.status);
 }
 </script>