<template>
    <MainContainer page-title="Manage Profile"> 
       <div class="form-wrapper max-w-lg  bg-white p-5 rounded">
          <form @submit.prevent="handleSubmit()" class=" space-y-3">
            <div class="grid grid-cols-2 gap-x-2">
                <InputComponent v-model="form.firstName" input-label="First name" input-name="firstName" input-place-holder="Enter first name..." :input-error="$page.props.errors.firstName"/>
                <InputComponent v-model="form.lastName" input-label="Last name" input-name="lastName" input-place-holder="Enter last name..." :input-error="$page.props.errors.lastName"/>
            </div>
            <InputComponent v-model="form.email" input-label="Email" input-name="email" input-place-holder="Enter email..." :input-error="$page.props.errors.email"/> 
            <button type="submit" class=" px-3 py-2 text-sm bg-indigo-600 text-white rounded" :disabled="form.processing">Submit</button>
          </form>
       </div>

       <div class="form-wrapper max-w-lg mt-10 bg-white p-5 rounded">
          <form @submit.prevent="handleChangePassword()" class=" space-y-3">
            <InputComponent v-model="formPassword.password" input-type="password" input-label="Current Password" input-name="password" input-place-holder="Enter current password..." :input-error="$page.props.errors.password"/>
            <InputComponent v-model="formPassword.new_password" input-type="password" input-label="New Password" input-name="new_password" input-place-holder="Enter new password..." :input-error="$page.props.errors.new_password"/>
            <InputComponent v-model="formPassword.new_password_confirmation" input-type="password" input-label="Confirm New Password" input-name="new_password_confirmation" input-place-holder="Confirm new password..."/>
            <button type="submit" class=" px-3 py-2 text-sm bg-indigo-600 text-white rounded" :disabled="formPassword.processing">Submit</button>
          </form>
       </div>
    </MainContainer>
</template>

<script setup>
import InputComponent from '../Shared/InputComponent.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const page = usePage();
const authUser = page.props.auth.user
const form = useForm({ 
    firstName: authUser.firstName,
    lastName: authUser.lastName,
    email: authUser.email,
})

const formPassword = useForm({
    password: '',
    new_password: '',
    new_password_confirmation: ''
})

const handleSubmit = () => {
  form.put(route('teacher.profile.update'), {preserveState: false})
}

const handleChangePassword = () => {
  formPassword.put(route('teacher.change-password'), {preserveState: false})
}

</script>