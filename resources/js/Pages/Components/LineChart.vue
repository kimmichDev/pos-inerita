<template>
    <div>
        <canvas id="lineChart"></canvas>
    </div>
</template>

<script>
import Chart from "chart.js/auto";
import { onMounted } from "@vue/runtime-core";
export default {
    props: ["labels", "label", "data"],
    setup(props) {
        onMounted(() => {
            const ctx = document.getElementById("lineChart");
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: props.labels,
                    datasets: [
                        {
                            label: props.label,
                            data: props.data,
                            backgroundColor: "#0d6efd",
                            borderColor: "#0d6efd8f",
                            borderWidth: 3,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                        },
                    ],
                },
                options: {
                    lineTension: 0.4,
                    scales: {
                        y: {
                            ticks: {
                                stepSize: 2000,
                            },
                        },
                    },
                },
            });
        });
        return {};
    },
};
</script>

<style scoped></style>
