<template>
    <div class="row justify-content-center my-3">
        <div class="col-12">
            <div class="card shadow bg-light">
                <div
                    class="card-body bg-white px-5 py-3 border-bottom rounded-top"
                >
                    <p>Welcome to pos</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import JetApplicationLogo from "@/Jetstream/ApplicationLogo.vue";

export default defineComponent({
    components: {
        JetApplicationLogo,
    },
});
</script>
