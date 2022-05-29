<template>
    <div class="card shadow">
        <div class="card-body">
            <div class="row align-items-center mb-3">
                <div class="col-5">
                    <div>
                        <img
                            :src="item.photo"
                            class="w-100 h-100 rounded"
                            style="object-fit: cover; aspect-ratio: 1"
                            alt=""
                        />
                    </div>
                </div>
                <div class="col-7">
                    <div>
                        <h5 class="fw-bold text-truncate text-nowrap">
                            {{ item.name }}
                        </h5>
                        <p class="fw-bold text-black-50">
                            {{ item.price }} MMK
                        </p>
                    </div>
                </div>
            </div>
            <div class="row gy-3">
                <div class="col-12 d-flex justify-content-center">
                    <button
                        class="btn btn-warning text-light w-75"
                        @click="addToVoucher"
                        :disabled="isAlreadyAdded"
                    >
                        <span v-if="isAlreadyAdded">In the bill</span>
                        <span v-else>Add</span>
                        <i class="bi bi-cart-plus-fill ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "@vue/reactivity";
import { useStore } from "vuex";
import { computed } from "@vue/runtime-core";
export default {
    props: ["item"],
    setup(props) {
        let quantity = ref(1);
        let store = useStore();

        let isAlreadyAdded = computed(() => {
            return store.state.Voucher.orders.some(
                (o) => o.item.id == props.item.id
            );
        });
        let addToVoucher = () => {
            let orderedItem = {
                id: Number(store.state.Voucher.orders.length) + 1,
                item: props.item,
                quantity: quantity.value,
                cost: Number(props.item.price),
            };
            store.dispatch("storeToVoucher", orderedItem);
            console.log(isAlreadyAdded.value);
        };
        return { quantity, addToVoucher, isAlreadyAdded };
    },
};
</script>

<style lang="scss" scoped></style>
