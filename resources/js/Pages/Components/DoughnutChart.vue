<template>
    <div>
        <canvas id="doughnutChart"></canvas>
    </div>
</template>

<script>
import Chart from "chart.js/auto";
import { onMounted } from "@vue/runtime-core";
export default {
    props: ["labels", "label", "data"],
    setup(props) {
        onMounted(() => {
            const ctx = document.getElementById("doughnutChart");
            new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: props.labels,
                    datasets: [
                        {
                            label: props.label,
                            data: props.data,
                            backgroundColor: "#0d6efd80",
                            hoverBackgroundColor: "#0d6efd",
                            // borderColor: "#3184ff",
                            hoverOffset: 0,
                        },
                    ],
                },
                options: {
                    plugins: {
                        legend: {
                            display: false,
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
