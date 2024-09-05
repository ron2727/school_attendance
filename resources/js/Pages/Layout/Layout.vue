<template>
    <Head>
      <title>School Attendance</title>
    </Head>
    <div class="w-screen h-screen">
        <NavBar/>
        <div class="md:flex grow overflow-hidden h-full">
          <SideNavBar/>
          <div id="mainContent" class="h-full pt-5 md:pt-20 px-5 md:flex-1 overflow-y-auto"> 
            <slot/> 
          </div>
        </div>
    </div>
</template>

<script setup> 
import NavBar from '../Shared/NavBar.vue';
import SideNavBar from '../Shared/SideNavBar.vue';
import { Head } from '@inertiajs/vue3';
import { provide, ref } from 'vue';

const isToggled = ref(false);

const toggle = () => {
    isToggled.value = !isToggled.value
} 

provide('toggle', {
  isToggled,
  toggle
})
</script>