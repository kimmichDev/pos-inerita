<template>
    <div class="card shadow">
        <div class="card-body">
            <div class="row align-items-center">
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
                        <h5 class="fw-bold">{{ item.name }}</h5>
                        <p class="fw-bold text-black-50">
                            {{ item.price }} MMK
                        </p>
                    </div>
                </div>
            </div>
            <div class="row gy-3">
                <div class="col-12">
                    <div
                        class="mt-3 d-flex justify-content-around align-items-center"
                    >
                        <div
                            class="small-rounded-btn"
                            style="cursor: pointer"
                            @click="quantity > 1 ? quantity-- : ''"
                        >
                            <i class="bi bi-dash-lg"></i>
                        </div>
                        <div class="small-rounded-btn bg-primary">
                            <span class="text-light"> {{ quantity }}</span>
                        </div>
                        <div
                            class="small-rounded-btn"
                            style="cursor: pointer"
                            @click="quantity++"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <button class="btn btn-primary w-75" @click="addToVoucher">
                        Add to bill
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
export default {
    props: ["item"],
    setup(props) {
        let quantity = ref(1);
        let store = useStore();
        let addToVoucher = () => {
            let orderedItem = {
                id: Number(store.state.Voucher.voucher.length) + 1,
                item: props.item,
                quantity: quantity.value,
            };
            store.dispatch("storeToVoucher", orderedItem);
            console.log(store.state.Voucher);
        };
        return { quantity, addToVoucher };
    },
};
</script>

<style lang="scss" scoped></style>
