<template>
    <div class="alert bg-yellow-300 text-yellow-800 text-sm p-3 rounded-md mb-5 flex justify-between items-center">
        <div class=" flex items-center">
            <box-icon type='solid' name='trash' class="mr-2" size="sm"></box-icon> This {{model}} has been deleted
        </div>
        <button @click="$emit('restore')" type="button" class=" font-bold text-yellow-800">Restore</button>
    </div>
</template>

<script setup>
defineProps({
    model: String,
})
</script>
 