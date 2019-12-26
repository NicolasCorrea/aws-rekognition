import Vue from "vue";
import VueRouter from "vue-router";
import { post } from "axios";
const originalPush = VueRouter.prototype.push;
VueRouter.prototype.push = function push(location) {
  return originalPush.call(this, location).catch(err => err)
};
Vue.use(VueRouter);

import Hello from "./../views/Hello";
import Home from "./../views/Home";
import Login from "./../views/Auth/Login";
import Register from "./../views/Auth/Register";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            redirect: to => {
                return "/home";
            }
        },
        {
            path: "/home",
            name: "home",
            component: Home
        },
        {
            path: "/hello",
            name: "hello",
            component: Hello
        },
        {
            path: "/login",
            name: "login",
            component: Login
        },
        {
            path: "/register",
            name: "register",
            component: Register
        },

    ]
});
// router.beforeEach((to, from, next) => {
//     console.log(to, from);
//     if (to == from) {
//         return;
//     }
//     post("/api/check").then(r => console.log(r));
//     next();
// });
export default router;
