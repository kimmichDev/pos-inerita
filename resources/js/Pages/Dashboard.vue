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

    <div class="row">
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
                        <div class="col-5">
                            <img
                                :src="topSellerItemToday[0].photo"
                                class="w-100 object-fit rounded"
                                style="aspect-ratio: 1/1"
                                alt=""
                            />
                        </div>
                        <div class="col-7">
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
                        <div class="col-5">
                            <img
                                :src="topSellerThisMonth[0].photo"
                                class="w-100 object-fit rounded"
                                style="aspect-ratio: 1/1"
                                alt=""
                            />
                        </div>
                        <div class="col-7">
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
                <div class="card-body py-4">
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
</template>

<script>
export default {
    props: [
        "topSellerItemToday",
        "topSellerThisMonth",
        "totalSaleAmount",
        "totalSaleQuantity",
    ],
    setup() {
        return [];
    },
};
</script>

<style lang="scss" scoped></style>
