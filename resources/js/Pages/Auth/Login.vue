<template>
    <Head>
      <title>School Attendance</title>
    </Head>
    <div class=" w-screen h-screen flex justify-center items-center bg-gray-100">
        <div class="wrapper-login max-w-96 w-full border bg-white rounded-lg overflow-x-hidden">
            <div class=" bg-indigo-600">
               <h1 class="flex items-center justify-center text-white text-lg font-bold py-5 font-Rubik">
                <box-icon name='school' type='solid' color="white" class="mr-2"></box-icon>
                 School Attendance
               </h1>
            </div>
            <div class="wrapper-form px-8 py-5">
                <form @submit.prevent="handleSubmit()" class=" space-y-2">
                   <InputComponent v-model="form.email" input-label="Email" input-name="email" input-place-holder="Enter email..." :input-error="form.errors.email"/>
                   <InputComponent v-model="form.password" input-label="Password" input-name="password" input-type="password" input-place-holder="Enter password..." :input-error="form.errors.password"/>
                   <br>
                  <ButtonSubmit class="w-full" :processing="form.processing" :text="['Login', 'Log-ining']"/>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import InputComponent from '../Shared/InputComponent.vue';
import ButtonSubmit from '../Shared/ButtonSubmit.vue';
import { useForm, Head } from '@inertiajs/vue3';  

const form = useForm({
    email: '',
    password: '', 
})
const handleSubmit = () => {
  form.post(route('login.auth'))
}

</script> 