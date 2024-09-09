<template>
    <button type="submit" 
            class="px-3 py-2 text-sm text-white rounded"
            :class="[processing ? 'bg-indigo-600/80 cursor-not-allowed' : 'bg-indigo-600']" 
            :disabled="processing"
            ref="button"
            > 
          {{ processing ? text[1] : text[0] }}
        <LoaderDot v-if="processing"/>  
    </button> 
</template>

<script setup>   
import LoaderDot from './LoaderDot.vue';

const props = defineProps({
   processing: Boolean,
   text: {
     type: Array,
     default: ['Submit', 'Submitting']
   }
})
 
</script>

