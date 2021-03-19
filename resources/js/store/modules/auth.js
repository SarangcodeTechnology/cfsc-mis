import axios from 'axios';
import {Promise} from 'es6-promise';

const state = {
    user: "",
    accessToken:"",
};

const mutations = {
    SET_USER(state, payload) {
        state.user = payload;
    },
    SET_ACCESS_TOKEN(state, payload) {
        state.accessToken = payload;
    }
};

const actions = {
    login(state, payload) {
        return new Promise((resolve, reject) => {
            axios
                .post("/api/v1/login", {
                    email: payload.email,
                    password: payload.password,
                })
                .then(function (response) {
                    if (response.data.status === 200) {
                        state.commit("SET_USER", response.data.data.user);
                    } else {
                        window.sessionStorage.clear();
                    }
                    resolve(response);
                })
                .catch(function (error) {
                    reject(error);
                });
        });
    }, register(state, payload) {
        return new Promise((resolve, reject) => {
            axios
                .post("/api/v1/register", {
                    name: payload.name,
                    email: payload.email,
                    password: payload.password,
                    password_confirmation: payload.confirmPassword,
                })
                .then(function (response) {
                    if (response.data.status === 200) {
                        state.commit("SET_USER", response.data.data.user);
                    } else {
                        window.sessionStorage.clear();
                    }
                    resolve(response);
                })
                .catch(function (error) {
                    reject(error);
                });
        });
    },
    logout(state) {
        return new Promise((resolve, reject) => {
            axios.post('/api/v1/user/logout', {}, {
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                }
            }).then(function (response) {
                if (response.data.status === 200) {
                    state.commit("SET_USER", "");
                    window.sessionStorage.clear();
                }
                resolve(response);
            }).catch(function (error) {
                reject(error);
            });
        });
    },

};

const getters = {
    GET_USER(state) {
        return state.user;
    },
    GET_ACCESS_TOKEN(state) {
        return state.accessToken;
    }
};

export default {
    state,
    mutations,
    actions,
    getters,
};

