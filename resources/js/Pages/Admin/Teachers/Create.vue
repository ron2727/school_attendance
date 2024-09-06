<template>
    <MainContainer page-title="Create Teacher"> 
       <div class="form-wrapper max-w-lg bg-white p-5 rounded"> 
          <form @submit.prevent="handleSubmit()" class=" space-y-3">
            <div class="grid grid-cols-2 gap-x-2">
                <InputComponent v-model="form.firstName" input-label="First name" input-name="firstName" input-place-holder="Enter first name..." :input-error="form.errors.firstName"/>
                <InputComponent v-model="form.lastName" input-label="Last name" input-name="lastName" input-place-holder="Enter last name..." :input-error="form.errors.lastName"/>
            </div>
            <InputComponent v-model="form.email" input-label="Email" input-name="email" input-place-holder="Enter email..." :input-error="form.errors.email"/>
            <InputComponent v-model="form.password" input-type="password" input-label="Password" input-name="password" input-place-holder="Enter password..." :input-error="form.errors.password"/>
            <InputComponent v-model="form.password_confirmation" input-type="password" input-label="Confirm Password" input-name="password_confirmation" input-place-holder="Confirm password..."/>
            <ButtonSubmit :processing="form.processing"/>
          </form>
       </div>
    </MainContainer>
</template>

<script setup>
import InputComponent from '../../Shared/InputComponent.vue';
import ButtonSubmit from '../../Shared/ButtonSubmit.vue';
import { useForm } from '@inertiajs/vue3'; 

const form = useForm({
    firstName: '',
    lastName: '',
    email: '',
    password: '',
    password_confirmation: '',
})
const handleSubmit = () => {
  form.post(route('teacher.store'))
}
</script>