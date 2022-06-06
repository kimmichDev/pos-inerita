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
    <div class="row justify-content-center align-items-start mb-3">
        <div class="col-4">
            <div
                class="w-100 rounded gradient-1 aspect-16-9 mb-3 d-flex justify-content-center align-items-center"
            >
                <div>
                    <h4 class="fw-bold text-black-50">Today's Sales</h4>
                    <p class="fw-bold text-center">{{ total }} MMK</p>
                </div>
            </div>
            <div
                class="w-100 rounded gradient-2 aspect-16-9 mb-3 d-flex justify-content-center align-items-center"
            >
                <div>
                    <h4 class="fw-bold text-black-50">Sale Items Quantity</h4>
                    <p class="fw-bold text-center">
                        {{ saleItemTotalQuantity }}
                    </p>
                </div>
            </div>
        </div>
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
        <div class="col-4">
            <div class="card">
                <div class="card-header">Sale Items Quantity</div>
                <div class="card-body">
                    <DoughnutChart
                        :data="saleItemQuantity"
                        :labels="saleItemName"
                        :bgColors="bgColors"
                    />
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
                        method="post"
                        class="btn btn-primary"
                    >
                        Close Toay Report
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import LineChart from "../Components/LineChart.vue";
import DoughnutChart from "../Components/DoughnutChart.vue";
import { ref } from "@vue/reactivity";
import { computed } from "@vue/runtime-core";
import { showConfirm } from "../../Composables/showConfirm";
import { Inertia } from "@inertiajs/inertia";
export default {
    components: { Head, LineChart, DoughnutChart },
    props: [
        "todaySales",
        "saleItems",
        "totalItemQuantity",
        "itemNames",
        "vouchers",
    ],
    setup(props) {
        let labels = ref([]);
        let data = ref([]);
        let saleItemName = ref([]);
        let saleItemQuantity = ref([]);
        let saleItemTotalQuantity = ref([]);
        let bgColors = ref([]);

        props.todaySales.forEach((s) => {
            labels.value = [...labels.value, s.created_at_time];
            data.value = [...data.value, s.total];
        });

        let total = computed(() =>
            props.todaySales.reduce((pv, c) => pv + Number(c.total), 0)
        );

        saleItemTotalQuantity.value = Object.values(
            props.totalItemQuantity
        ).reduce((pv, cv) => pv + cv, 0);

        let saleItemIds = Object.keys(props.totalItemQuantity);

        saleItemQuantity.value = Object.values(props.totalItemQuantity);

        saleItemIds.forEach((id) => {
            let findArr = props.itemNames.find((i) => i.id == Number(id));
            saleItemName.value = [...saleItemName.value, findArr.name];
        });

        saleItemQuantity.value.forEach(
            () =>
                (bgColors.value = [
                    ...bgColors.value,
                    "hsl(" + Math.random() * 360 + ", 100%, 75%)",
                ])
        );

        let store = () =>
            showConfirm(
                () => Inertia.post(route("dailySaleReport.store")),
                "Sure to close and make report?"
            );

        return {
            labels,
            data,
            total,
            saleItemTotalQuantity,
            saleItemQuantity,
            saleItemName,
            bgColors,
            store,
        };
    },
};
</script>

<style lang="scss" scoped></style>
