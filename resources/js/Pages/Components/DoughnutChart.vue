<template>
    <Doughnut :chart-options="chartOptions" :chart-data="chartData" />
</template>

<script>
import { Doughnut } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale,
    Plugin,
} from "chart.js";

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);
export default {
    components: { Doughnut },
    props: ["labels", "data", "bgColors"],
    setup(props) {
        const chartData = {
            labels: props.labels,
            datasets: [
                {
                    backgroundColor: props.bgColors,
                    data: props.data,
                },
            ],
        };
        let chartOptions = {
            responsive: true,
        };
        return { chartData, chartOptions };
    },
};
</script>

<style lang="scss" scoped></style>
