import uniqid from "uniqid";
export default {
    state() {
        return {
            orders: [],
            // id:1 item:{} quantity cost
            voucher_number: uniqid("voucher-"),
            customerName: "",
            total: "",
        }
    },
    getters: {
        getDate: () => {
            let date = new Date();
            let monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            return `${date.getDay()}-${monthNames[date.getMonth()]}-${date.getFullYear()}`;
        },
    },
    mutations: {
        addToVocher: (state, data) => {
            state.orders.unshift(data)
            localStorage.setItem("localOrders", JSON.stringify(state.orders))
        },
        editVoucherNumber: (state, data) => state.voucher_number = data,
        editCustomerName: (state, data) => state.customerName = data,
        editTotal: (state, data) => state.total = data,
        editOrders: (state, data) => state.orders = data,
    },
    actions: {
        storeToVoucher: (context, data) => context.commit('addToVocher', data),
        updateVoucherNumber: (context, data) => context.commit('editVoucherNumber', data),
        updateCustomerName: (context, data) => context.commit('editCustomerName', data),
        updateTotal: (context, data) => context.commit('editTotal', data),
        updateOrders: (context, data) => context.commit('editOrders', data),
    }
}