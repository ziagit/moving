export default {
    namespaced: true,
    state: {
        temp: null,
        notificationId: null,
        cardStatus: null,
    },
    getters: {
        temp(state) {
            return state.temp;
        },
        card(state) {
            return state.cardStatus;
        }
    },

    mutations: {
        SET_TEMP(state, data) {
            state.temp = data
        },
        SET_CARD(state, status) {
            state.cardStatus = status
        },
        SET_NOTIFICATION(state, id) {
            state.notificationId = id
        },

    },
    actions: {
        tempData({ dispatch }, data) {
            return dispatch('attempt', data)
        },
        async attempt({ commit, state }, data) {
            if (data) {
                commit('SET_TEMP', data)
            }
            if (!state.temp) {
                return
            }
        },
        async chargeResponse({ dispatch }, message) {
            return dispatch('attemptCard', message)
        },
        async attemptCard({ commit, state }, message) {
            if (message) {
                commit('SET_CARD', message)
            }
            if (!state.cardStatus) {
                return
            }
        },
        setNotification({dispatch}, id){
            return dispatch('attempNotification', id)
        },
        async attempNotification({commit, state}, id){
            if(id){
                commit('SET_NOTIFICATION', id)
            }
            if(!state.notificationId){
                return
            }
        }
    }
};