import Vue from 'vue'
import VueRouter from 'vue-router'

import store from "./store";


Vue.use(VueRouter)

const App = () => import("./components/App");
const Login = () => import("./components/auth/Login");
const Register = () => import("./components/auth/Register");
const Dashboard = () => import("./components/pages/Dashboard");
const Home = () => import("./components/pages/Home");
const ChangePassword = () => import("./components/auth/ChangePassword");

// trial
const CFData = () => import("./components/pages/cfdata/browse");
const CFDataEdit = () => import("./components/pages/cfdata/edit");

const User = () => import("./components/pages/users/browse");
const UserEdit = () => import("./components/pages/users/edit");

const Role = () => import("./components/pages/roles/browse");
const RoleEdit = () => import("./components/pages/roles/edit");


const Permission = () => import("./components/pages/permissions/browse");
const PermissionEdit = () => import("./components/pages/permissions/edit");

const KharchaTypes = () => import("./components/pages/kharcha-types/Browse");
const KharchaTypesEdit = () => import("./components/pages/kharcha-types/Edit");

const KharchaCategories = () => import("./components/pages/kharcha-categories/Browse");
const KharchaCategoriesEdit = () => import("./components/pages/kharcha-categories/Edit");

const IncomeCategories = () => import("./components/pages/income-categories/Browse");
const IncomeCategoriesEdit = () => import("./components/pages/income-categories/Edit");

const IncomeTypes = () => import("./components/pages/income-types/Browse");
const IncomeTypesEdit = () => import("./components/pages/income-types/Edit");

const AarthikBarsa = () => import("./components/pages/aarthik-barsha/browse");
const AarthikBarsaEdit = () => import("./components/pages/aarthik-barsha/edit");

const Kharcha = () => import("./components/pages/kharcha/Browse");
const KharchaEdit = () => import("./components/pages/kharcha/Edit");

const Income = () => import("./components/pages/income/Browse");
const IncomeEdit = () => import("./components/pages/income/Edit");

const Kaaryalaya = () => import("./components/pages/kaaryalaya/browse");
const KaaryalayaEdit = () => import("./components/pages/kaaryalaya/edit");
const PrintIncome = () => import("./components/pages/print/Income");

const Division = () => import("./components/pages/divisions/Browse");
const Subdivision = () => import("./components/pages/sub-divisions/Browse");

const UdhyamData = () => import("./components/pages/udhyamdata/browse");
const UdhyamDataEdit = () => import("./components/pages/udhyamdata/edit");
const UdhyamFyDataEdit = () => import("./components/pages/udhyamdata/udhyamFyDataEdit");
const FugFyDataEdit = () => import("./components/pages/cfdata/cfFyDataEdit");


const opts = {
    mode: "history",
    routes: [
        {
            path: "/",
            component: App,
            beforeEnter(to, from, next) {
                if (store.getters.GET_USER) {
                    next();
                } else {
                    next("/login");
                }
            },
            meta: {
                breadcrumb: {
                    name: "/",
                    link: "/"
                }
            },
            children: [
                {
                    path: "",
                    component: Dashboard,
                    name: 'app',
                    beforeEnter(to, from, next) {
                        if (store.getters.GET_USER) {
                            next("/dashboard");
                        } else {
                            next("/login");
                        }
                    },
                    meta: {
                        breadcrumb: {
                            text: "/",
                            link: "/"
                        }
                    },
                },
                {
                    path: "/dashboard",
                    component: Dashboard,
                    name: 'dashboard',
                    meta: {
                        breadcrumb: {
                            text: "Dashboard",
                            link: "/dashboard"
                        }
                    },
                },
                {
                    path: "/home",
                    component: Home,
                    name: 'home',
                    meta: {
                        breadcrumb: {
                            text: "Home",
                            link: "/home"
                        }
                    },
                },
                {
                    path: "/change-password",
                    component: ChangePassword,
                    name: 'change-password',
                    meta: {
                        breadcrumb: {
                            text: "Change Password",
                            link: "/change-password"
                        }
                    },
                },
                {
                    path: "/cf-data",
                    component: CFData,
                    name: 'cf-data',
                    meta: {
                        breadcrumb: {
                            text: "CF Data",
                            link: "/cf-data"
                        }
                    },
                },
                {
                    path: "/users",
                    component: User,
                    name: 'users',
                    meta: {
                        breadcrumb: {
                            text: "User",
                            link: "/users"
                        }
                    },
                },
                {
                    path: "/roles",
                    component: Role,
                    name: 'roles',
                    meta: {
                        breadcrumb: {
                            text: "Roles",
                            link: "/roles"
                        }
                    },
                },
                {
                    path: "/role-edit",
                    component: RoleEdit,
                    name: 'role-edit',
                    meta: {
                        breadcrumb: {
                            text: "Role Edit",
                            link: "/role-edit"
                        }
                    },
                },
                //kaaryalaya
                {
                    path: "/kaaryalaya",
                    component: Kaaryalaya,
                    name: 'kaaryalaya',
                    meta: {
                        breadcrumb: {
                            text: "?????????????????????",
                            link: "/kaaryalaya"
                        }
                    },
                },
                {
                    path: "/kaaryalaya-edit",
                    component: KaaryalayaEdit,
                    name: 'kaaryalaya-edit',
                    meta: {
                        breadcrumb: {
                            text: "?????????????????????",
                            link: "/kaaryalaya-edit"
                        }
                    },
                },
                {
                    path: "/cf-data-edit",
                    component: CFDataEdit,
                    name: 'cf-data-edit',
                    meta: {
                        breadcrumb: {
                            text: "CF Data Details",
                            link: "/cf-data-edit"
                        }
                    },
                    beforeEnter(to, from, next) {
                        store.commit("SET_PREVIOUS_ROUTE", from.name)
                        if (from.name !== 'cf-data') {
                            store.commit("SET_EDIT_CF_DATA", {
                                ward: "",
                                fug_name: "",
                                fug_code: "",
                                fug_pan_no: "",
                                hh: "",
                                population: "",
                                women_population: "",
                                men_population: "",
                                area_ha: "",
                                no_of_person_in_committee: "",
                                women_in_committee: "",
                                men_in_committee: "",
                                scientific_forest_approval_date: "",
                                scientific_forest_area_ha: "",
                                forest_based_industry_operations: "",
                                forest_based_tourism_operations: "",
                                remarks: "",
                                fug_approval_dates: [
                                    {
                                        date: "",
                                    },
                                ],
                                fug_audit_reports: [],
                                fug_maps: [],
                            });

                        }
                        next();

                    },
                },
                {
                    path: "/user-edit",
                    component: UserEdit,
                    name: 'user-edit',
                    meta: {
                        breadcrumb: {
                            text: "User Edit/Add",
                            link: "/user-edit"
                        }
                    },
                },
                // permissions
                {
                    path: "/permissions",
                    component: Permission,
                    name: 'permissions',
                    meta: {
                        breadcrumb: {
                            text: "Permissions",
                            link: "/permissions"
                        }
                    },
                },
                {
                    path: "/permission-edit",
                    component: PermissionEdit,
                    name: 'permission-edit',
                    meta: {
                        breadcrumb: {
                            text: "Permission Edit",
                            link: "/permission-edit"
                        }
                    },
                },
                {
                    path: "/aarthik-barsa",
                    component: AarthikBarsa,
                    name: 'aarthik-barsa',
                    meta: {
                        breadcrumb: {
                            text: "Fiscal Year",
                            link: "/aarthik-barsa"
                        }
                    },
                },
                {
                    path: "/aarthik-barsa-edit",
                    component: AarthikBarsaEdit,
                    name: 'aarthik-barsa-edit',
                    meta: {
                        breadcrumb: {
                            text: "Fiscal Year Edit",
                            link: "/aarthik-barsa-edit"
                        }
                    },
                },
                {
                    path: "/income-types",
                    component: IncomeTypes,
                    name: 'income-types',
                    meta: {
                        breadcrumb: {
                            text: "Income Types",
                            link: "/income-types"
                        }
                    },
                },
                {
                    path: "/income-types-edit",
                    component: IncomeTypesEdit,
                    name: 'income-types-edit',
                    beforeEnter(to, from, next) {
                        store.commit("SET_PREVIOUS_ROUTE", from.name)
                        if (from.name !== 'income-types') {
                            store.commit("SET_INCOME_TYPES_EDIT_DATA", {
                                id: null,
                                created_at: "",
                                updated_at: "",
                                title: "",
                                order: null,
                                income_category_id: null,
                            });
                        }
                        next();
                    },
                    meta: {
                        breadcrumb: {
                            text: "Income Types Edit",
                            link: "/income-types-edit"
                        }
                    },
                },
                {
                    path: "/divisions",
                    component: Division,
                    name: 'divisions',
                    meta: {
                        breadcrumb: {
                            text: "Division",
                            link: "/divisions"
                        }
                    },
                },
                {
                    path: "/subdivisions",
                    component: Subdivision,
                    name: 'subdivisions',
                    meta: {
                        breadcrumb: {
                            text: "Subdivisions",
                            link: "/subdivisions"
                        }
                    },
                },
                {
                    path: "/income-categories",
                    component: IncomeCategories,
                    name: 'income-categories',
                    meta: {
                        breadcrumb: {
                            text: "Income Types",
                            link: "/income-categories"
                        }
                    },
                },
                {
                    path: "/income-categories-edit",
                    component: IncomeCategoriesEdit,
                    name: 'income-categories-edit',
                    beforeEnter(to, from, next) {
                        store.commit("SET_PREVIOUS_ROUTE", from.name)
                        if (from.name !== 'income-categories') {
                            store.commit("SET_INCOME_CATEGORIES_EDIT_DATA", {
                                id: null,
                                created_at: "",
                                updated_at: "",
                                title: "",
                                order: null,
                            });
                        }
                        next();
                    },
                    meta: {
                        breadcrumb: {
                            text: "Income Types Edit",
                            link: "/income-categories-edit"
                        }
                    },
                },
                {
                    path: "/kharcha-types",
                    component: KharchaTypes,
                    name: 'kharcha-types',
                    meta: {
                        breadcrumb: {
                            text: "Expenditure Types",
                            link: "/kharcha-types"
                        }
                    },
                },
                {
                    path: "/kharcha-types-edit",
                    component: KharchaTypesEdit,
                    beforeEnter(to, from, next) {
                        store.commit("SET_PREVIOUS_ROUTE", from.name)
                        if (from.name !== 'kharcha-types') {
                            store.commit("SET_KHARCHA_TYPES_EDIT_DATA", {
                                id: null,
                                created_at: "",
                                updated_at: "",
                                title: "",
                                order: null,
                                income_category_id: null,
                            });
                        }
                        next();
                    },
                    name: 'kharcha-types-edit',
                    meta: {
                        breadcrumb: {
                            text: "Expenditure Types Edit",
                            link: "/kharcha-types-edit"
                        }
                    },
                },
                {
                    path: "/kharcha-categories",
                    component: KharchaCategories,
                    name: 'kharcha-categories',
                    meta: {
                        breadcrumb: {
                            text: "Expenditure Categories",
                            link: "/kharcha-categories"
                        }
                    },
                },
                {
                    path: "/kharcha-categories-edit",
                    component: KharchaCategoriesEdit,
                    name: 'kharcha-categories-edit',
                    beforeEnter(to, from, next) {
                        store.commit("SET_PREVIOUS_ROUTE", from.name)
                        if (from.name !== 'kharcha-categories') {
                            store.commit("SET_KHARCHA_CATEGORIES_EDIT_DATA", {
                                id: null,
                                created_at: "",
                                updated_at: "",
                                title: "",
                                order: null,
                            });
                        }
                        next();
                    },
                    meta: {
                        breadcrumb: {
                            text: "Expenditure Categories Edit",
                            link: "/kharcha-categories-edit"
                        }
                    },
                },
                {
                    path: "/kharcha",
                    component: Kharcha,
                    name: 'kharcha',

                    meta: {
                        breadcrumb: {
                            text: "Expenditure Data",
                            link: "/kharcha"
                        }
                    },
                },
                {
                    path: "/kharcha-edit",
                    component: KharchaEdit,
                    name: 'kharcha-edit',
                    beforeEnter(to, from, next) {
                        store.commit("SET_PREVIOUS_ROUTE", from.name)
                        if (from.name !== 'kharcha') {
                            store.commit("SET_KHARCHA_EDIT_DATA", {
                                fug_id: null,
                                aarthik_barsa_id: null,
                                kharcha_type_id: null,
                                kharcha: null,
                                kaifiyat: "",

                            });
                        }
                        next();
                    },
                    meta: {
                        breadcrumb: {
                            text: "Expenditure Data Edit",
                            link: "/kharcha-edit"
                        }
                    },
                },
                {
                    path: "/income",
                    component: Income,
                    name: 'income',
                    meta: {
                        breadcrumb: {
                            text: "Income Data",
                            link: "/income"
                        }
                    },
                },
                {
                    path: "/income-edit",
                    component: IncomeEdit,
                    beforeEnter(to, from, next) {
                        store.commit("SET_PREVIOUS_ROUTE", from.name)
                        if (from.name !== 'income') {
                            store.commit("SET_INCOME_EDIT_DATA", {
                                fug_id: null,
                                aarthik_barsa_id: null,
                                income_type_id: null,
                                income: null,
                                kaifiyat: "",
                            });
                        }
                        next();
                    },
                    name: 'income-edit',
                    meta: {
                        breadcrumb: {
                            text: "Income Data Edit",
                            link: "/income-edit"
                        }
                    },
                },
                {
                    path: "/udhyam-data",
                    component: UdhyamData,
                    name: 'udhyam-data',
                    meta: {
                        breadcrumb: {
                            text: "Udhyam Details",
                            link: "/udhyam-data"
                        }
                    },
                },
                {
                    path: "/udhyam-data-edit",
                    component: UdhyamDataEdit,
                    beforeEnter(to, from, next) {
                        //TODO aj33b fix this later

                        store.commit("SET_PREVIOUS_ROUTE", from.name)
                        if ( from.name !== 'udhyam-data' && from.name !== 'udhyam-fy-data-edit') {
                            store.commit("SET_EDIT_UDHYAM_DATA", {
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
                            });
                        }
                        next();
                    },
                    name: 'udhyam-data-edit',
                    meta: {
                        breadcrumb: {
                            text: "Udhyam Data Edit",
                            link: "/udhyam-data-edit"
                        }
                    },
                },
                {
                    path: "/udhyam-fy-data-edit",
                    component: UdhyamFyDataEdit,
                    beforeEnter(to, from, next) {
                        store.commit("SET_PREVIOUS_ROUTE", from.name)
                        if (from.name !== 'udhyam-data-edit') {
                            store.commit("SET_EDIT_UDHYAM_FY_DATA", {
                                id:null,
                                udhyam_id:null,
                                aarthik_barsa_id:null,
                                pratakchya_rojgari:null,
                                apratakchya_rojgari:null,
                                punji:null,
                            });
                        }
                        next();
                    },
                    name: 'udhyam-fy-data-edit',
                    meta: {
                        breadcrumb: {
                            text: "Udhyam F.Y. Data Edit",
                            link: "/udhyam-fy-data-edit"
                        }
                    },
                },
                {
                    path: "/fug-fy-data-edit",
                    component: FugFyDataEdit,
                    beforeEnter(to, from, next) {
                        store.commit("SET_PREVIOUS_ROUTE", from.name)
                        if (from.name !== 'cf-data-edit') {
                            store.commit("SET_EDIT_FUG_FY_DATA", {
                                aarthik_barsa_id:null,
                                fug_id:null,
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
                            });
                        }
                        next();
                    },
                    name: 'fug-fy-data-edit',
                    meta: {
                        breadcrumb: {
                            text: "FUG F.Y. Data Edit",
                            link: "/fug-fy-data-edit"
                        }
                    },
                },

            ]
        },
        {
            path: "/login",
            component: Login,
            name: 'Login',
            beforeEnter(to, from, next) {
                if (store.getters.GET_USER) {
                    next("/dashboard");
                } else {
                    next();
                }
            },
        },
        {
            path: "/register",
            component: Register,
            name: 'register',
            beforeEnter(to, from, next) {
                if (store.getters.GET_USER) {
                    next("/dashboard");
                } else {
                    next();
                }
            },
        },
        {
            path: "/print",
            component: PrintIncome,
            name: 'print',
            meta: {
                breadcrumb: {
                    text: "Print",
                    link: "/print"
                }
            },
        },


    ]
}

export default new VueRouter(opts)
