<template>
    <div>
        <canvas id="polarChart"></canvas>
    </div>
</template>

<script>
import Chart from "chart.js/auto";
import { onMounted } from "@vue/runtime-core";
export default {
    props: ["labels", "label", "data", "bgColors"],
    setup(props) {
        onMounted(() => {
            const ctx = document.getElementById("polarChart");
            new Chart(ctx, {
                type: "polarArea",
                data: {
                    labels: props.labels,
                    datasets: [
                        {
                            label: props.label,
                            data: props.data,
                            backgroundColor: "#3184ff20",
                            // hoverBackgroundColor: "#0d6efd",
                            borderColor: "#3184ff20",
                            hoverOffset: 0,
                            fill: true,
                        },
                    ],
                },
                options: {
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    responsive: true,
                    scales: {},
                },
            });
        });
        return {};
    },
};
</script>

<style scoped></style>
