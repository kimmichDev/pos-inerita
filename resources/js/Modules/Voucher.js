export default {
    state() {
        return {
            orders: [],
            // id:1 item:{} quantity cost
        }
    },
    getters: {},
    mutations: {
        addToVocher: (state, data) => state.orders.unshift(data),
    },
    actions: {
        storeToVoucher: (context, data) => context.commit('addToVocher', data),
    }
}