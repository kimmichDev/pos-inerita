<template>
    <Head title="Item Lists"></Head>
    <div class="animate__animated animate__fadeIn">
        <div class="row justify-content-center gy-3">
            <div class="col-12">
                <div class="border p-3 shadow rounded">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <Link :href="route('dashboard')">
                                    <i class="bi bi-house-fill"></i>
                                    Home
                                </Link>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="bi bi-list-ul"></i>
                                Item List
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-12">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Name</td>
                            <td>Price</td>
                            <td>Photo</td>
                            <td>Category</td>
                            <td class="text-nowrap">Action</td>
                            <td>Create At</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="align-middle"
                            v-for="item in items"
                            :key="item.id"
                        >
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.price }}</td>
                            <td>
                                <img
                                    :src="item.photo"
                                    class="rounded item-small-photo"
                                />
                            </td>
                            <td>{{ item.category.name }}</td>
                            <td class="text-nowrap">
                                <Link
                                    :class="[
                                        'btn btn-primary me-2',
                                        { disabled: !item.can_update },
                                    ]"
                                    :href="route('item.edit', item.id)"
                                >
                                    <i class="bi bi-pen"></i>
                                    Edit
                                </Link>
                                <button
                                    :disabled="isUploading || !item.can_delete"
                                    class="btn btn-danger text-light"
                                    @click="delConfirm(item.id)"
                                >
                                    <i class="bi bi-trash"></i>
                                    Delete
                                </button>
                            </td>
                            <td>
                                <div>
                                    <i class="me-3 bi bi-clock"></i>
                                    {{ item.created_at_time }}
                                </div>
                                <div>
                                    <i class="me-3 bi bi-calendar"></i>
                                    {{ item.created_at_date }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import { showConfirm } from "../../Composables/showConfirm";
import { showToast } from "../../Composables/showToast";
import { ref } from "@vue/reactivity";
export default {
    props: ["items"],
    setup() {
        let isUploading = ref(false);
        let delConfirm = (id) => {
            showConfirm(() => {
                isUploading.value = true;
                Inertia.delete(route("item.destroy", id), {
                    onSuccess: () => {
                        isUploading.value = false;
                        showToast("success", "Deleted successfully");
                    },
                });
            });
        };
        return { delConfirm, isUploading };
    },
};
</script>

<style lang="scss" scoped></style>
