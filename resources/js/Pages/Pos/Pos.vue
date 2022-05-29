<template>
    <div class="row">
        <div class="col-8">
            <PosNav
                @categoryId="changeCategory"
                :categories="categories"
                :currentCategory="currentCategory"
            ></PosNav>
            <div class="row gy-3">
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
                        <Orders
                            v-if="this.$store.state.Voucher.orders.length > 0"
                        ></Orders>
                        <div class="mt-3" v-else>
                            <h5 class="mb-0 fw-bold">No Orders 👀</h5>
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
import { computed } from "@vue/runtime-core";
export default {
    components: {
        Orders,
        ItemCard,
        PosNav,
        PosLayout,
    },
    layout: PosLayout,
    props: ["items", "categories"],
    setup(props) {
        let currentCategory = ref("all");
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
        return {
            changeCategory,
            filteredItems,
            currentCategory,
            currentCategoryName,
        };
    },
};
</script>

<style lang="scss" scoped></style>
