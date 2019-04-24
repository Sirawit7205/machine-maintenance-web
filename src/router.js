import Vue from "vue";
import Router from "vue-router";
const Home = () => import("./views/Home.vue");
const Login = () => import("./views/Login.vue");
const Staff = () => import("./views/Staff.vue");
const Contract = () => import("./views/Contract.vue");
const Machine = () => import("./views/Machine.vue");
const AddLog = () => import("./views/Log.vue");
const EditPart = () => import("./views/EditPart.vue");
const PartsInOut = () => import("./views/PartsInOut.vue");
const JobAssignment = () => import("./views/JobAssignment.vue");

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
    },
    {
      path: "/editpart",
      name: "editpart",
      component: EditPart
    },
    {
      path: "/jobas",
      name: "jobas",
      component: JobAssignment
    },
    {
      path: "/partsInOut",
      name: "partsInOut",
      component: PartsInOut
    }
  ]
});
