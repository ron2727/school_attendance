<template>
  <Link>
    <div
        :class="{'border-l-white': !active, 'border-l-indigo-600 bg-gray-100 text-gray-600': active}"
        class="pl-6 py-2 flex items-center space-x-2 text-sm md:text-sm rounded border-l-4 hover:border-l-indigo-600 hover:bg-gray-100 hover:text-gray-600">
        <slot></slot>
    </div>
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    active: Boolean,
})
</script>
 
