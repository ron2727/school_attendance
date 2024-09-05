<template>
    <div class="wrapper-input space-y-1">
        <label :for="inputName" class=" text-gray-600 text-xs md:text-sm font-bold">{{inputLabel}}</label>
        <input 
               :type="inputType" 
               :placeholder="inputPlaceHolder"
               :value="modelValue"
               @input="$emit('update:modelValue', $event.target.value)"
               :class="{'focus:outline-indigo-500': !inputError, 'border-red-300 focus:outline-red-500': inputError}"
               class=" w-full text-xs md:text-sm text-gray-500 px-2 py-1.5 border border-gray-300 rounded" />
        <small 
              v-if="inputError"
              class=" text-xs text-red-600">{{inputError}}</small>
    </div>
</template>

<script setup>  
defineProps({
    inputLabel: String,
    inputName: String,
    inputError: String,
    inputPlaceHolder: String,
    modelValue: String,
    inputType: {
        type: String,
        default: 'text'
    }
})

defineEmits(['update:modelValue'])
</script>
 