<template>
    <div>
        <div class="row gx-3">
            <div class="col-3">
                <img
                    :src="order.item.photo"
                    class="w-100 rounded"
                    style="aspect-ratio: 1; object-fit: cover"
                    alt=""
                />
            </div>
            <div class="col-9">
                <p class="fw-bold mb-0 text-nowrap text-truncate">
                    {{ order.item.name }}
                </p>
                <div class="my-2">
                    <div class="mt-1 d-flex align-items-center">
                        <div
                            class="small-rounded-btn"
                            @click="removeQuantity"
                            v-if="currentOrder.quantity > 1"
                        >
                            <i
                                class="bi bi-dash-lg"
                                v-if="currentOrder.quantity > 1"
                            ></i>
                            <i class="bi bi-trash" v-else></i>
                        </div>
                        <div
                            @click="removeQuantity"
                            class="small-rounded-btn text-danger"
                            v-else
                        >
                            <i class="bi bi-trash"></i>
                        </div>
                        <div class="small-rounded-btn bg-warning mx-2">
                            <span class="text-light"
                                >{{ order.quantity }}
                            </span>
                        </div>
                        <div class="small-rounded-btn" @click="addQuantity">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                    </div>
                    <!-- <h5 class="fw-bolder text-warning">
                        {{ currentOrder.cost }}
                    </h5>
                    <small class="text-black-50">MMK</small> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div
                    class="d-flex align-items-center mt-3 justify-content-between"
                >
                    <small class="text-black-50 fw-bold">
                        {{ order.quantity }} x {{ order.item.price }} MMK
                    </small>
                    <h5 class="text-warning fw-bold mb-0">
                        {{ order.cost }} MMK
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <hr />
</template>

<script>
import { useStore } from "vuex";
import { computed } from "@vue/runtime-core";
export default {
    props: ["order"],
    setup(props) {
        let store = useStore();

        let currentOrder = computed(() => {
            return store.state.Voucher.orders.find(
                (o) => o.id == props.order.id
            );
        });

        let addQuantity = () => {
            currentOrder.value.quantity++;
            currentOrder.value.cost =
                props.order.item.price * currentOrder.value.quantity;
            localStorage.setItem(
                "localOrders",
                JSON.stringify(store.state.Voucher.orders)
            );
        };
        let orders = computed(() => store.state.Voucher.orders);
        let removeQuantity = () => {
            if (currentOrder.value.quantity > 1) {
                currentOrder.value.quantity--;
                currentOrder.value.cost =
                    props.order.item.price * currentOrder.value.quantity;
                localStorage.setItem(
                    "localOrders",
                    JSON.stringify(orders.value)
                );
            } else {
                orders.value.splice(
                    orders.value.indexOf(currentOrder.value),
                    1
                );
                localStorage.setItem(
                    "localOrders",
                    JSON.stringify(orders.value)
                );
                orders.value.length < 1 &&
                    localStorage.removeItem("localOrders");
            }
        };
        return { currentOrder, addQuantity, removeQuantity };
    },
};
</script>

<style lang="scss" scoped></style>
