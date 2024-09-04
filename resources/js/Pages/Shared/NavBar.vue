<template>
    <div class=" fixed flex justify-between items-center w-full bg-white border">
        <div class="title bg-indigo-600 w-64 pl-10 py-3 flex space-x-1">
            <box-icon name='school' type='solid' color="white"></box-icon>
            <h1 class="text-white font-bold">
                School Attendance
            </h1>
        </div>
        <div class="profile mr-5">
            <DropDown align="left"> 
                <template #trigger>
                    <span class=" text-sm">{{ $page.props.auth.user.firstName + ' ' + $page.props.auth.user.lastName}}</span>
                    <box-icon type='solid' name='chevron-down' size="xs" class="ml-1"></box-icon>
                </template>
                <template #content>
                    <div class="py-3 flex flex-col w-max space-y-1 bg-white border rounded-lg">
                        <Link :href="route(manageProfileRoutes[$page.props.auth.user.role])" class=" py-2 px-5 hover:bg-indigo-600 hover:text-white" as="a">Manage Profile</Link>
                        <Link :href="route('login.destroy')" method="delete" class=" py-2 px-5 hover:bg-indigo-600 hover:text-white" as="a">Logout</Link>
                    </div>
                </template>
            </DropDown> 
        </div>
    </div>
</template>

<script setup> 
import DropDown from './DropDown.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const manageProfileRoutes = ref({
    teacher: 'teacher.profile',
    admin: 'admin.profile'
})
</script> 