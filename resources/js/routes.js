import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const App = () => import("./components/App");
const Login = () => import("./components/auth/Login");
const Register = () => import("./components/auth/Register");

const opts = {

    mode: "history",
    routes: [
        {
            path:"/",
            component: App,
            name:'App'
        },
        {
            path:"/login",
            component: Login,
            name:'Login'
        },
        {
            path:"/register",
            component: Register,
            name:'Register'
        }

    ]
}

export default new VueRouter(opts)
