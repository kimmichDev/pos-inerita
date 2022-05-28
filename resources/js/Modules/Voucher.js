export default {
    state() {
        return {
            voucher: [],
        }
    },
    getters: {},
    mutations: {
        addToVocher: (state, data) => state.voucher.push(data),
    },
    actions: {
        storeToVoucher: (context, data) => context.commit('addToVocher', data),
    }
}