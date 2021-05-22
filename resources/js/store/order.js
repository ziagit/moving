export default {
    namespaced: true,
    state: {
        src: {

        },
        des: {

        },
        pickDate: null,
        myItem: {

        },
        carrier: {

        },
        shipper: {

        },
        billing: {

        },
    },
    getters: {
        getPickup(state) {
            return state.src;
        },
        getPickupServices(state){
            return state.src;
        }
    },

    mutations: {
        SET_PICKUP(state, data) {
            state.src = data
        },
        SET_PICKUP_SERVICES(state, data){
            state.src = data
        }
    },
    actions: {
        setPickup({ dispatch }, data) {
            return dispatch('attemptPickup', data)
        },
        async attemptPickup({ commit, state }, data) {
            if (data) {
                commit('SET_PICKUP', data)
            }
            if (!state.src) {
                return
            }
        },
        //............
        setPickupServices({ dispatch }, data) {
            return dispatch('attemptPickupServices', data)
        },
        async attemptPickupServices({ commit, state }, data) {
            if (data) {
                commit('SET_PICKUP_SERVICES', data)
            }
            if (!state.src) {
                return
            }
        },
    }
};