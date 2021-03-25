import axios from 'axios';
import {Promise} from 'es6-promise';

const state = {
};

const mutations = {
};

const actions = {
    getCfData(state, payload) {
        return new Promise((resolve, reject) => {


            axios
                .get('/api/v1/cf-data', {
                    params: {
                        page: payload.page,
                        totalItems: payload.totalItems,
                    },

                    headers: {
                        Accept: "application/json",
                        Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                    }
                })
                .then(function (response) {
                    if (response.data.status === 200) {
                        resolve(response)
                    } else {
                        state.dispatch("addNotification", {
                            type: response.data.type,
                            message: "Error! Code: " +
                                response.data.status +
                                " Message: " +
                                response.data.message,
                        });
                    }
                    resolve(response);
                })
                .catch(function (error) {
                    store.dispatch("addNotification", {
                        type: "error",
                        message: error,
                    });
                    reject(error);
                });
        });
    },

};

const getters = {};

export default {
    state,
    mutations,
    actions,
    getters,
};

