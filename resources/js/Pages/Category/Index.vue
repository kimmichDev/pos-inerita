<template>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="border p-3 shadow rounded mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a :href="route('dashboard')">
                                <i class="bi bi-house-fill"></i>
                                Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <i class="bi bi-list-ul"></i>
                            Category List
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Name</td>
                        <td>Action</td>
                        <td>Create At</td>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="align-middle"
                        v-for="category in categories"
                        :key="category.id"
                    >
                        <td>{{ category.id }}</td>
                        <td>{{ category.name }}</td>
                        <td>
                            <Link
                                :href="route('category.edit', category.id)"
                                class="btn btn-primary me-1"
                            >
                                <i class="bi bi-pen"></i>
                                Edit
                            </Link>
                            <button
                                @click="destroy(category.id)"
                                class="btn btn-danger"
                            >
                                <i class="bi bi-trash"></i>
                                Delete
                            </button>
                        </td>
                        <td>
                            <div>
                                <i class="me-3 bi bi-clock"></i>
                                {{ category.created_at_date }}
                            </div>
                            <div>
                                <i class="me-3 bi bi-calendar"></i>
                                {{ category.created_at_time }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import Button from "../../Jetstream/Button.vue";
import { showToast } from "../../Composables/showToast";
export default {
    components: { Button },
    props: ["categories"],
    setup(props) {
        let destroy = (id) => {
            Inertia.delete(route("category.destroy", id), {
                onSuccess: () => showToast("success", "Deleted successsfully"),
            });
        };
        return { destroy };
    },
};
</script>

<style lang="scss" scoped></style>
