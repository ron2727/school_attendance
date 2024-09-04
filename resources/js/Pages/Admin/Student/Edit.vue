<template>
    <MainContainer page-title="Edit Student"> 
       <div class="form-wrapper max-w-lg  bg-white p-5 rounded">
          <AlertRestore v-if="student.deleted_at" model="teacher" @restore="restoreSubmit()"/> 
          <form @submit.prevent="handleSubmit()" class=" space-y-3">
            <div class="grid grid-cols-2 gap-x-2">
                <InputComponent v-model="form.firstName" input-label="First name" input-name="firstName" input-place-holder="Enter first name..." :input-error="$page.props.errors.firstName"/>
                <InputComponent v-model="form.lastName" input-label="Last name" input-name="lastName" input-place-holder="Enter last name..." :input-error="$page.props.errors.lastName"/>
            </div>
            <InputComponent v-model="form.gender" input-label="Gender" input-name="gender" input-place-holder="Enter gender..." :input-error="$page.props.errors.gender"/> 
            <div class="flex items-center justify-between mt-5">
               <button v-if="!student.deleted_at" @click="deleteSubmit()" type="button" class=" text-sm text-red-600">Delete student</button>
               <button type="submit" class=" px-3 py-2 text-sm bg-indigo-600 text-white rounded" :disabled="form.processing">Submit</button>
            </div>
          </form>
       </div>
    </MainContainer>
</template>

<script setup>
import InputComponent from '../../Shared/InputComponent.vue';
import AlertRestore from '../../Shared/AlertRestore.vue';
import { useForm, router} from '@inertiajs/vue3';
const props = defineProps({
    student: Object
})

const form = useForm({ 
    firstName: props.student.firstName,
    lastName: props.student.lastName,
    gender: props.student.gender,
})

const handleSubmit = () => {
  form.put(route('student.update', {student: props.student.id}), {preserveState: false})
}

const deleteSubmit = () => {
   const isYes = confirm(`Are you want to delete this student`);
   
   if (isYes) {
      router.delete(route('student.destroy', {student: props.student.id}), {preserveState: false}); 
   }
}

const restoreSubmit = () => {
   const isYes = confirm(`Are you want to restore this student`);
   
   if (isYes) {
      router.post(route('student.restore', {student: props.student.id}), {preserveState: false}); 
   }
}
</script>