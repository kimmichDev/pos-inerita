<template>
    <nav class="container-fluid">
        <div class="row">
            <div
                class="bg-light shadow d-flex justify-content-between align-items-center p-2"
            >
                <div>
                    <h3 class="mb-0">POS</h3>
                </div>
                <div>
                    <div class="input-group">
                        <input type="text" class="form-control" />
                        <span class="input-group-text" id="basic-addon2"
                            ><i class="bi bi-search"></i
                        ></span>
                    </div>
                </div>
                <div>
                    <div class="card shadow">
                        <div class="card-body d-flex">
                            <p class="mb-0">
                                <span class="small text-black-50">Cashier </span
                                >{{ user.name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <slot />
    </div>
</template>

<script>
export default {
    props: ["user"],
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
