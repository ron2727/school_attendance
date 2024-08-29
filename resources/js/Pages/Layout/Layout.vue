<template>
    <div class="w-screen h-screen bg-gray-200">
        <NavBar/>
        <div class=" flex grow overflow-hidden h-full">
          <SideNavBar/>
          <div id="mainContent" class="pt-20 px-5 flex-1 overflow-y-auto"> 
            <slot/> 
          </div>
        </div>
    </div>
</template>

<script setup> 
import NavBar from '../Shared/NavBar.vue';
import SideNavBar from '../Shared/SideNavBar.vue';
</script>