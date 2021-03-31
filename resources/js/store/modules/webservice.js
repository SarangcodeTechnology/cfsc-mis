import axios from 'axios';
import {Promise} from 'es6-promise';
import router from '../../routes';


const state = {
    resources: {
        provinces:null,
        subdivisions:null
    },
    editCfData: {
        fug_name: "",
        fug_code: "",
        cfid: "",
        province_id: null,
        district_id: null,
        local_level_id: null,
        physiography_id: null,
        x: "",
        y: "",
        subdivision_id: null,
        approval_date_bs: "",
        approval_date_ad: "",
        approval_fy: "",
        area_ha: "",
        hh: "",
        vegetation_type_id: null,
        forest_type_id: null,
        forest_condition_id: null,
        no_of_person_in_committee: "",
        women_in_committee: "",
        remarks: "",
        approval_revision_date_bs: "",
        approval_revision_date_ad: "",
    }
};

const mutations = {
    SET_RESOURCES(state, payload) {
        state.resources = payload;
    },
    SET_EDIT_CF_DATA(state,payload){
        state.editCfData=payload
    }
};

const actions = {
    setCfEditData(state,payload){
state.commit("SET_EDIT_CF_DATA",payload);
        router.push("/cf-data-edit");

    },
    loadResources(state, payload) {
        return new Promise((resolve, reject) => {
            axios
                .get('/api/v1/load-resources', {
                    headers: {
                        Accept: "application/json",
                        Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                    }
                })
                .then(function (response) {
                    if (response.data.status === 200) {
                        state.commit("SET_RESOURCES", response.data.data);
                        state.dispatch("addNotification", {
                            type: response.data.type,
                            message: response.data.message,
                        });
                        resolve(response)
                    } else {
                        state.dispatch("addNotification", {
                            type: response.data.type,
                            message: response.data.message,
                        });
                    }
                    resolve(response);
                })
                .catch(function (error) {
                    state.dispatch("addNotification", {
                        type: "error",
                        message: error,
                    });
                    reject(error);
                });
        });
    },
    saveCfData(state, payload){
        axios.post('/api/v1/save-cf-data',{data:payload},{
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function(response){
            if (response.data.status === 200) {
                router.push("/cf-data");
                state.dispatch("addNotification", {
                    type: response.data.type,
                    message: response.data.message,
                });
            }else {
                        state.dispatch("addNotification", {
                            type: response.data.type,
                            message: response.data.message,
                        });
                    }

        }).catch(function (error) {
            state.dispatch("addNotification", {
                type: "error",
                message: error,
            });
        });
    },
    deleteCfData(state, payload){
        return new Promise((resolve, reject) => {
            axios.post('/api/v1/delete-cf-data',payload,{
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                }
            }).then(function(response){
                if (response.data.status === 200) {
                    state.dispatch("addNotification", {
                        type: response.data.type,
                        message: response.data.message,
                    });
                }else {
                    state.dispatch("addNotification", {
                        type: response.data.type,
                        message: response.data.message,
                    });
                }
                resolve(response);
            }).catch(function (error) {
                state.dispatch("addNotification", {
                    type: "error",
                    message: error,
                });
                reject(error);

            })
        });

    },

    getCfData(state, payload) {
        return new Promise((resolve, reject) => {


            axios
                .get('/api/v1/cf-data', {
                    params: {
                        page: payload.page,
                        totalItems: payload.totalItems,
                        search: payload.search
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
                            message: response.data.message,
                        });
                    }
                    resolve(response);
                })
                .catch(function (error) {
                    state.dispatch("addNotification", {
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

