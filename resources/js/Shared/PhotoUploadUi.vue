<template>
    <div class="mb-3 d-flex justify-content-center">
        <div
            selectPhotoContainer
            class="w-75 position-relative"
            @click="$emit('openInput')"
        >
            <div v-if="photo">
                <img :src="photo" class="w-100 mb-3 rounded" />
                <br />
            </div>
            <p
                class="p-3 mb-0 border-1 border text-center rounded shadow"
                style="cursor: pointer"
            >
                Click to upload image
            </p>
        </div>
        <div>
            <small
                class="text-danger text-nowrap px-2 text-truncate"
                v-if="errors.photo"
            >
                {{ errors.photo }}
            </small>
        </div>
    </div>
</template>

<script>
export default {
    props: ["photo", "errors"],
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
