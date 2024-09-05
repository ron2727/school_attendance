<template>
    <form :action="route(routeName)" method="post" target="_blank">
        <input type="hidden" name="_token" :value="$page.props.csrf"> 
        <input v-for="(value, name) in fields"
               :name="name" 
               :value="value" 
                type="hidden" >  
        <button type="submit" :class="color" class="px-3 py-1 text-white text-xs md:text-sm rounded">
            <slot/>
        </button>
    </form>
</template>

<script setup>
 defineProps({
    routeName: String,
    fields: Object,
    color: String,
 })
</script> 