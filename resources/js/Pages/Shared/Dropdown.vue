<template>
    <div class="dropdown relative w-max">
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
                class=" fixed top-0 left-0 z-[9999] w-screen h-screen overflow-hidden bg-black/10"></div>
            <div class=" absolute right-0 z-[99999] w-full mt-1"
                 :class="{' -translate-x-full': align === 'left'}">
                <slot name="content"/>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

defineProps({
    align: String
})

const show = ref(false)

</script>

 