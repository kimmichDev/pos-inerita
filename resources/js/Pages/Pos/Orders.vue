<template>
    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Current Order</h5>
            <button
                @click="$store.state.Voucher.orders = []"
                class="btn btn-outline-danger btn-sm rounded-pill"
            >
                Clear All
            </button>
        </div>
    </div>
    <div>
        <div
            class="card shadow"
            style="width: 100%; max-height: 350px; overflow-y: auto"
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
</template>

<script>
import Total from "./Total";
import Order from "./Order";
import { computed } from "@vue/runtime-core";
import { useStore } from "vuex";
export default {
    components: {
        Total,
        Order,
    },
    setup() {
        let store = useStore();
        let orders = computed(() => store.state.Voucher.orders);
        return { orders };
    },
};
</script>

<style lang="scss" scoped></style>
