<template>
    <div class="wrapper-input space-y-1">
        <label :for="inputName" class=" text-gray-600 text-sm">{{inputLabel}}</label>
        <input 
               :type="inputType" 
               :placeholder="inputPlaceHolder"
               class=" w-full text-sm text-gray-500 px-2 py-1.5 border border-gray-300 rounded focus:outline-indigo-500 " />
        <small 
              v-if="error"
              class=" text-xs text-red-600">Email is required</small>
    </div>
</template>

<script setup>
defineProps({
    inputLabel: String,
    inputName: String,
    inputError: String,
    inputPlaceHolder: String,
    inputType: {
        type: String,
        default: 'text'
    }
})
</script>
 