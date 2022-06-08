<template>
    <div>
        <canvas id="barChart"></canvas>
    </div>
</template>

<script>
import Chart from "chart.js/auto";
import { onMounted } from "@vue/runtime-core";
export default {
    props: ["labels", "label", "data", "bgColor"],
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
                            backgroundColor: props.bgColor,
                        },
                    ],
                },
                options: {
                    scales: {
                        x: {
                            display: false,
                        },
                        y: {
                            ticks: {
                                stepSize: 1,
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
