<template>
    <div @click="toggle()" 
         id="overlay" 
         :class="[isToggled ? 'block' : 'hidden']"
         class=" block md:hidden fixed top-0 left-0 z-0 w-screen h-screen overflow-hidden bg-black/10"></div>
    <div :class="[isToggled ? 'block' : 'hidden']" 
         class=" main-menu md:block absolute md:static z-[99999] md:z-0 w-64 h-max md:h-full pt-3 md:pt-20 pb-3 md:pb-0 border md:border-none rounded-lg md:rounded-none bg-white">
        <ul @click="toggle()" class=" text-gray-500 space-y-4" v-if="$page.props.auth.user.role === 'admin'">
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
                <NavLink :href="route('admin.report.index')" :active="pageName() === 'Report'">
                    <box-icon type='solid' name='printer'></box-icon>
                    <span>Report</span>
                </NavLink>
            </li>
        </ul>
        <ul @click="toggle()" class=" text-gray-500 space-y-4" v-else>
            <li class="px-3">
                <NavLink :href="route('teacher.dashboard')" :active="pageName() === 'Dashboard'">
                    <box-icon type='solid' name='dashboard'></box-icon>
                    <span>Dashboard</span>
                </NavLink>
            </li>
            <li class="px-3">
                <NavLink :href="route('teacher.classes.index')" :active="pageName() === 'Classes'">
                    <box-icon type='solid' name='book'></box-icon>
                    <span>My Classes</span>
                </NavLink>
            </li>
            <li class="px-3">
                <NavLink :href="route('teacher.attendance.index')" :active="pageName() === 'Attendance'">
                    <box-icon type='solid' name='book'></box-icon>
                    <span>Mark Attendance</span>
                </NavLink>
            </li> 
            <li class="px-3">
                <NavLink :href="route('teacher.report.index')" :active="pageName() === 'Report'">
                    <box-icon type='solid' name='printer'></box-icon>
                    <span>Report</span>
                </NavLink>
            </li>
        </ul>
    </div>
</template>

<script setup>
import NavLink from './NavLink.vue';
import { usePage } from '@inertiajs/vue3';
import { inject } from 'vue';

const page = usePage();

const pageName = () => page.component.split('/')[1];

const {isToggled, toggle} = inject('toggle');
</script>
 
