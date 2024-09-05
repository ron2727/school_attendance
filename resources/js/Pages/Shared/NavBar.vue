<template>
    <div class=" md:fixed z-10 flex flex-col md:flex-row justify-between items-end md:items-center w-full bg-white border">
        <div class="title relative flex justify-between md:justify-start w-full md:w-64 pl-4 md:pl-10 py-2 md:py-3 space-x-1 bg-indigo-600">
            <div class=" flex items-center">
              <box-icon name='school' type='solid' color="white"></box-icon>
              <h1 class="text-sm text-white font-bold ml-2">
                  School Attendance
              </h1>
            </div>
            <button type="button" class="md:hidden pr-4" @click="toggle()">
                <box-icon name='menu-alt-left' color="white" size="sm"></box-icon>
            </button>
        </div> 
        <div class="profile py-3 md:py-0 mr-4 md:mr-5">
            <DropDown align="left"> 
                <template #trigger>
                    <span class=" text-xs sm:text-sm">{{ $page.props.auth.user.firstName + ' ' + $page.props.auth.user.lastName}}</span>
                    <box-icon type='solid' name='chevron-down' size="xs" class="ml-1"></box-icon>
                </template>
                <template #content>
                    <div class="py-3 flex flex-col w-max space-y-1 bg-white border rounded-lg">
                        <Link :href="route(manageProfileRoutes[$page.props.auth.user.role])" class=" text-start py-2 px-5 hover:bg-indigo-600 hover:text-white" as="button" type="button">Manage Profile</Link>
                        <Link :href="route('login.destroy')" method="delete" class=" text-start py-2 px-5 hover:bg-indigo-600 hover:text-white" as="button" type="button">Logout</Link>
                    </div>
                </template>
            </DropDown> 
        </div>
    </div>
</template>

<script setup> 
import DropDown from './DropDown.vue';
import { Link } from '@inertiajs/vue3';
import { ref, inject } from 'vue';

const manageProfileRoutes = ref({
    teacher: 'teacher.profile',
    admin: 'admin.profile'
})

const {isToggled, toggle} = inject('toggle');
</script> 