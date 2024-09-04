<template>
    <MainContainer page-title="Edit Teacher"> 
       <div class="form-wrapper max-w-lg  bg-white p-5 rounded">
          <AlertRestore v-if="teacher.deleted_at" model="teacher" @restore="restoreSubmit()"/> 
          <form @submit.prevent="handleSubmit()" class=" space-y-3">
            <div class="grid grid-cols-2 gap-x-2">
                <InputComponent v-model="form.firstName" input-label="First name" input-name="firstName" input-place-holder="Enter first name..." :input-error="$page.props.errors.firstName"/>
                <InputComponent v-model="form.lastName" input-label="Last name" input-name="lastName" input-place-holder="Enter last name..." :input-error="$page.props.errors.lastName"/>
            </div>
            <InputComponent v-model="form.email" input-label="Email" input-name="email" input-place-holder="Enter email..." :input-error="$page.props.errors.email"/> 
            <div class="flex items-center justify-between mt-5">
               <button v-if="!teacher.deleted_at" @click="deleteSubmit()" type="button" class=" text-sm text-red-600">Delete Teacher</button>
               <button type="submit" class=" px-3 py-2 text-sm bg-indigo-600 text-white rounded" :disabled="form.processing">Submit</button>
            </div>
          </form>
       </div>
    </MainContainer>
</template>

<script setup>
import InputComponent from '../../Shared/InputComponent.vue';
import AlertRestore from '../../Shared/AlertRestore.vue';
import { useForm, router } from '@inertiajs/vue3';
const props = defineProps({
    teacher: Object
})

const form = useForm({
    id: props.teacher.id,
    firstName: props.teacher.firstName,
    lastName: props.teacher.lastName,
    email: props.teacher.email,
})

const handleSubmit = () => {
  form.put(route('teacher.update', {teacher: props.teacher.id}), {preserveState: false})
}

const deleteSubmit = () => {
   const isYes = confirm(`Are you want to delete teacher ${props.teacher.firstName} ${props.teacher.lastName}`);
   
   if (isYes) {
      router.delete(route('teacher.destroy', {teacher: props.teacher.id}), {preserveState: false}); 
   }
}

const restoreSubmit = () => {
   const isYes = confirm(`Are you want to restore teacher ${props.teacher.firstName} ${props.teacher.lastName}`);
   
   if (isYes) {
      router.post(route('teacher.restore', {teacher: props.teacher.id}), {preserveState: false}); 
   }
}
</script>