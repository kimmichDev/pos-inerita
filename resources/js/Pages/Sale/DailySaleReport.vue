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
    <div
        v-if="todaySales.length == 0"
        class="row justify-content-center align-items-start mb-3"
    >
        <h5>No records found</h5>
    </div>
    <div v-else>
        <div class="row justify-content-center">
            <div class="col-3">
                <div
                    class="rounded gradient-1 aspect-16-9 mb-3 d-flex justify-content-center align-items-center"
                >
                    <div>
                        <p class="fw-bold text-black-50">Today's Sales</p>
                        <h4 class="fw-bold text-center">{{ total }} MMK</h4>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div
                    class="rounded gradient-2 aspect-16-9 mb-3 d-flex justify-content-center align-items-center"
                >
                    <div>
                        <p class="fw-bold text-black-50">Sale Items Quantity</p>
                        <h4 class="fw-bold text-center">
                            {{ saleItemTotalQuantity }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div
                    class="rounded gradient-3 aspect-16-9 mb-3 d-flex justify-content-center align-items-center"
                >
                    <div>
                        <p class="fw-bold text-black-50 text-center">
                            Top saled Items
                        </p>
                        <p
                            class="fw-bold mb-0"
                            v-for="(item, ind) in topSeller"
                            :key="ind"
                        >
                            {{ item }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center align-items-start mb-3">
            <div class="col-6">
                <div class="card shadow">
                    <div class="card-header">Hours and Sale amounts</div>
                    <div class="card-body">
                        <div>
                            <line-chart
                                :label="'Hours/MMk'"
                                :labels="labels"
                                :data="data"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">Sale Items Quantity</div>
                    <div class="card-body">
                        <div>
                            <bar-chart
                                label="Item / Quantity"
                                :labels="totalItemName"
                                :data="totalItemQuantity"
                                :bg-color="bgColors"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center align-items-center mb-3">
            <div class="card shadow">
                <div class="card-header">Today Customers</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Voucher Number</th>
                                <th>Total</th>
                                <th>Purchase Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="voucher in vouchers" :key="voucher.id">
                                <td>{{ voucher.customer_name }}</td>
                                <td>{{ voucher.voucher_number }}</td>
                                <td>{{ voucher.total }} MMK</td>
                                <td>{{ voucher.created_at_time }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button
                            @click="store"
                            :disabled="isClosed"
                            method="post"
                            class="btn btn-primary"
                        >
                            <span v-if="isClosed">Already closed</span>
                            <span v-else>Close Today Report</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BarChart from "../Components/BarChart";
import LineChart from "../Components/LineChart.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "@vue/reactivity";
import { computed } from "@vue/runtime-core";
import { showConfirm } from "../../Composables/showConfirm";
import { Inertia } from "@inertiajs/inertia";
export default {
    components: {
        BarChart,
        Head,
        LineChart,
    },
    props: [
        "todaySales",
        "vouchers",
        "totalItemQuantity",
        "totalItemName",
        "topSeller",
        "isClosed",
    ],
    setup(props) {
        let labels = ref([]);
        let data = ref([]);
        let saleItemTotalQuantity = ref([]);
        let bgColors = ref([]);

        // line chart
        props.todaySales.forEach((s) => {
            labels.value = [...labels.value, s.created_at_time];
            data.value = [...data.value, s.total];
        });

        // left analy
        let total = computed(() =>
            props.todaySales.reduce((pv, c) => pv + Number(c.total), 0)
        );
        saleItemTotalQuantity.value = Object.values(
            props.totalItemQuantity
        ).reduce((pv, cv) => pv + cv, 0);

        props.totalItemQuantity.forEach(
            () =>
                (bgColors.value = [
                    ...bgColors.value,
                    "hsl(" + Math.random() * 360 + ", 100%, 75%)",
                ])
        );

        let store = () =>
            showConfirm(() => {
                Inertia.post(route("dailySaleReport.store"));
                props.isClosed = true;
            }, "Sure to close and make report?");
        console.log(props.todaySales.length);
        return {
            labels,
            data,
            total,
            saleItemTotalQuantity,
            store,
            bgColors,
        };
    },
};
</script>

<style lang="scss" scoped></style>
