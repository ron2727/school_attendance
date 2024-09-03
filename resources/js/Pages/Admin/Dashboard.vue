<template>
    <MainContainer page-title="Dashboard">
        <div class=" max-w-2xl grid grid-cols-3 gap-x-7"> 
           <Card label="TEACHER" :total="teacherTotal" icon="user" solid="true"/>
           <Card label="CLASS" :total="classesTotal" icon="book"/>
           <Card label="STUDENT" :total="studentTotal" icon="user"/>  
        </div>
        <Chart class="mt-5 p-5 bg-white rounded-lg"
               type="bar" 
              :data="data"
              :options="options"/>
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
}) 

const labels = ref(null);
const dataDataSets = ref(null);

const data = ref({
    labels: props.chartData.map(item => item.status) ,
    datasets: [{
        label: 'Total',
        data: props.chartData.map(item => item.total), 

    }],
    
})

const options = ref({ 
        scales: {
            y: {
                beginAtZero: true, 
                max: props.chartData.map(item => item.total).reduce((total, item) => item + total)
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
                  backgroundColor: 'rgb(79 70 229)',	
                }
            }
        }
    })
   
</script>

 