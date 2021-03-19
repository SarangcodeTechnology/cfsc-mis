import Vue from 'vue'

import Vuex from 'vuex'
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex)

const opts = {
    modules: {},

    state: {},

    mutations: {},

    actions: {},

    getters: {},
    plugins: [createPersistedState({
            storage: window.localStorage,
        }
    )]
}

export default new Vuex.Store(opts)
