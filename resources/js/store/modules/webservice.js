import axios from 'axios';
import { Promise } from 'es6-promise';
import router from '../../routes';


const state = {
    resources: {

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
    },
    users: [],
    editUserData: {
        name:"",
        email:"",
        roles:[]
    },
    isUserEdit: false,
    roles: [],
    editRoleData: {
        name:"",
        email:"",
        roles:[]
    },
    permissions:[],
    editPermissionData:{

    },
};

const mutations = {
    SET_RESOURCES(state, payload) {
        state.resources = payload;
    },
    SET_EDIT_CF_DATA(state, payload) {
        state.editCfData = payload
    },
    SET_USERS(state,payload){
        state.users=payload
    },
    SET_ROLES(state,payload){
        state.roles=payload
    },
    SET_USER_EDIT_DATA(state, payload){
        state.editUserData = payload;
    },
    SET_IS_USER_EDIT(state, payload){
        state.isUserEdit = payload;
    },
    SET_ROLE_EDIT_DATA(state, payload){
        state.editRoleData = payload;
    },

    SET_PERMISSIONS(state,payload){
        state.permissions=payload
    },
    SET_PERMISSION_EDIT_DATA(state, payload){
        state.editPermissionData = payload;
    },
    SET_SELECTED_ADDITIONAL_PERMISSIONS(state, payload){
        state.editUserData.permissions = payload;
    }
};

const actions = {
    setCfEditData(state, payload) {
        state.commit("SET_EDIT_CF_DATA", payload);
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
    saveCfData(state, payload) {
        axios.post('/api/v1/save-cf-data', { data: payload }, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {
            if (response.data.status === 200) {
                router.push("/cf-data");
                state.dispatch("addNotification", {
                    type: response.data.type,
                    message: response.data.message,
                });
            } else {
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
    deleteCfData(state, payload) {
        return new Promise((resolve, reject) => {
            axios.post('/api/v1/delete-cf-data', payload, {
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                }
            }).then(function (response) {
                if (response.data.status === 200) {
                    state.dispatch("addNotification", {
                        type: response.data.type,
                        message: response.data.message,
                    });
                } else {
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

    // users
    getUsers(state, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/users', {
                headers: {
                    // Accept: "application/json",
                    Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                }
            }
            ).then(
                function (response) {
                    if (response.data.status == 200) {
                        state.commit("SET_USERS", response.data.data.user);
                        resolve(response);

                    } else {
                        state.dispatch("addNotification", {
                            type: response.data.type,
                            message: response.data.message
                        })
                    }
                }
            ).catch(
                function (error) {
                    state.dispatch("addNotification", {
                        type: "error",
                        message: error,
                    });
                    reject(error);
                }
            )
        });
    },
    setUserEditData(state, payload) {
        state.commit("SET_USER_EDIT_DATA", payload);
        router.push("/user-edit");
    },
    saveUserData(state, payload) {
        axios.post('/api/v1/save-user-data', { data: payload }, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {

            if (response.data.status === 200) {
                +                router.push("/users");
                state.dispatch("addNotification", {
                    type: response.data.type,
                    message: response.data.message,
                });
            } else {
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
    getPermissionsDataForUser(state, payload) {
        return new Promise((resolve, reject) => {

            console.log(payload);
            axios.post('/api/v1/permissions-data-for-user', payload, {
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                }
            }).then(function (response) {
                if (response.data.status == 200) {
                    resolve(response.data);
                } else {
                    state.dispatch("addNotification", {
                        type: response.data.type,
                        message: response.data.message
                    })
                }
            }).catch(function (error) {
                state.dispatch("addNotification", {
                    type: "error",
                    message: error,
                });
                reject(error);
            });
        });
    },
    // roles
    getRoles(state, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/roles', {
                headers: {
                    // Accept: "application/json",
                    Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                }
            }
            ).then(
                function (response) {
                    if (response.data.status == 200) {
                        state.commit("SET_ROLES", response.data.data.roles);
                        resolve(response);

                    } else {
                        state.dispatch("addNotification", {
                            type: response.data.type,
                            message: response.data.message
                        })
                    }
                }
            ).catch(
                function (error) {
                    state.dispatch("addNotification", {
                        type: "error",
                        message: error,
                    });
                    reject(error);
                }
            )
        });
    },
    setRoleEditData(state, payload) {
        state.commit("SET_ROLE_EDIT_DATA", payload);
        router.push("/role-edit");
    },
    saveRoleData(state, payload) {
        axios.post('/api/v1/save-role-data', { data: payload }, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {

            if (response.data.status === 200) {
                +                router.push("/roles");
                state.dispatch("addNotification", {
                    type: response.data.type,
                    message: response.data.message,
                });
            } else {
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
    // permissions
    getPermissions(state, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/permissions', {
                headers: {
                    // Accept: "application/json",
                    Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                }
            }
            ).then(
                function (response) {
                    if (response.data.status == 200) {
                        state.commit("SET_PERMISSIONS", response.data.data.permissions);
                        resolve(response);

                    } else {
                        state.dispatch("addNotification", {
                            type: response.data.type,
                            message: response.data.message
                        })
                    }
                }
            ).catch(
                function (error) {
                    state.dispatch("addNotification", {
                        type: "error",
                        message: error,
                    });
                    reject(error);
                }
            )
        });
    },
    setPermissionEditData(state, payload) {
        state.commit("SET_PERMISSION_EDIT_DATA", payload);
        router.push("/permission-edit");
    },
    savePermissionData(state, payload) {
        axios.post('/api/v1/save-permission-data', { data: payload }, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {

            if (response.data.status === 200) {
                router.push("/permissions");
                state.dispatch("addNotification", {
                    type: response.data.type,
                    message: response.data.message,
                });
            } else {
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
    }


};

const getters = {
    GET_ROLE_DATA(state, payload) {
        var data = state.editRoleData;
        return data;

    }
};

export default {
    state,
    mutations,
    actions,
    getters,
};

