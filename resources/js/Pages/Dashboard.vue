<template>
    <Head title="Dashboard"></Head>
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex">
            <i class="bi bi-graph-up"></i>
            <h5 class="mb-0 fw-bold text-black-50 ms-3">Dashboard</h5>
        </div>

        <div class="">
            <Link :href="route('pos')" class="">
                <div class="btn-group">
                    <button class="btn btn-outline-primary">
                        <i class="bi bi-box-arrow-left me-2"></i>
                    </button>
                    <button class="btn btn-primary">
                        <span>POS</span>
                    </button>
                </div>
            </Link>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-4">
            <div class="card rounded-lg shadow">
                <div class="card-header py-3 fw-bold text-black-50">
                    Top Selling Item Today
                </div>
                <div class="card-body">
                    <div
                        class="row align-items-center"
                        v-if="topSellerItemToday == 'No item'"
                    >
                        <h5 class="fw-bold text-black-50 mb-0 text-center">
                            {{ topSellerItemToday }}
                        </h5>
                    </div>
                    <div class="row align-items-center" v-else>
                        <div class="col-6">
                            <img
                                :src="topSellerItemToday[0].photo"
                                class="w-100 object-fit rounded"
                                style="aspect-ratio: 1/1"
                                alt=""
                            />
                        </div>
                        <div class="col-6">
                            <h5 class="text-nowrap text-truncate fw-bolder">
                                {{ topSellerItemToday[0].name }}
                            </h5>
                            <p class="fw-bold mb-0 text-black-50">
                                {{ topSellerItemToday[0].price }} MMK
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card rounded-lg shadow">
                <div class="card-header py-3 fw-bold text-black-50">
                    Top Selling Item This Month
                </div>
                <div class="card-body">
                    <div
                        class="row align-items-center"
                        v-if="topSellerThisMonth == 'No item'"
                    >
                        <h5 class="fw-bold text-black-50 mb-0 text-center">
                            {{ topSellerThisMonth }}
                        </h5>
                    </div>
                    <div class="row align-items-center" v-else>
                        <div class="col-6">
                            <img
                                :src="topSellerThisMonth[0].photo"
                                class="w-100 object-fit rounded"
                                style="aspect-ratio: 1/1"
                                alt=""
                            />
                        </div>
                        <div class="col-6">
                            <h5 class="text-nowrap text-truncate fw-bolder">
                                {{ topSellerThisMonth[0].name }}
                            </h5>
                            <p class="fw-bold mb-0 text-black-50">
                                {{ topSellerThisMonth[0].price }} MMK
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card rounded-lg shadow">
                <div class="card-header py-3 fw-bold text-black-50">
                    This Month Sales
                </div>
                <div class="card-body py-5">
                    <div
                        class="row align-items-center"
                        v-if="totalSaleQuantity == 'No data'"
                    >
                        <h5 class="fw-bold text-black-50 mb-0 text-center">
                            {{ totalSaleQuantity }}
                        </h5>
                    </div>
                    <div class="row align-items-center" v-else>
                        <div class="col-12">
                            <div
                                class="d-flex justify-content-center align-items-center mb-3"
                            >
                                <h3
                                    class="text-nowrap text-truncate fw-bolder me-3"
                                >
                                    {{ totalSaleQuantity }}
                                </h3>
                                <p class="fw-bold mb-0 text-black-50">Items</p>
                            </div>
                            <div
                                class="d-flex justify-content-center align-items-center"
                            >
                                <h3
                                    class="text-nowrap text-truncate fw-bolder me-3"
                                >
                                    {{ totalSaleAmount }}
                                </h3>
                                <p class="fw-bold mb-0 text-black-50">MMK</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <div
                        class="d-flex justify-content-between align-items-center"
                    >
                        <span class="fw-bold text-black-50"
                            >Daily Vouchers List</span
                        >
                        <div
                            class="input-group align-items-stretch w-auto me-3"
                        >
                            <date-picker
                                v-model:value="form.dvd"
                                value-type="format"
                                format="DD-MMM-YYYY"
                                :clearable="false"
                                :default-value="form.dvd"
                                :disabled-date="disabledDates"
                                @change="dateHandler"
                            ></date-picker>
                            <button
                                class="btn btn-primary btn-sm"
                                @click="dateInputHandler"
                            >
                                Select date
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body" v-if="dailyVouchers.data.length < 1">
                    <div class="text-center">
                        <p>No data available</p>
                        <NoDataFound class="w-25 m-auto"></NoDataFound>
                    </div>
                </div>
                <div class="card-body" v-else>
                    <div class="row align-items-center">
                        <div class="col-5">
                            <div class="px-5">
                                <DoughnutChart
                                    :labels="dailyVoucherNumber"
                                    :data="dailyVoucherTotal"
                                />
                            </div>
                        </div>
                        <div class="col-7">
                            <div
                                class="mb-3 d-flex align-items-center justify-content-end"
                            >
                                <div>
                                    <Link
                                        :href="
                                            route('dashboardDailyVoucher.pdf', {
                                                date: selectedDate,
                                            })
                                        "
                                        class="btn btn-outline-primary"
                                    >
                                        Export to pdf
                                        <i class="bi bi-filetype-pdf ms-2"></i>
                                    </Link>
                                </div>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Voucher Number</th>
                                        <th>Customer Name</th>
                                        <th>Total</th>
                                        <th>Purchase Time</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr
                                        v-for="voucher in dailyVouchers.data"
                                        :key="voucher.id"
                                    >
                                        <td>{{ voucher.voucher_number }}</td>
                                        <td>{{ voucher.customer_name }}</td>
                                        <td>{{ voucher.total }}</td>
                                        <td>{{ voucher.created_at_time }}</td>
                                        <td>{{ voucher.date }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div
                                class="d-flex justify-content-center align-items-center"
                            >
                                <Paginator :links="dailyVouchers.meta.links" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <div
                        class="d-flex justify-content-between align-items-center"
                    >
                        <span class="fw-bold text-black-50">Monthly Sales</span>
                        <div
                            class="input-group align-items-stretch w-auto me-3"
                        >
                            <date-picker
                                v-model:value="monthForm.month"
                                value-type="format"
                                format="MMM-YYYY"
                                type="month"
                                :clearable="false"
                                :default-value="monthForm.month"
                                :disabled-date="disabledDates"
                                @change="monthDateHandler"
                            ></date-picker>
                            <button
                                class="btn btn-primary btn-sm"
                                @click="monthInputHandler"
                            >
                                Select month
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body" v-if="dailySaleReports.data.length < 1">
                    <div class="text-center">
                        <p>No data available</p>
                        <NoDataFound class="w-25 m-auto"></NoDataFound>
                    </div>
                </div>
                <div class="card-body" v-else>
                    <div class="row align-items-center">
                        <div class="col-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr
                                        v-for="dsr in dailySaleReports.data"
                                        :key="dsr.id"
                                    >
                                        <td>{{ dsr.date }}</td>
                                        <td>{{ dsr.total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div
                                class="d-flex justify-content-center align-items-center"
                            >
                                <Paginator :links="dailySaleReports.links" />
                            </div>
                        </div>

                        <div class="col-9">
                            <BarChart
                                :labels="dailySaleReportDate"
                                :data="dailySaleReportTotal"
                            ></BarChart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BarChart from "./Components/BarChart";
import PolarArea from "./Components/PolarArea";
import NoDataFound from "./Components/NoDataFound";
import Paginator from "./Components/Paginator";
import DoughnutChart from "./Components/DoughnutChart";
import { useForm } from "@inertiajs/inertia-vue3";
import DatePicker from "vue-datepicker-next";
import "vue-datepicker-next/index.css";
import { showToast } from "../Composables/showToast";
import { ref } from "@vue/reactivity";
export default {
    components: {
        BarChart,
        PolarArea,
        NoDataFound,
        Paginator,
        DoughnutChart,
        DatePicker,
    },
    props: [
        "topSellerItemToday",
        "topSellerThisMonth",
        "totalSaleAmount",
        "totalSaleQuantity",
        "dailyVouchers",
        "dailyVoucherNumber",
        "dailyVoucherTotal",
        "dailySaleReports",
        "selectedDate",
        "selectedMonth",
        "dailySaleReportDate",
        "dailySaleReportTotal",
    ],
    setup(props) {
        let bgColors = ref([]);
        props.dailySaleReportTotal.forEach(
            () =>
                (bgColors.value = [
                    ...bgColors.value,
                    "hsl(" + Math.random() * 360 + ", 100%, 75%,0.5)",
                ])
        );
        let form = useForm({
            dvd: props.selectedDate,
        });
        let monthForm = useForm({
            month: props.selectedMonth,
        });
        const dateHandler = () => {
            if (!form.dvd) {
                showAlert("error", "Please choose date", "");
                return;
            }
            form.get(route("dashboard"), {
                onSuccess: () => {
                    showToast("success", "Data updated");
                },
            });
        };

        const monthDateHandler = () => {
            if (!monthForm.month) {
                showAlert("error", "Please choose date", "");
                return;
            }
            monthForm.get(route("dashboard"), {
                onSuccess: () => {
                    showToast("success", "Data updated");
                },
            });
        };

        let dateInputHandler = () =>
            document.querySelectorAll(".mx-input")[0].click();
        let monthInputHandler = () =>
            document.querySelectorAll(".mx-input")[1].click();

        let disabledDates = (date) => {
            const today = new Date();
            return date > today;
        };
        return {
            form,
            monthForm,
            dateHandler,
            monthDateHandler,
            dateInputHandler,
            monthInputHandler,
            disabledDates,
            bgColors,
        };
    },
};
</script>

<style lang="scss" scoped></style>
