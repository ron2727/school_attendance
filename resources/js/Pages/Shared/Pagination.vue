<template>
    <div class="wrapper-pagination">
       <ul class=" space-x-3">
          <li 
              v-for="(link, index) in links"
              class="inline-block"> 
             <Link 
                  :href="link.url" 
                  :class="{'bg-indigo-600 text-white': link.active}"
                  class=" px-3 py-2 text-sm border rounded-lg">{{ link.label }}</Link>
          </li>
       </ul>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: Array,
}) 
</script>
 