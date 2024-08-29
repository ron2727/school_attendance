<template>
    <div class=" fixed flex justify-between items-center w-full bg-white border">
        <div class="title bg-indigo-600 w-64 pl-10 py-3 flex space-x-1">
            <box-icon name='school' type='solid' color="white"></box-icon>
            <h1 class="text-white font-bold">
                School Attendance
            </h1>
        </div>
        <div class="profile mr-5">
            <Dropdown>
                <template #trigger>
                    John Doe
                </template>
                <template #content>
                    <div class="py-3 flex flex-col space-y-1">
                        <Link class=" py-2 px-5 hover:bg-indigo-600 hover:text-white">Manage Profile</Link>
                        <Link class=" py-2 px-5 hover:bg-indigo-600 hover:text-white">Logout</Link>
                    </div>
                </template>
            </Dropdown>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Dropdown from './Dropdown.vue';
</script> 