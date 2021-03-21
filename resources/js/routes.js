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
                },
                {
                    path: "/dashboard",
                    component: Dashboard,
                    name: 'dashboard',
                },
                {
                    path: "/home",
                    component: Home,
                    name: 'home',
                },
                {
                    path: "/change-password",
                    component: ChangePassword,
                    name: 'change-password',
                },
                {
                    path: "/cf-data",
                    component: CFData,
                    name: 'cf-data'
                },
                {
                    path: "/cf-data-edit",
                    component: CFDataEdit,
                    name: 'cf-data-edit'
                }
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


    ]
}

export default new VueRouter(opts)
