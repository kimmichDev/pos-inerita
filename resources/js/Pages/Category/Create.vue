<template>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="border p-3 shadow rounded mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a :href="route('dashboard')">
                                <i class="bi bi-house-fill"></i>
                                Home
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <Link :href="route('category.index')">
                                <i class="bi bi-list-ul"></i>
                                Category List
                            </Link>
                        </li>
                        <li class="breadcrumb-item active">
                            <i class="bi bi-plus-circle-fill"></i>
                            Create
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card">
                <h5 class="card-header">Create Category</h5>
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
                                v-model="form.name"
                            />
                            <small class="invalid-feedback" v-if="errors.name">
                                {{ errors.name }}
                            </small>
                        </div>
                        <button class="btn btn-primary">Create Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import { showToast } from "../../Composables/showToast";
export default {
    props: ["errors"],
    setup() {
        let form = useForm({
            name: null,
        });

        let store = () => {
            form.post(route("category.store"), {
                onSuccess: () =>
                    showToast(
                        "success",
                        form.name + " is created successfully"
                    ),
            });
        };
        return { form, store };
    },
};
</script>

<style lang="scss" scoped></style>
