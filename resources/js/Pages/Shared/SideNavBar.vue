<template>
    <div class=" main-menu w-64 h-full pt-20 bg-white">
        <ul class=" text-gray-500 space-y-4">
            <li class="px-3">
                <NavLink :href="route('dashboard')" :active="pageName() === 'Dashboard'">
                    <box-icon type='solid' name='dashboard'></box-icon>
                    <span>Dashboard</span>
                </NavLink>
            </li>
            <li class="px-3">
                <NavLink :href="route('classes.index')" :active="pageName() === 'Classes'">
                    <box-icon type='solid' name='book'></box-icon>
                    <span>Classes</span>
                </NavLink>
            </li>
            <li class="px-3">
                <NavLink :href="route('teacher.index')" :active="pageName() === 'Teachers'">
                    <box-icon type='solid' name='user'></box-icon>
                    <span>Teachers</span>
                </NavLink>
            </li>
            <li class="px-3">
                <NavLink :href="route('student.index')" :active="pageName() === 'Student'">
                    <box-icon type='solid' name='user'></box-icon>
                    <span>Students</span>
                </NavLink>
            </li>
            <li class="px-3">
                <NavLink>
                    <box-icon name='report' type='solid'></box-icon>
                    <span>Reports</span>
                </NavLink>
            </li>
        </ul>
    </div>
</template>

<script setup>
import NavLink from './NavLink.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

const pageName = () => page.component.split('/')[1] 

</script>
 
