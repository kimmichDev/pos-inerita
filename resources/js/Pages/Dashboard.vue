<template>
    <Welcome />
</template>

<script>
import { showAlert } from "../Composables/showAlert";
import Welcome from "../Jetstream/Welcome.vue";
export default {
    props: ["error_page"],
    components: { Welcome },
    setup(props) {
        props.error_page && showAlert("error", props.error_page, "");
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
