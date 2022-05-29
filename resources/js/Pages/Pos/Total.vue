<template>
    <div class="card shadow">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <p class="mb-0 fw-bold">Total</p>
                <div class="d-flex align-items-center">
                    <h3 class="mb-0 me-3 text-warning fw-bold">{{ total }}</h3>
                    <small class="text-black-50">MMK</small>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from "@vue/runtime-core";
import { useStore } from "vuex";
export default {
    setup() {
        let store = useStore();
        let total = computed(() => {
            return store.state.Voucher.orders.reduce(
                (ac, ob) => ac + ob.cost,
                0
            );
        });
        return { total };
    },
};
</script>

<style lang="scss" scoped></style>
