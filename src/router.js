import Vue from "vue";
import Router from "vue-router";
import Home from "./views/Home.vue";
import Login from "./views/Login.vue";
import Staff from "./views/Staff.vue";
import Contract from "./views/Contract.vue";
import Machine from "./views/Machine.vue";
import AddLog from "./views/Log.vue";

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: "/",
      name: "home",
      component: Home
    },
    {
      path: "/about",
      name: "about",
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () =>
        import(/* webpackChunkName: "about" */ "./views/About.vue")
    },
    {
      path: "/login",
      name: "login",
      component: Login
    },
    {
      path: "/staff",
      name: "staff",
      component: Staff
    },
    {
      path: "/contract",
      name: "contract",
      component: Contract
    },
    {
      path: "/machine",
      name: "machine",
      component: Machine
    },
    {
      path: "/addlog",
      name: "addlog",
      component: AddLog
    }
  ]
});
