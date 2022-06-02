<template>
    <div class="d-flex justify-content-center">
        <button class="btn btn-success w-50 p-3" @click="storeVouchers">
            <i class="bi bi-cash-stack me-2"></i>
            <span>Checkout</span>
        </button>
    </div>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import { useStore } from "vuex";
import { computed } from "@vue/runtime-core";
import uniqid from "uniqid";
import { showToast } from "../../Composables/showToast";
import { showConfirm } from "../../Composables/showConfirm";
export default {
    setup() {
        let store = useStore();

        let form = useForm({
            customerName: computed({
                get() {
                    return store.state.Voucher.customerName;
                },
            }),
            voucherNumber: computed({
                get() {
                    return store.state.Voucher.voucher_number;
                },
            }),
            vouchers: computed({
                get() {
                    return store.state.Voucher.orders;
                },
            }),
            total: computed({
                get: () => store.state.Voucher.total,
            }),
        });

        let storeVouchers = () =>
            showConfirm(
                () =>
                    form.post(route("voucher.store"), {
                        onSuccess: () => {
                            store.state.Voucher.orders = [];
                            localStorage.removeItem("localOrders");
                            store.dispatch(
                                "updateVoucherNumber",
                                uniqid("voucher-")
                            );
                            store.dispatch("updateCustomerName", "");
                            showToast("success", "Checkout successfully");
                        },
                    }),
                "Sure to chekout?"
            );

        return { storeVouchers };
    },
};
</script>

<style lang="scss" scoped></style>
