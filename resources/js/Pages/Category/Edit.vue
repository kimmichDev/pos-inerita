<template>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="border p-3 shadow rounded mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <Link :href="route('dashboard')">
                                <i class="bi bi-house-fill"></i>
                                Home
                            </Link>
                        </li>
                        <li class="breadcrumb-item">
                            <Link :href="route('category.index')">
                                <i class="bi bi-list-ul"></i>
                                Category List
                            </Link>
                        </li>
                        <li class="breadcrumb-item active">
                            <i class="bi bi-pen"></i>
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
                <h5 class="card-header">Edit Category</h5>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input
                            @keypress.enter="update"
                            type="text"
                            class="form-control"
                            name="name"
                            v-model="form.name"
                        />
                        <small class="small text-danger" v-if="errors.name">
                            {{ errors.name }}</small
                        >
                    </div>
                    <button class="btn btn-primary" @click="update">
                        Update Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import { showToast } from "../../Composables/showToast";
export default {
    props: ["category", "errors"],

    setup(props) {
        let form = useForm({
            name: props.category.name,
            _method: "put",
        });

        let update = () => {
            form.post(route("category.update", props.category.id), {
                onSuccess: () =>
                    showToast(
                        "success",
                        form.name + " is updated successfully"
                    ),
            });
        };
        console.log(props.category);
        return { form, update };
    },
};
</script>

<style lang="scss" scoped></style>
