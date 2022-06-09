<template>
    <Link :href="route('pos')" class="btn btn-primary"> To POS </Link>
    <Link :href="route('dashboard')" class="btn btn-outline-primary ms-3">
        To Dashboard
    </Link>
</template>

<script>
import { onMounted } from "@vue/runtime-core";
import { showAlert } from "../Composables/showAlert";
export default {
    props: ["error_page"],
    setup(props) {
        onMounted(
            () => props.error_page && showAlert("error", props.error_page, "")
        );
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
