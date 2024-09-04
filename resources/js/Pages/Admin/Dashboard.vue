<template>
    <MainContainer page-title="Dashboard">
        <div class=" max-w-2xl grid grid-cols-3 gap-x-7"> 
           <Card label="TEACHER" :total="teacherTotal" icon="user" solid="true"/>
           <Card label="CLASS" :total="classesTotal" icon="book"/>
           <Card label="STUDENT" :total="studentTotal" icon="user"/>  
        </div>
        <div class="mt-5 p-5 bg-white rounded-lg">
            <div class="mb-3 text-xs text-gray-600">
                <span class="font-bold">Date: </span>
                <span class=" text-gray-500">{{ dateToday }}</span>
            </div>
            <Chart
               title="Daily Attendance Total"
               type="bar" 
              :data="data"
              :options="options"/>
        </div>
    </MainContainer>
</template>

<script setup> 
import Card from '../Shared/Dashboard/Card.vue';
import Chart from '../Shared/Dashboard/Chart.vue';
import { ref, onMounted } from 'vue';

const props = defineProps({
    chartData: Array,
    teacherTotal: String, 
    classesTotal: String, 
    studentTotal: String,
    dateToday: String
}) 
 
const data = ref({
    labels: ['Present', 'Absent'],
    datasets: [{
        label: 'Total',
        data: props.chartData.totals, 
        backgroundColor: 'rgb(79 70 229)',
    }],
    
})

const options = ref({ 
        scales: {
            y: {
                beginAtZero: true, 
                max: props.chartData.totals.length ? props.chartData.totals.reduce((total, item) => item + total) : 0
            }
        },
        plugins: {
            legend:{
                labels: {
                    display: false,
                    boxWidth: 25,
                    useBorderRadius: true,
                }
            },
            decimination: {
                enabled: true
            },
            elements: {
                bar: {
                  borderRadius: 50,
                  borderWidth: 5, 
                }
            }
        }
    })
   
</script>

 