<template>
    <Line :chart-options="chartOptions" :chart-data="chartData" />
</template>

<script>
import { Line } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    PointElement,
    CategoryScale,
    Plugin,
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    PointElement,
    CategoryScale
);
export default {
    components: { Line },
    props: ["labels", "data", "chartLabel"],
    setup(props) {
        let chartData = {
            labels: props.labels,
            datasets: [
                {
                    label: props.chartLabel,
                    data: props.data,
                    borderColor: "#0d6efdad",
                    tension: 0.4,
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
