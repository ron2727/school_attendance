<template>
    <MainContainer page-title="Create Student"> 
       <div class="form-wrapper max-w-lg bg-white p-5 rounded"> 
          <form @submit.prevent="handleSubmit()" class=" space-y-3">
            <div class="grid grid-cols-2 gap-x-2">
                <InputComponent v-model="form.firstName" input-label="First name" input-name="firstName" input-place-holder="Enter first name..." :input-error="form.errors.firstName"/>
                <InputComponent v-model="form.lastName" input-label="Last name" input-name="lastName" input-place-holder="Enter last name..." :input-error="form.errors.lastName"/>
            </div>
            <InputComponent v-model="form.gender" input-label="Gender" input-name="gender" input-place-holder="Enter gender..." :input-error="form.errors.gender"/> 
            <button type="submit" class=" px-3 py-2 text-sm bg-indigo-600 text-white rounded" :disabled="form.processing">Submit</button>
          </form>
       </div>
    </MainContainer>
</template>

<script setup>
import InputComponent from '../../Shared/InputComponent.vue';
import { useForm } from '@inertiajs/vue3'; 

const form = useForm({
    firstName: '',
    lastName: '',
    gender: '', 
})
const handleSubmit = () => {
  form.post(route('student.store'))
}
</script>