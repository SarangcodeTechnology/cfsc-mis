import axios from 'axios';
import {Promise} from 'es6-promise';
import router from '../../routes';


const state = {
    resources: {},
    editCfData: {
        fug_approval_dates: [
            {
                date: ""
            }
        ],
        fug_audit_reports: [],
        fug_maps: [],
    },
    isCfDataView: false,
    users: [],
    editUserData: {
        name: "",
        email: "",
        roles: []
    },
    isUserEdit: false,
    roles: [],
    editRoleData: {
        name: "",
        email: "",
        roles: []
    },
    permissions: [],
    editPermissionData: {},
    aarthikBarsa: [],
    editAarthikBarsaData: {},

};

const mutations = {

    // aarthikBarsa
    SET_AARTHIK_BARSA(state, payload) {
        state.aarthikBarsa = payload
    },
    SET_AARTHIK_BARSA_EDIT_DATA(state, payload) {
        state.editAarthikBarsaData = payload;
    },
    SET_RESOURCES(state, payload) {
        state.resources = payload;
    },
    SET_IS_CFDATA_VIEW(state, payload) {
        state.isCfDataView = payload;
    },
    SET_EDIT_CF_DATA(state, payload) {
        state.editCfData = payload
    },
    UPDATE_APPROVAL_DATE(state, payload) {
        state.editCfData.fug_approval_dates.push(payload.fugApprovalDate)
    },

    SET_USERS(state, payload) {
        state.users = payload
    },
    SET_ROLES(state, payload) {
        state.roles = payload
    },
    SET_USER_EDIT_DATA(state, payload) {
        state.editUserData = payload;
    },
    SET_IS_USER_EDIT(state, payload) {
        state.isUserEdit = payload;
    },
    SET_ROLE_EDIT_DATA(state, payload) {
        state.editRoleData = payload;
    },

    SET_PERMISSIONS(state, payload) {
        state.permissions = payload
    },
    SET_PERMISSION_EDIT_DATA(state, payload) {
        state.editPermissionData = payload;
    },
    SET_SELECTED_ADDITIONAL_PERMISSIONS(state, payload) {
        state.editUserData.permissions = payload;
    },

};

const actions = {
    //aarthik barsha
    getAarthikBarsa(state, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/aarthik-barsa', {
                    headers: {
                        // Accept: "application/json",
                        Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                    }
                }
            ).then(
                function (response) {
                    if (response.data.status == 200) {
                        state.commit("SET_AARTHIK_BARSA", response.data.data.aarthikBarsa);
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
    setAarthikBarsaEditData(state, payload) {
        state.commit("SET_AARTHIK_BARSA_EDIT_DATA", payload);
        router.push("/aarthik-barsa-edit");
    },
    saveAarthikBarsa(state, payload) {
        axios.post('/api/v1/save-aarthik-barsa', {data: payload}, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {

            if (response.data.status === 200) {
                router.push("/aarthik-barsa");
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
        axios.post('/api/v1/save-cf-data', payload, {
            headers: {
                'Content-Type': 'multipart/form-data',
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN,
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
    deleteAarthikBarsaItem(state, payload) {
        return new Promise((resolve, reject) => {
            axios
                .post('/api/v1/delete-aarthik-barsa', {
                    data: payload
                }, {
                    headers: {
                        Accept: "application/json",
                        Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                    }
                })
                .then(function (response) {
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
                        search: payload.search,
                        filterData: payload.filterData
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
        axios.post('/api/v1/save-user-data', {data: payload}, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {

            if (response.data.status === 200) {
                +router.push("/users");
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
        axios.post('/api/v1/save-role-data', {data: payload}, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {

            if (response.data.status === 200) {
                +router.push("/roles");
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
        axios.post('/api/v1/save-permission-data', {data: payload}, {
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

    },
    getCanBrowseUsers(state, payload) {
        if (state.resources.userPermissions.includes("can_browse_users")) {
            return true;
        }
        return false;
    }
};

export default {
    state,
    mutations,
    actions,
    getters,
};

