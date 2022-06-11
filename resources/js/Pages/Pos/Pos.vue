<template>
    <Head title="POS"></Head>
    <div class="row">
        <div class="col-8">
            <PosNav
                @categoryId="changeCategory"
                :categories="categories"
                :currentCategory="currentCategory"
            ></PosNav>
            <div class="row g-3" style="max-height: 83vh; overflow-y: auto">
                <div class="col-12">
                    <h5
                        v-if="filteredItems.length > 0"
                        class="text-black-50 fw-bold"
                    >
                        {{ currentCategoryName }}
                    </h5>
                    <h3 v-else class="text-black-50">No items available</h3>
                </div>
                <div class="col-4" v-for="item in filteredItems" :key="item.id">
                    <ItemCard :item="item" />
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="mt-3">
                <div class="row">
                    <div class="col-12">
                        <div class="">
                            <div class="card border-0 shadow">
                                <div class="card-body">
                                    <Orders v-if="whenToMountOrders"></Orders>
                                    <div class="" v-else>
                                        <h5 class="mb-0 fw-bold">
                                            No Orders 👀
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Orders from "./Orders";
import ItemCard from "./ItemCard";
import PosNav from "./PosNav";
import PosLayout from "../../Layouts/PosLayout";
import { ref } from "@vue/reactivity";
import { computed, onMounted } from "@vue/runtime-core";
import { useStore } from "vuex";
export default {
    components: {
        Orders,
        ItemCard,
        PosNav,
        PosLayout,
    },
    layout: PosLayout,
    props: ["items", "categories", "errors"],
    setup(props) {
        let currentCategory = ref("all");

        let store = useStore();
        let whenToMountOrders = computed(
            () =>
                store.state.Voucher.orders.length > 0 ||
                localStorage.getItem("localOrders")
        );

        let filteredItems = computed(() => {
            if (currentCategory.value == "all") {
                return props.items;
            } else {
                return props.items.filter(
                    (i) => i.category_id == currentCategory.value
                );
            }
        });

        let changeCategory = (id) => {
            currentCategory.value = id;
        };
        let currentCategoryName = computed(() => {
            if (currentCategory.value == "all") {
                return "All Menu";
            } else {
                return (
                    props.categories.find((c) => c.id == currentCategory.value)
                        .name + " Menu"
                );
            }
        });

        onMounted(() => {
            if (JSON.parse(localStorage.getItem("localOrders"))) {
                store.state.Voucher.orders = JSON.parse(
                    localStorage.getItem("localOrders")
                );
            } else {
                store.state.Voucher.orders = [];
            }
        });

        return {
            changeCategory,
            filteredItems,
            currentCategory,
            currentCategoryName,
            whenToMountOrders,
        };
    },
};
</script>

<style lang="scss" scoped></style>
