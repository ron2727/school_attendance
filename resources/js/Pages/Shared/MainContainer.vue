<template>
    <div>
        <h1 class=" text-4xl font-bold text-indigo-600 mb-5">{{pageTitle}}</h1>
        <div class=" bg-white p-5 rounded">
           <slot/>
        </div>
    </div>
</template>

<script setup>
defineProps({
    pageTitle: String
})
</script>
 