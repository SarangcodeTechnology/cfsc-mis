import axios from 'axios';
import {Promise} from 'es6-promise';
import router from '../../routes';


const state = {
    resources: {
        userPermissions: "",
        udhyam_types: "",
        registration_types: "",
    },
    editCfData: {
        fug_approval_dates: [
            {
                date: ""
            }
        ],
        fug_audit_reports: [],
        fug_maps: [],
    },
    editUdhyamFyData:{
        id:null,
        udhyam_id:null,
        aarthik_barsa_id:null,
        pratakchya_rojgari:null,
        apratakchya_rojgari:null,
        punji:null,
    },
    editFugFyData:{
        fug_id:null,
        aarthik_barsa_id:null,
        id:null,
        hh: null,
        population: null,
        women_population: null,
        men_population: null,
        no_of_person_in_committee: null,
        women_in_committee: null,
        men_in_committee: null,
        forest_based_industry_operations: null,
        forest_based_tourism_operations: null,
    },
    editUdhyamData: {
        id: null,
        kaaryalaya_id: null,
        udhyam_name: "",
        udhyam_type_id: null,
        pan_vat_no: null,
        registration_type_id: null,
        registration_no: null,
        registration_date: null,
        province_id: null,
        district_id: null,
        local_level_id: null,
        ward: null,
    },
    isCfDataView: false,
    isUdhyamDataView: false,
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
    //kaaryalaya
    kaaryalaya: [],
    editKaarayalaData: {},
    permissions: [],
    editPermissionData: {},
    aarthikBarsa: [],
    editAarthikBarsaData: {},

    kharchaCategories: [],
    editKharchaCategoriesData: {},

    kharchaTypes: [],
    editKharchaTypesData: {},

    incomeCategories: [],
    editIncomeCategoriesData: {},

    incomeTypes: [],
    editIncomeTypesData: {},

    kharcha: [],
    editKharchaData: {},

    income: [],
    editIncomeData: {},

    printData: {}
};

const mutations = {
    SET_PRINT_DATA(state, payload) {
        state.printData = payload;
    },
    // aarthikBarsa
    SET_AARTHIK_BARSA(state, payload) {
        state.aarthikBarsa = payload
    },
    SET_AARTHIK_BARSA_EDIT_DATA(state, payload) {
        state.editAarthikBarsaData = payload;
    },
    SET_KHARCHA_CATEGORIES(state, payload) {
        state.kharchaCategories = payload
    },
    SET_KHARCHA_CATEGORIES_EDIT_DATA(state, payload) {
        state.editKharchaCategoriesData = payload;
    },
    SET_KHARCHA_TYPES(state, payload) {
        state.kharchaTypes = payload
    },
    SET_KHARCHA_TYPES_EDIT_DATA(state, payload) {
        state.editKharchaTypesData = payload;
    },
    SET_INCOME_CATEGORIES(state, payload) {
        state.incomeCategories = payload
    },
    SET_INCOME_CATEGORIES_EDIT_DATA(state, payload) {
        state.editIncomeCategoriesData = payload;
    },
    SET_INCOME_TYPES(state, payload) {
        state.incomeTypes = payload
    },
    SET_INCOME_TYPES_EDIT_DATA(state, payload) {
        state.editIncomeTypesData = payload;
    },
    SET_KHARCHA(state, payload) {
        state.kharcha = payload
    },
    SET_KHARCHA_EDIT_DATA(state, payload) {
        state.editKharchaData = payload;
    },
    SET_INCOME(state, payload) {
        state.income = payload
    },
    SET_INCOME_EDIT_DATA(state, payload) {
        state.editIncomeData = payload;
    },
    SET_RESOURCES(state, payload) {
        state.resources = payload;
    },
    SET_IS_CFDATA_VIEW(state, payload) {
        state.isCfDataView = payload;
    },
    SET_IS_UDHYAMDATA_VIEW(state, payload) {
        state.isUdhyamDataView = payload;
    },
    SET_EDIT_CF_DATA(state, payload) {
        state.editCfData = payload
    },
    SET_EDIT_UDHYAM_DATA(state, payload) {
        state.editUdhyamData = payload
    },
    SET_EDIT_UDHYAM_FY_DATA(state, payload) {
        state.editUdhyamFyData = payload
    },
    SET_EDIT_FUG_FY_DATA(state, payload) {
        state.editFugFyData = payload
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

    SET_KAARYALAYA(state, payload) {
        state.kaaryalaya = payload
    },
    SET_KAARYALAYA_EDIT_DATA(state, payload) {
        state.editKaaryalayaData = payload;
    },

};

const actions = {
    setPrintData(state, payload) {
        state.commit("SET_PRINT_DATA", payload);
    },
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
                    if (response.data.status === 200) {
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
    setUdhyamFyEditData(state, payload) {
        state.commit("SET_EDIT_UDHYAM_FY_DATA", payload);
    },
    setFugFyEditData(state, payload) {
        state.commit("SET_EDIT_FUG_FY_DATA", payload);
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
    deleteAarthikBarsa(state, payload) {
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

    getKharchaCategories(state, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/kharcha-categories', {
                    headers: {
                        // Accept: "application/json",
                        Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                    }
                }
            ).then(
                function (response) {
                    if (response.data.status === 200) {
                        state.commit("SET_KHARCHA_CATEGORIES", response.data.data.kharchaCategories);
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

    setKharchaCategoriesEditData(state, payload) {
        state.commit("SET_KHARCHA_CATEGORIES_EDIT_DATA", payload);
        router.push("/kharcha-categories-edit");
    },
    saveKharchaCategories(state, payload) {
        axios.post('/api/v1/save-kharcha-categories', {data: payload}, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {

            if (response.data.status === 200) {
                router.push("/kharcha-categories");
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

    deleteKharchaCategories(state, payload) {
        return new Promise((resolve, reject) => {
            axios
                .post('/api/v1/delete-kharcha-categories', {
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
    getKharchaTypes(state, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/kharcha-types', {
                    headers: {
                        // Accept: "application/json",
                        Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                    }
                }
            ).then(
                function (response) {
                    if (response.data.status === 200) {
                        state.commit("SET_KHARCHA_TYPES", response.data.data.kharchaTypes);
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
    setKharchaTypesEditData(state, payload) {
        state.commit("SET_KHARCHA_TYPES_EDIT_DATA", payload);
        router.push("/kharcha-types-edit");
    },
    saveKharchaTypes(state, payload) {
        axios.post('/api/v1/save-kharcha-types', {data: payload}, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {

            if (response.data.status === 200) {
                router.push("/kharcha-types");
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
    deleteKharchaTypes(state, payload) {
        return new Promise((resolve, reject) => {
            axios
                .post('/api/v1/delete-kharcha-types', {
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

    getIncomeCategories(state, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/income-categories', {
                    headers: {
                        // Accept: "application/json",
                        Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                    }
                }
            ).then(
                function (response) {
                    if (response.data.status === 200) {
                        state.commit("SET_INCOME_CATEGORIES", response.data.data.incomeCategories);
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
    setIncomeCategoriesEditData(state, payload) {
        state.commit("SET_INCOME_CATEGORIES_EDIT_DATA", payload);
        router.push("/income-categories-edit");
    },
    saveIncomeCategories(state, payload) {
        axios.post('/api/v1/save-income-categories', {data: payload}, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {

            if (response.data.status === 200) {
                router.push("/income-categories");
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
    deleteIncomeCategories(state, payload) {
        return new Promise((resolve, reject) => {
            axios
                .post('/api/v1/delete-income-categories', {
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

    getIncomeTypes(state, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/income-types', {
                    headers: {
                        // Accept: "application/json",
                        Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                    }
                }
            ).then(
                function (response) {
                    if (response.data.status === 200) {
                        state.commit("SET_INCOME_TYPES", response.data.data.incomeTypes);
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
    setIncomeTypesEditData(state, payload) {
        state.commit("SET_INCOME_TYPES_EDIT_DATA", payload);
        router.push("/income-types-edit");
    },
    saveIncomeTypes(state, payload) {
        axios.post('/api/v1/save-income-types', {data: payload}, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {

            if (response.data.status === 200) {
                router.push("/income-types");
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
    deleteIncomeTypes(state, payload) {
        return new Promise((resolve, reject) => {
            axios
                .post('/api/v1/delete-income-types', {
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

    getKharcha(state, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/kharcha', {
                    headers: {
                        // Accept: "application/json",
                        Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                    }
                }
            ).then(
                function (response) {
                    if (response.data.status === 200) {
                        state.commit("SET_KHARCHA", response.data.data.kharcha);
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
    setKharchaEditData(state, payload) {
        state.commit("SET_KHARCHA_EDIT_DATA", payload);
        router.push("/kharcha-edit");
    },
    saveKharcha(state, payload) {
        axios.post('/api/v1/save-kharcha', {data: payload}, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {
            if (response.data.status === 200) {
                router.push("/kharcha");
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
    deleteKharcha(state, payload) {
        return new Promise((resolve, reject) => {
            axios
                .post('/api/v1/delete-kharcha', {
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

    getIncome(state, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/income', {
                    headers: {
                        // Accept: "application/json",
                        Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                    }
                }
            ).then(
                function (response) {
                    if (response.data.status === 200) {
                        state.commit("SET_INCOME", response.data.data.income);
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
    setIncomeEditData(state, payload) {
        state.commit("SET_INCOME_EDIT_DATA", payload);
        router.push("/income-edit");
    },
    saveIncome(state, payload) {
        axios.post('/api/v1/save-income', {data: payload}, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {

            if (response.data.status === 200) {
                router.push("/income");
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

    deleteIncome(state, payload) {
        return new Promise((resolve, reject) => {
            axios
                .post('/api/v1/delete-income', {
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
    deleteData(state, payload) {
        return new Promise((resolve, reject) => {
            axios
                .post('/api/v1/delete', payload, {
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

    setCfEditData(state, payload) {
        state.commit("SET_EDIT_CF_DATA", payload);
        router.push("/cf-data-edit");
    },
    setUdhyamEditData(state, payload) {
        state.commit("SET_EDIT_UDHYAM_DATA", payload);
        router.push("/udhyam-data-edit");
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
                'Content-Types': 'multipart/form-data',
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
    saveUdhyamData(state, payload) {
        axios.post('/api/v1/save-udhyam-data', payload, {
            headers: {
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN,
            }
        }).then(function (response) {
            if (response.data.status === 200) {
                router.push("/udhyam-data");
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

    saveUdhyamFyData(state, payload) {
        axios.post('/api/v1/save-udhyam-fy-data', payload, {
            headers: {
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN,
            }
        }).then(function (response) {
            if (response.data.status === 200) {
                router.push("/udhyam-data");
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

    saveFugFyData(state, payload) {
        axios.post('/api/v1/save-fug-fy-data', payload, {
            headers: {
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

    deleteUdhyamData(state, payload) {
        return new Promise((resolve, reject) => {
            axios.post('/api/v1/delete-udhyam-data', payload, {
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

    getUdhyamData(state, payload) {
        return new Promise((resolve, reject) => {
            axios
                .get('/api/v1/udhyam-data', {
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
                    if (response.data.status === 200) {
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
                if (response.data.status === 200) {
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
                    if (response.data.status === 200) {
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
                    if (response.data.status === 200) {
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
    },
    // kaaryalaya
    getKaaryalaya(state, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/kaaryalaya', {
                    headers: {
                        // Accept: "application/json",
                        Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                    }
                }
            ).then(
                function (response) {
                    if (response.data.status == 200) {
                        state.commit("SET_KAARYALAYA", response.data.data.kaaryalaya);
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
    setKaaryalayaEditData(state, payload) {
        state.commit("SET_KAARYALAYA_EDIT_DATA", payload);
        router.push("/kaaryalaya-edit");
    },
    saveKaaryalayaData(state, payload) {
        axios.post('/api/v1/save-kaaryalaya-data', {data: payload}, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
            }
        }).then(function (response) {

            if (response.data.status === 200) {
                +router.push("/kaaryalaya");
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

    makePostRequest(state, payload) {
        return new Promise((resolve, reject) => {
            axios.post('/api/v1/' + payload.route, payload.data, {
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                }
            }).then(function (response) {
                if (response.data.status === 200) {
                    resolve(response.data.data);
                    if (response.data.message) {
                        state.dispatch("addNotification", {
                            type: response.data.type,
                            message: response.data.message,
                        });
                    }
                } else {
                    state.dispatch("addNotification", {
                        type: response.data.type,
                        message: response.data.message,
                    });
                }
            }).catch(function (error) {
                reject(error);
                state.dispatch("addNotification", {
                    type: "error",
                    message: error.message,
                });
            });
        });
    },

    makeGetRequest(state, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/' + payload.route, {
                params: payload.data,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + state.getters.GET_ACCESS_TOKEN
                }
            }).then(function (response) {
                if (response.data.status === 200) {
                    resolve(response);
                } else {
                    console.log(response);
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
        });
    }
};

const getters = {
    GET_ROLE_DATA(state, payload) {
        var data = state.editRoleData;
        return data;

    },
    CHECK_PERMISSION: (state) => (can) => {
        return state.resources.userPermissions.includes(can);
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

