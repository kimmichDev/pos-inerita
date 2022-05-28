<template>
    <div class="d-flex my-3">
        <div
            @click="$emit('categoryId', 'all')"
            :class="[
                'mx-2 rounded-pill p-3',
                {
                    'bg-primary': currentCategory == 'all',
                    'text-white': currentCategory == 'all',
                },
            ]"
            style="cursor: pointer"
        >
            <span class="">All Categories</span>
        </div>
        <div
            @click="$emit('categoryId', category.id)"
            v-for="category in categories"
            :key="category.id"
            :class="[
                'mx-2 rounded-pill p-3',
                {
                    'bg-primary': currentCategory == category.id,
                    'text-white': currentCategory == category.id,
                },
            ]"
            style="cursor: pointer"
        >
            <span class="">{{ category.name }}</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ["categories", "currentCategory"],
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
