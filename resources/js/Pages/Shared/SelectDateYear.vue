<template>
    <div class="wrapper-input space-y-1">
        <label :for="name" class=" text-gray-600 text-xs md:text-sm font-bold">{{label}}</label>
        <select
               :value="modelValue"
               @change="$emit('update:modelValue', $event.target.value)" 
               class=" relative bottom-0 w-full text-xs md:text-sm text-gray-500 focus:outline-indigo-500 px-2 py-1.5 border border-gray-300 rounded">
           <option :value="getCurrentYear()" selected>{{ getCurrentYear() }}</option>
           <option v-for="year in years()" :value="year">{{ year }}</option>
        </select> 
    </div>
</template>

<script setup>  
defineProps({
    label: String,
    name: String,  
    modelValue: String, 
})

defineEmits(['update:modelValue'])

const years = () => {
    const years = [];
    const date = new Date();
    const yearFrom = date.getFullYear() - (date.getFullYear() - 2000);
    const yearTo = date.getFullYear();
    for (let year = yearFrom; year < yearTo; year++) {
        years.unshift(year);
    }

    return years;
}

const getCurrentYear = () => {
    const currentYear = new Date().getFullYear();
    
    return currentYear.toString()
}
</script>
 