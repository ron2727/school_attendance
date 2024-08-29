<template>
    <div
        v-if="show"
        :class="{
                  'text-green-800 bg-green-600/30 border border-green-600': flash.success,
                  'text-red-800 bg-red-600/30 border border-red-600': flash.error,
                }" 
        class="alert-message w-max text-green-800 text-sm px-3 py-2 rounded">
        <span>{{flash.success || flash.error}}</span>
        <button type="button" class="ml-3" @click="show = false">x</button>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const show = ref('true');

defineProps({
    flash: Object
})
</script>
 