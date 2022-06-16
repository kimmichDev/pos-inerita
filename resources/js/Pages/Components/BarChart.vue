<template>
    <div>
        <canvas id="barChart"></canvas>
    </div>
</template>

<script>
import Chart from "chart.js/auto";
import { onMounted } from "@vue/runtime-core";
export default {
    props: ["labels", "label", "data", "bgColor", "showX"],
    setup(props) {
        onMounted(() => {
            const ctx = document.getElementById("barChart");
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: props.labels,
                    datasets: [
                        {
                            label: props.label,
                            data: props.data,
                            backgroundColor: "#0d6efd",
                            hoverBackgroundColor: "#0d6efd80",
                        },
                    ],
                },
                options: {
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        x: {
                            display: props.showX,
                            grid: {
                                display: false,
                            },
                        },
                        y: {
                            ticks: {
                                stepSize: 1,
                            },
                            grid: {
                                display: false,
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
