<template>
    <Welcome />
</template>

<script>
import { defineComponent } from "vue";
import JetApplicationLogo from "@/Jetstream/ApplicationLogo.vue";
import Welcome from "../Pages/Welcome.vue";

export default defineComponent({
    components: {
        Welcome,
        JetApplicationLogo,
    },
});
</script>
