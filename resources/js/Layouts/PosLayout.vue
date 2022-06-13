<template>
    <nav class="container-fluid animate__animated animate__fadeIn">
        <div class="row">
            <div
                class="bg-light shadow d-flex justify-content-between align-items-center px-5 p-2"
            >
                <Link class="navbar-brand me-4" :href="route('pos')">
                    <div>
                        <img
                            :src="logo"
                            width="75"
                            class="rounded-circle border border-light shadow"
                            alt=""
                        />
                    </div>
                </Link>
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
                            disabled
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
                <div>
                    <div class="dropdown">
                        <button
                            class="btn btn-light border border-1 border-light p-1 px-3 shadow dropdown-toggle profile-btn"
                            type="button"
                            id="dropdownMenuButton2"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <div
                                class="d-flex align-items-center justify-content-between"
                            >
                                <div class="me-3">
                                    <img
                                        class="layout-profile rounded"
                                        :src="
                                            '/storage/' +
                                            user.profile_photo_path
                                        "
                                        alt=""
                                    />
                                </div>
                                <div>
                                    <p
                                        class="text-left small text-black-50 mb-0"
                                    >
                                        Cashier
                                    </p>
                                    <p class="text-left mb-0 fw-bold">
                                        {{ user.name }}
                                    </p>
                                </div>
                            </div>
                        </button>
                        <ul
                            class="dropdown-menu"
                            aria-labelledby="dropdownMenuButton2"
                        >
                            <li class="px-2">
                                <Link
                                    class="dropdown-item rounded"
                                    :href="route('dashboard')"
                                >
                                    Dashboard
                                </Link>
                            </li>
                            <li class="px-2">
                                <Link
                                    class="dropdown-item rounded"
                                    :href="route('logout')"
                                    method="post"
                                >
                                    Logout
                                </Link>
                            </li>
                        </ul>
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
    props: ["user", "errors", "logo"],
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

<style scoped>
.profile-btn {
    transition: transform 0.5s;
}
.profile-btn:hover {
    transform: scale(0.95);
}
.dropdown-toggle::after {
    display: none !important;
}
</style>
