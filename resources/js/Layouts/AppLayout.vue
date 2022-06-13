<template>
    <div class="animate__animated animate__fadeIn">
        <jet-banner />

        <nav
            class="navbar navbar-expand-md navbar-light blur-nav border-bottom sticky-top mb-3"
        >
            <div class="container">
                <!-- Logo -->
                <Link class="navbar-brand me-4" :href="route('pos')">
                    <div>
                        <img
                            :src="logo"
                            width="75"
                            class="rounded-circle border border-light shadow"
                            alt=""
                        />
                    </div>
                </Link>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div
                    class="collapse navbar-collapse"
                    id="navbarSupportedContent"
                    v-if="user"
                >
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <jet-nav-link
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </jet-nav-link>

                        <!-- category -->
                        <jet-dropdown id="settingsDropdown">
                            <template #trigger>
                                <span>
                                    <span
                                        :class="{
                                            'text-black':
                                                $page.url.startsWith(
                                                    '/category'
                                                ),
                                        }"
                                        >Category</span
                                    >
                                    <svg
                                        class="ms-2"
                                        width="18"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                            </template>

                            <template #content>
                                <h6 class="dropdown-header small text-muted">
                                    Manage Category
                                </h6>

                                <jet-dropdown-link
                                    :href="route('category.create')"
                                >
                                    Category Create
                                </jet-dropdown-link>

                                <jet-dropdown-link
                                    :href="route('category.index')"
                                >
                                    Category List
                                </jet-dropdown-link>
                            </template>
                        </jet-dropdown>

                        <!-- item -->
                        <jet-dropdown id="settingsDropdown">
                            <template #trigger>
                                <span>
                                    <span
                                        :class="{
                                            'text-black':
                                                $page.url.startsWith('/item'),
                                        }"
                                        >Item</span
                                    >
                                    <svg
                                        class="ms-2"
                                        width="18"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                            </template>

                            <template #content>
                                <h6 class="dropdown-header small text-muted">
                                    Manage Item
                                </h6>

                                <jet-dropdown-link :href="route('item.create')">
                                    Item Create
                                </jet-dropdown-link>

                                <jet-dropdown-link :href="route('item.index')">
                                    Item List
                                </jet-dropdown-link>
                            </template>
                        </jet-dropdown>

                        <!-- sales report -->
                        <jet-dropdown id="settingsDropdown">
                            <template #trigger>
                                <span>
                                    <span
                                        :class="{
                                            'text-black':
                                                $page.url.startsWith(
                                                    '/daily'
                                                ) ||
                                                $page.url.startsWith(
                                                    '/monthly'
                                                ),
                                        }"
                                        >Reports</span
                                    >
                                    <svg
                                        class="ms-2"
                                        width="18"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                            </template>

                            <template #content>
                                <h6 class="dropdown-header small text-muted">
                                    Sale Reports
                                </h6>

                                <jet-dropdown-link
                                    :href="route('dailySaleReport')"
                                >
                                    Daily Sale Reports
                                </jet-dropdown-link>

                                <jet-dropdown-link
                                    :href="route('monthlySaleReport')"
                                >
                                    Monthly Sale Reports
                                </jet-dropdown-link>
                            </template>
                        </jet-dropdown>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav align-items-baseline">
                        <!-- Authentication Links -->
                        <div v-if="user">
                            <jet-dropdown id="settingsDropdown">
                                <template #trigger>
                                    <span>
                                        {{ user.name }}

                                        <svg
                                            class="ms-2"
                                            width="18"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </span>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div>
                                        <h6
                                            class="dropdown-header small text-muted"
                                        >
                                            Manage Account
                                        </h6>

                                        <jet-dropdown-link
                                            :href="route('profile.show')"
                                        >
                                            Profile
                                        </jet-dropdown-link>

                                        <hr class="dropdown-divider" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <jet-dropdown-link as="button">
                                                Log outs
                                            </jet-dropdown-link>
                                        </form>
                                    </div>
                                </template>
                            </jet-dropdown>
                        </div>
                    </ul>
                </div>

                <div
                    class="collapse navbar-collapse"
                    id="navbarSupportedContent"
                    v-else
                >
                    <ul class="navbar-nav align-items-baseline">
                        <Link :href="route('login')" class="text-muted">
                            Log in
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="ms-4 text-muted"
                        >
                            Register
                        </Link>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="container">
            <slot></slot>
        </main>
    </div>
</template>

<script>
import JetApplicationLogo from "@/Jetstream/ApplicationLogo.vue";
import JetBanner from "@/Jetstream/Banner.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import JetNavLink from "@/Jetstream/NavLink.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
    props: ["logo", "user", "title", "canRegister"],

    components: {
        Head,
        JetApplicationLogo,
        JetBanner,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        Link,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        };
    },

    methods: {
        switchToTeam(team) {
            this.$inertia.put(
                route("current-team.update"),
                {
                    team_id: team.id,
                },
                {
                    preserveState: false,
                }
            );
        },

        logout() {
            this.$inertia.post(route("logout"));
        },
    },

    computed: {
        path() {
            return window.location.pathname;
        },
    },
    mounted() {
        console.log(this.$props.user);
    },
};
</script>
<style scoped>
.blur-nav {
    backdrop-filter: blur(31px);
    background: #ffffff;
}
</style>
