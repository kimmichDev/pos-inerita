<template>
    <div>
        <div class="row">
            <div class="col-9">
                <div class="row">
                    <div class="col-4">
                        <img
                            :src="order.item.photo"
                            class="w-100 rounded"
                            style="aspect-ratio: 1; object-fit: cover"
                            alt=""
                        />
                    </div>
                    <div class="col-8">
                        <p class="fw-bold mb-0">{{ order.item.name }}</p>
                        <p class="small text-black-50">
                            {{ order.item.price }} MMK
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div
                            class="mt-1 d-flex justify-content-around align-items-center pe-3"
                        >
                            <div
                                class="small-rounded-btn"
                                style="cursor: pointer"
                                @click="removeQuantity"
                                v-if="currentOrder.quantity > 1"
                            >
                                <i
                                    class="bi bi-dash-lg"
                                    v-if="currentOrder.quantity > 1"
                                ></i>
                                <i class="bi bi-trash" v-else></i>
                            </div>
                            <button
                                @click="removeQuantity"
                                class="btn btn-danger btn-sm text-light"
                                v-else
                            >
                                <i class="bi bi-trash"></i>
                            </button>
                            <div class="small-rounded-btn bg-warning">
                                <span class="text-light"
                                    >{{ currentOrder.quantity }}
                                </span>
                            </div>
                            <div
                                class="small-rounded-btn"
                                style="cursor: pointer"
                                @click="addQuantity"
                            >
                                <i class="bi bi-plus-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <h5 class="fw-bolder text-warning">
                        {{ currentOrder.cost }}
                    </h5>
                    <small class="text-black-50">MMK</small>
                </div>
            </div>
        </div>
    </div>
    <hr />
</template>

<script>
import { ref } from "@vue/reactivity";
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
        };
        let removeQuantity = () => {
            if (currentOrder.value.quantity > 1) {
                currentOrder.value.quantity--;
                currentOrder.value.cost =
                    props.order.item.price * currentOrder.value.quantity;
            } else {
                store.state.Voucher.orders.splice(
                    store.state.Voucher.orders.indexOf(currentOrder.value),
                    1
                );
            }
        };
        return { currentOrder, addQuantity, removeQuantity };
    },
};
</script>

<style lang="scss" scoped></style>
