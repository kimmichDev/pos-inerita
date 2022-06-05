<template>
    <Head title="Daily Sale Report"></Head>
    <div class="row justify-content-center mb-3">
        <div class="col-12">
            <div class="border p-3 shadow rounded">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <Link :href="route('dashboard')">
                                <i class="bi bi-house-fill"></i>
                                Home
                            </Link>
                        </li>
                        <li class="breadcrumb-item active">
                            <i class="bi bi-list-ul"></i>
                            Daily Sale Report
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row justify-content-center align-items-center mb-3">
        <div class="col-4">
            <div class="card shadow">
                <div class="card-header">Hours and Sale amounts</div>
                <div class="card-body">
                    <div>
                        <LineChart
                            :labels="labels"
                            :data="data"
                            chartLabel="Hours / MMK"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4"></div>
    </div>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
import LineChart from "../Components/LineChart.vue";
import { ref } from "@vue/reactivity";
export default {
    components: { Head, LineChart },
    props: ["todaySales"],
    setup(props) {
        let labels = ref([]);
        let data = ref([]);

        props.todaySales.forEach((s) => {
            labels.value = [...labels.value, s.created_at_time];
            data.value = [...data.value, s.total];
        });

        return { labels, data };
    },
};
</script>

<style lang="scss" scoped></style>
