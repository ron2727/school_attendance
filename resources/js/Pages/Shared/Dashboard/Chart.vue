<template>
    <div>
        <h6 class=" text-lg md:text-2xl text-gray-500 font-bold">{{ title }}</h6>
        <canvas id="myChart"></canvas>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import 'https://cdn.jsdelivr.net/npm/chart.js';

const props = defineProps({
    title: String,
    type: String,
    data: Object,
    options: Object,
})

onMounted(() => {
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: props.type,
        data: props.data,
        options: props.options
    });
})
</script>
 