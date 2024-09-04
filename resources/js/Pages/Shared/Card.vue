<template>
    <div class="card border cursor-pointer rounded-lg hover:shadow-md">
        <div class="card-head"> 
            <slot name="head" />
        </div>
        <div class="card-body"> 
            <slot name="body" />
        </div>
    </div>
</template>

<script setup>

</script> 