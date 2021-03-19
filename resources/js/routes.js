import Vue from 'vue'
import VueRouter from 'vue-router'

import store from "./store";


Vue.use(VueRouter)

const App = () => import("./components/App");
const Login = () => import("./components/auth/Login");
const Register = () => import("./components/auth/Register");

const opts = {

    mode: "history",
    routes: [
        {
            path: "/",
            component: App,
            name: 'App',
            beforeEnter(to, from, next) {
                if (store.getters.GET_USER) {
                    next("/home");
                } else {
                    next("/login");
                }
            },
        },
        {
            path: "/home",
            component: Dashboard,
            name: 'Dashboard',
            beforeEnter(to, from, next) {
                if (store.getters.GET_USER) {
                    next("/")
                } else {
                    next("/login");
                }
            },
        },
        {
            path: "/login",
            component: Login,
            name: 'Login'
        },
        {
            path: "/register",
            component: Register,
            name: 'Register'
        }

    ]
}

export default new VueRouter(opts)
