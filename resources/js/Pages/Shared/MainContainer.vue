<template>
    <div>
        <h1 class=" text-4xl font-bold text-indigo-600 mb-5">{{pageTitle}}</h1>
        <AlertMessage 
                        v-if="$page.props.flash.success || $page.props.flash.error" 
                        :flash="$page.props.flash"
                        class="mb-5"/> 
        <div class="content">
            <slot/>
        </div>
    </div>
</template>

<script setup>
import AlertMessage from './AlertMessage.vue';
defineProps({
    pageTitle: String
})
</script>
 