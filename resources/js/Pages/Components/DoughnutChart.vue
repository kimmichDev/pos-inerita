<template>
    <div class="position-relative">
        <canvas id="doughnutChart"></canvas>
        <div class="label-text">{{ chartTotal }}</div>
    </div>
</template>

<script>
import Chart from "chart.js/auto";
import { onMounted } from "@vue/runtime-core";
export default {
    props: ["labels", "label", "data", "chartTotal"],
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
                            backgroundColor: "#0d6efd",
                            hoverBackgroundColor: "#0d6efd80",
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

<style scoped>
.label-text {
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    z-index: 5;
    display: flex;
    justify-content: center;
    align-items: center;
    pointer-events: none;
    font-size: 1.5rem;
}
</style>
