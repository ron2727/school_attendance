<template>
    <Link as="button" type="button"
        class=" px-3 py-2 bg-indigo-600 text-sm text-white rounded my-3">
         <slot/>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
 
