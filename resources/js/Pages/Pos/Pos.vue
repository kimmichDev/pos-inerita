<template>
    <div class="row">
        <div class="col-8">
            <PosNav
                @categoryId="changeCategory"
                :categories="categories"
                :currentCategory="currentCategory"
            ></PosNav>
            <div class="row">
                <div class="col-12">
                    <h5 v-if="filteredItems.length > 0">
                        {{ currentCategoryName }}
                    </h5>
                    <h3 v-else>No items available</h3>
                </div>
                <div
                    class="col-4"
                    v-for="item in filteredItems"
                    :key="item.length"
                >
                    <ItemCard :item="item" />
                </div>
            </div>
        </div>
        <div class="col-4"></div>
    </div>
</template>

<script>
import ItemCard from "./ItemCard";
import PosNav from "./PosNav";
import PosLayout from "../../Layouts/PosLayout";
import { ref } from "@vue/reactivity";
import { computed } from "@vue/runtime-core";
export default {
    components: {
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
