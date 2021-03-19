import Vue from 'vue'

import Vuex from 'vuex'
import createPersistedState from "vuex-persistedstate";
import auth from "./modules/auth";

Vue.use(Vuex)

const opts = {
    modules: {
        auth,
    },

    state: {
        notifications: []
    },

    mutations: {
        ADD_NOTIFICATION(state, notification) {
            state.notifications.push({
                type: notification.type,
                message: notification.message,
                id: (Math.random().toString(36) + Date.now().toString(36)).substr(2),
            })
        },
        REMOVE_NOTIFICATION(state, notificationToRemove) {
            state.notifications = state.notifications.filter(notification => {
                return notification.id != notificationToRemove.id;
            })
        }
    },

    actions: {
        addNotification(state, notification) {
            state.commit('ADD_NOTIFICATION', notification);
        },
        removeNotification(state, notification) {
            state.commit('REMOVE_NOTIFICATION', notification);
        }
    },

    getters: {},
    plugins: [createPersistedState({
            storage: window.sessionStorage,
        }
    )]
}

export default new Vuex.Store(opts)
