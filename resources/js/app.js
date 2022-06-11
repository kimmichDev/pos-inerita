require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { createInertiaApp, Link, Head } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import AppLayout from "../js/Layouts/AppLayout.vue";
import { createStore } from "vuex";

import Voucher from './Modules/Voucher';



createInertiaApp({
    title: (title) => `${title} - POS APP`,
    resolve: (name) => {
        let page = require(`./Pages/${name}.vue`).default;
        page.layout ??= AppLayout;
        return page;
    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .component("Link", Link)
            .component("Head", Head)
            .use(plugin)
            .use(store)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });


// vueX
const store = createStore({
    state() {
        return {
            count: "hello",
        }
    },
    getters: {},
    mutations: {},
    actions: {},
    modules: { Voucher }
})
