<template>
    <div class="dropdown relative">
        <div
            @click="show = true" 
            id="trigger"
            class=" cursor-pointer">
            <slot name="trigger"/>
        </div>
        <div id="content" v-if="show">
            <div
                @click="show = false" 
                id="overlay" 
                class=" fixed top-0 left-0 w-screen h-screen overflow-hidden bg-black/10"></div>
            <div class=" absolute right-0 w-max mt-1 border bg-white rounded-lg">
                <slot name="content"/>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const show = ref(false)

</script>

 