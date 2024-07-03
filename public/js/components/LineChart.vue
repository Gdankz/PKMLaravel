<template>
    <div>
        <canvas ref="chart"></canvas>
    </div>
</template>

<script>
import { Line } from 'vue-chartjs';
import database from 'E:/PKM/SIPAIR/firebase.js';

export default {
    extends: Line,
    data() {
        return {
            chartData: {
                labels: [],
                datasets: [
                    {
                        label: 'Berat Air',
                        backgroundColor: '#f87979',
                        data: [],
                        fill: false,
                        borderColor: '#f87979',
                        tension: 0.1
                    },
                    {
                        label: 'Berat Urin',
                        backgroundColor: '#36A2EB',
                        data: [],
                        fill: false,
                        borderColor: '#36A2EB',
                        tension: 0.1
                    }
                ]
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            database.ref('Berat Air').on('value', snapshot => {
                const data = snapshot.val();
                const labels = Object.keys(data);
                const values = Object.values(data);

                this.chartData.labels = labels;
                this.chartData.datasets[0].data = values;

                this.renderChart();
            });

            database.ref('Berat Urin').on('value', snapshot => {
                const data = snapshot.val();
                const values = Object.values(data);

                this.chartData.datasets[1].data = values;

                this.renderChart();
            });
        },
        renderChart() {
            this.renderChart(this.chartData, this.chartOptions);
        }
    }
}
</script>
