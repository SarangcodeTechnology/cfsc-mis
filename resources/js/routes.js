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

const opts = {

    mode: "history",
    routes: [
        {
            path: "/",
            component: App,
            name: 'app',
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
                    name: 'Dashboard',
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
            ]
        },
        {
            path: "/login",
            component: Login,
            name: 'Login'
        },
        {
            path: "/register",
            component: Register,
            name: 'register'
        }

    ]
}

export default new VueRouter(opts)
