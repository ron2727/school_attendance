<template>
    <div :class="[solid ? 'bg-indigo-600 shadow-indigo-600 text-white' : 'text-gray-500 bg-white']" 
         class=" px-4 py-3 shadow-md  space-y-1 rounded-lg">
        <box-icon type='solid' :name='icon' 
                  :color="[solid ? 'indigo' : 'white']" 
                  :class="[solid ? 'bg-white' : 'bg-indigo-600']"
                  class=" rounded-lg p-1"></box-icon>
        <h6 class=" text-xs font-bold">{{ label }}</h6>
        <div :class="{'text-gray-800': !solid}"
             class=" flex">
            <span class=" text-[10px] mt-1 mr-2 font-bold">TOTAL</span>
            <span class="block text-2xl">{{ total }}</span>
        </div>
    </div>
</template>

<script setup>
defineProps({
    label: String,
    total: Number,
    icon: String,
    solid: {
        type: Boolean,
        default: false
    }
})
</script>
 