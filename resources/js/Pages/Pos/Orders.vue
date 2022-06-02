<template>
    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">
                Current Order<span v-if="orderQuantity > 1">s</span>
                <span class="text-warning ms-2">{{ orderQuantity }}</span>
            </h5>
            <button
                @click="clearAll"
                class="btn btn-outline-danger btn-sm rounded-pill"
            >
                Clear All
            </button>
        </div>
    </div>
    <div>
        <div
            class="card shadow"
            style="width: 100%; max-height: 50vh; overflow-y: auto"
        >
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-12" v-for="order in orders" :key="order.id">
                        <Order :order="order"></Order>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <Total />
    </div>
    <div class="mt-3">
        <Checkout />
    </div>
</template>

<script>
import Checkout from "./Checkout";
import Total from "./Total";
import Order from "./Order";
import { computed, onMounted } from "@vue/runtime-core";
import { useStore } from "vuex";
export default {
    components: {
        Checkout,
        Total,
        Order,
    },
    setup() {
        let store = useStore();

        let orderQuantity = computed(() =>
            store.state.Voucher.orders.reduce((ac, ob) => ac + ob.quantity, 0)
        );
        let orders = computed(() => store.state.Voucher.orders);
        let clearAll = () => {
            store.state.Voucher.orders = [];
            localStorage.removeItem("localOrders");
        };
        return { orders, orderQuantity, clearAll };
    },
};
</script>

<style lang="scss" scoped></style>
