<template>
    <div
        v-if="show"
        :class="{
                  'text-green-800 bg-green-300': flash.success,
                  'text-red-800 bg-red-600/30 border border-red-600': flash.error,
                }" 
        class="alert-message flex items-center w-max text-green-800 text-sm p-2 py-2 rounded-lg">
        <box-icon name='check' class="mr-1" v-if="flash.success"></box-icon>
        <span>{{flash.success || flash.error}}</span>
        <button type="button" class="ml-3" @click="show = false">
            <box-icon name='x' size="xs"></box-icon>
        </button>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const show = ref('true');

defineProps({
    flash: Object
})
</script>
 