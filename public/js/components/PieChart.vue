<template>
    <div>
        <canvas ref="chart"></canvas>
    </div>
</template>

<script>
import { Pie } from 'vue-chartjs';
import { database } from 'https://sipair-pkm2024-default-rtdb.firebaseio.com/'

export default {
    extends: Pie,
    data() {
        return {
            chartData: {
                labels: [],
                datasets: [
                    {
                        label: 'Data Monitoring',
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                        data: []
                    }
                ]
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false
            }
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            database.ref('Data Monitoring').on('value', snapshot => {
                const data = snapshot.val();
                const labels = Object.keys(data);
                const values = Object.values(data);

                this.chartData.labels = labels;
                this.chartData.datasets[0].data = values;

                this.renderChart(this.chartData, this.chartOptions);
            });
        }
    }
};
</script>
