<template>
    <Head title="Edit item"></Head>
    <div class="animate__animated animate__fadeIn">
        <div class="row justify-content-center mb-3">
            <div class="col-12 col-md-6">
                <div class="border p-3 shadow rounded">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <Link :href="route('dashboard')">
                                    <i class="bi bi-house-fill"></i>
                                    Home
                                </Link>
                            </li>
                            <li class="breadcrumb-item">
                                <Link :href="route('item.index')">
                                    <i class="bi bi-list-ul"></i>
                                    Item List
                                </Link>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="bi bi-plus-circle-fill"></i>
                                Edit
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    <h5 class="card-header mb-3">Edit item</h5>
                    <PhotoUploadUi
                        @open-input="openInput"
                        :errors="errors"
                        :photo="item.photo"
                    />
                    <div class="card-body">
                        <form @submit.prevent="store">
                            <div class="mb-3">
                                <label for="" class="form-label">Name</label>
                                <input
                                    type="text"
                                    :class="[
                                        'form-control',
                                        { 'is-invalid': errors.name },
                                    ]"
                                    name="name"
                                    v-model="form.name"
                                />
                                <small
                                    class="invalid-feedback"
                                    v-if="errors.name"
                                    >{{ errors.name }}</small
                                >
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Price</label>
                                <input
                                    type="number"
                                    :class="[
                                        'form-control',
                                        { 'is-invalid': errors.price },
                                    ]"
                                    name="price"
                                    v-model="form.price"
                                />
                                <small
                                    class="invalid-feedback"
                                    v-if="errors.price"
                                    >{{ errors.price }}</small
                                >
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label"
                                    >Category</label
                                >
                                <select
                                    name="category_id"
                                    :class="[
                                        'form-select',
                                        { 'is-invalid': errors.category_id },
                                    ]"
                                    v-model="form.category_id"
                                >
                                    <option
                                        v-for="category in categories"
                                        :key="category.id"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </select>
                                <small
                                    class="invalid-feedback"
                                    v-if="errors.category_id"
                                    >{{ errors.category_id }}</small
                                >
                            </div>
                            <input
                                type="file"
                                name="photo"
                                class="photoInput d-none"
                                @change="loadPhoto"
                                @input="form.photo = $event.target.files[0]"
                            />
                            <button class="btn btn-primary">Edit Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PhotoUploadUi from "../../Shared/PhotoUploadUi";
import { loadPhoto } from "../../Composables/loadPhoto";
import { useForm } from "@inertiajs/inertia-vue3";
import { showToast } from "../../Composables/showToast";
export default {
    components: { PhotoUploadUi },
    props: ["item", "categories", "errors"],
    setup(props) {
        let openInput = () => {
            document.querySelector(".photoInput").click();
        };

        let form = useForm({
            name: props.item.name,
            price: props.item.price,
            category_id: props.item.category_id,
            photo: null,
            _method: "put",
        });
        let store = () => {
            form.post(route("item.update", props.item.id), {
                preserveScroll: true,
                onSuccess: () => {
                    showToast("success", "Edited sucessfully");
                },
            });
        };
        return { openInput, loadPhoto, form, store };
    },
};
</script>

<style lang="scss" scoped></style>
