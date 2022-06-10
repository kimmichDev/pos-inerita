<template>
    <div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li
                    :class="[
                        'page-item',
                        { disabled: link.url == null },
                        { active: link.active },
                    ]"
                    v-for="link in links"
                    :key="link.label"
                >
                    <Link
                        class="page-link"
                        :href="link.url"
                        v-html="link.label"
                    ></Link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    props: ["links"],
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
