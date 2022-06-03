<template>
    <nav class="container-fluid">
        <div class="row">
            <div
                class="bg-light shadow d-flex justify-content-between align-items-center p-2"
            >
                <div>
                    <h3 class="mb-0">POS</h3>
                </div>
                <div class="d-flex">
                    <div class="me-2">
                        <input
                            type="text"
                            v-model="customerName"
                            :class="[
                                'form-control',
                                { 'is-invalid': errors.customerName },
                            ]"
                            placeholder="Customer Name"
                        />
                        <small
                            :class="{ 'invalid-feedback': errors.customerName }"
                        >
                            {{ errors.customerName }}
                        </small>
                    </div>
                    <div class="me-2">
                        <input
                            type="text"
                            v-model="voucherNumber"
                            :class="[
                                'form-control',
                                { 'is-invalid': errors.voucherNumber },
                            ]"
                        />
                        <small
                            :class="{
                                'invalid-feedback': errors.voucherNumber,
                            }"
                        >
                            {{ errors.voucherNumber }}
                        </small>
                    </div>
                    <div>
                        <input
                            type="text"
                            disabled
                            class="form-control"
                            :value="this.$store.getters.getDate"
                        />
                    </div>
                </div>
                <!-- <div>
                    <div class="input-group">
                        <input type="text" class="form-control" />
                        <span class="input-group-text" id="basic-addon2"
                            ><i class="bi bi-search"></i
                        ></span>
                    </div>
                </div> -->
                <div>
                    <div class="card shadow">
                        <div class="card-body d-flex">
                            <p class="mb-0">
                                <span class="small text-black-50">Cashier </span
                                >{{ user.name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <slot />
    </div>
</template>

<script>
import { computed, ref } from "@vue/runtime-core";
import { useStore } from "vuex";
export default {
    props: ["user", "errors"],
    setup() {
        let store = useStore();

        let voucherNumber = computed({
            get() {
                return store.state.Voucher.voucher_number;
            },
            set(value) {
                store.dispatch("updateVoucherNumber", value);
            },
        });

        let customerName = computed({
            get() {
                return store.state.Voucher.customerName;
            },
            set(value) {
                store.dispatch("updateCustomerName", value);
            },
        });
        return { voucherNumber, customerName };
    },
};
</script>

<style lang="scss" scoped></style>
