<template>
    <div
        :class="[
            'card shadow cur-pointer',
            {
                'jelly-ani': isAlreadyAdded,
                'pointer-event-disable': isAlreadyAdded,
            },
        ]"
        @click="addToVoucher"
    >
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="mb-3">
                        <img
                            :src="item.photo"
                            class="w-100 h-100 rounded"
                            style="object-fit: cover; aspect-ratio: 4/3"
                            alt=""
                        />
                    </div>
                </div>
                <div class="col-12">
                    <div>
                        <p class="fw-bold text-truncate text-nowrap">
                            {{ item.name }}
                        </p>
                        <h5 class="fw-bold text-warning">
                            {{ item.price }} MMK
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "@vue/reactivity";
import { useStore } from "vuex";
import { computed } from "@vue/runtime-core";
import { showConfirm } from "../../Composables/showConfirm";
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
            showConfirm(() => {
                let orderedItem = {
                    id: Number(store.state.Voucher.orders.length) + 1,
                    item: props.item,
                    quantity: quantity.value,
                    cost: Number(props.item.price),
                };

                store.dispatch("storeToVoucher", orderedItem);
                console.log(store.state.Voucher.orders);
                console.log(isAlreadyAdded.value);
            }, "Sure to add?");
        };
        return { quantity, addToVoucher, isAlreadyAdded };
    },
};
</script>

<style lang="scss" scoped></style>
