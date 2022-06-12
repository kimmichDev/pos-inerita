<template>
    <Head title="Daily Sale Report"></Head>
    <div class="row justify-content-center mb-3">
        <div class="col-12 mb-3">
            <div class="border p-3 shadow rounded">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex justify-content-between">
                        <div class="d-flex align-items-center">
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
                        </div>
                        <div class="input-group align-items-stretch w-auto">
                            <date-picker
                                v-model:value="form.date"
                                value-type="format"
                                format="DD-MMM-YYYY"
                                :clearable="false"
                                :default-value="form.date"
                                :disabled-date="disabledDates"
                                @change="dateHandler"
                            ></date-picker>
                            <!-- <input
                                type="date"
                                v-model="form.date"
                                class="form-control w-auto"
                                name="date"
                                required
                                placeholder="dd-mm-yyyy"
                                :max="today"
                                @change="dateHandler"
                            /> -->
                            <button
                                class="btn btn-primary btn-sm"
                                @click="dateInputHandler"
                            >
                                Select date
                            </button>
                        </div>

                        <button
                            class="btn btn-sm btn-primary"
                            @click="dateHandler"
                        >
                            <span class="me-2">Reload Data</span>
                            <i class="bi bi-arrow-repeat"></i>
                        </button>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-12">
            <h3 class="fw-bold text-black-50">
                Daily report for {{ selectedDate }}
            </h3>
        </div>
    </div>
    <div
        v-if="todaySales.length == 0"
        class="row justify-content-center align-items-start mb-3"
    >
        <div class="mt-3">
            <h5 class="mb-0 text-center text-black-50 fw-bold">
                No records found
            </h5>
            <NoDataFound class="w-50 m-auto"></NoDataFound>
        </div>
    </div>
    <div v-else>
        <div class="row justify-content-center">
            <div class="col-3">
                <div
                    class="rounded shadow gradient-1 aspect-16-9 mb-3 d-flex justify-content-center align-items-center"
                >
                    <div>
                        <p class="fw-bold text-black-50">Today's Sales</p>
                        <h4 class="fw-bold text-center">{{ total }} MMK</h4>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div
                    class="rounded shadow gradient-2 aspect-16-9 mb-3 d-flex justify-content-center align-items-center"
                >
                    <div>
                        <p class="fw-bold text-black-50">Sale Items Quantity</p>
                        <h4 class="fw-bold text-center">
                            {{ saleItemQuantity }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div
                    class="rounded shadow gradient-3 aspect-16-9 mb-3 d-flex justify-content-center align-items-center"
                >
                    <div>
                        <p class="fw-bold text-center">Top saled Items</p>
                        <p
                            class="fw-bold mb-0 text-black-50 small"
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
                <div class="card shadow">
                    <div class="card-header">Sale Items Quantity</div>
                    <div class="card-body">
                        <div>
                            <bar-chart
                                label="Item / Quantity"
                                :labels="totalItemName"
                                :data="totalItemQuantity"
                                :showX="false"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center align-items-center mb-3">
            <div class="card shadow">
                <div
                    class="card-header d-flex justify-content-between align-items-center"
                >
                    <span> Today Customers </span>
                    <Link
                        :href="
                            route('dailyVoucher.pdf', { date: selectedDate })
                        "
                        class="btn btn-outline-primary"
                    >
                        Export to pdf
                        <i class="bi bi-filetype-pdf ms-2"></i>
                    </Link>
                </div>
                <div class="card-body pb-0 table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Item Name</th>
                                <th>Voucher No.</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Cost</th>
                                <th>Purchase Time</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="vl in voucherLists.data" :key="vl.id">
                                <td>{{ vl.voucherResource.customer_name }}</td>
                                <td class="text-truncate text-nowrap">
                                    {{ vl.item_name }}
                                </td>
                                <td>{{ vl.voucherResource.voucher_number }}</td>
                                <td>{{ vl.unit_price }}</td>
                                <td>{{ vl.quantity }}</td>
                                <td>{{ vl.cost }} MMK</td>
                                <td>
                                    {{ vl.voucherResource.created_at_time }}
                                </td>
                                <td>{{ vl.voucherResource.date }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-center fw-bold h5">
                                    Total
                                </td>
                                <td>
                                    <span class="text-primary fw-bold">
                                        {{ total }} MMK
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        <Paginator :links="voucherLists.meta.links"></Paginator>
                    </div>
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
import NoDataFound from "../Components/NoDataFound";
import Paginator from "../Components/Paginator";
import BarChart from "../Components/BarChart";
import LineChart from "../Components/LineChart.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "@vue/reactivity";
import { computed } from "@vue/runtime-core";
import { showConfirm } from "../../Composables/showConfirm";
import { Inertia } from "@inertiajs/inertia";
import { showAlert } from "../../Composables/showAlert";
import { showToast } from "../../Composables/showToast";
import DatePicker from "vue-datepicker-next";
import "vue-datepicker-next/index.css";

export default {
    components: {
        NoDataFound,
        Paginator,
        BarChart,
        Head,
        LineChart,
        DatePicker,
    },
    props: [
        "todaySales",
        "voucherLists",
        "totalItemQuantity",
        "totalItemName",
        "topSeller",
        "isClosed",
        "selectedDate",
    ],
    setup(props) {
        let labels = ref([]);
        let data = ref([]);
        let today = new Date().toLocaleDateString("en-ca");

        // line chart
        props.todaySales.forEach((s) => {
            labels.value = [...labels.value, s.created_at_time];
            data.value = [...data.value, s.total];
        });

        // left analy
        let total = computed(() =>
            props.todaySales.reduce((pv, c) => pv + Number(c.total), 0)
        );
        let saleItemQuantity = computed(() =>
            Object.values(props.totalItemQuantity).reduce(
                (pv, cv) => pv + cv,
                0
            )
        );

        let store = () =>
            showConfirm(() => {
                Inertia.post(route("dailySaleReport.store"), {
                    date: props.selectedDate,
                });
                props.isClosed = true;
            }, "Sure to close and make report?");

        let form = useForm({
            date: props.selectedDate,
        });

        const dateHandler = () => {
            if (!form.date) {
                showAlert("error", "Please choose date", "");
                return;
            }
            form.get(route("dailySaleReport"), {
                onSuccess: () => {
                    showToast("success", "Data updated");
                },
                preserveScroll: true,
            });
        };

        let dateInputHandler = () =>
            document.querySelector(".mx-input").click();

        return {
            labels,
            data,
            total,
            saleItemQuantity,
            store,
            form,
            dateHandler,
            today,
            dateInputHandler,
            disabledDates: (date) => {
                const today = new Date();
                return date > today;
            },
        };
    },
};
</script>

<style lang="scss" scoped></style>
