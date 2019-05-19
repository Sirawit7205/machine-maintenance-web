import Vue from "vue";
import Router from "vue-router";
const PublicHome = () => import("./views/PublicHome.vue");
const InternalHome = () => import("./views/InternalHome.vue");
const Login = () => import("./views/forms/Login.vue");
const Register = () => import("./views/forms/Register.vue");
const Staff = () => import("./views/forms/Staff.vue");
const Contract = () => import("./views/forms/Contract.vue");
const Machine = () => import("./views/forms/Machine.vue");
const AddLog = () => import("./views/forms/Log.vue");
const EditPart = () => import("./views/forms/EditPart.vue");
const PartsInOut = () => import("./views/forms/PartsInOut.vue");
const JobAssignment = () => import("./views/forms/JobAssignment.vue");
const ContractReport = () => import("./views/reports/ContractReport.vue");
const RepairDurationReport = () =>
  import("./views/reports/RepairDurationReport.vue");
const TransactionReport = () => import("./views/reports/TransactionReport.vue");
const PreventiveReport = () => import("./views/reports/PreventiveReport.vue");
const RepairReport = () => import("./views/reports/RepairReport.vue");
const CurrentJobReport = () => import("./views/reports/CurrentJobReport.vue");
const CustomerLoyalty = () => import("./views/reports/CustomerLoyalty.vue");
const StaffSalary = () => import("./views/reports/StaffSalary.vue");
const TechnicianPerformance = () => import("./views/reports/TechnicianPerformance.vue");
const TechnicianJobList = () => import("./views/reports/TechnicianJobList.vue");
const StaffVacation = () => import("./views/reports/StaffVacation.vue");
const MachineDetails = () => import("./views/reports/MachineDetails.vue");
const JobAssignmentReport = () => import("./views/reports/JobAssignment.vue");
const LogSummary = () => import("./views/reports/LogSummary.vue");
const PartsReport = () => import("./views/reports/PartsReport.vue");
const MachineSummary = () => import("./views/reports/MachineSummary.vue");

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: "/",
      name: "publicHome",
      component: PublicHome
    },
    {
      path: "/internalHome",
      name: "internalHome",
      component: InternalHome
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
      path: "/forms/login",
      name: "login",
      component: Login
    },
    {
      path: "/forms/register",
      name: "register",
      component: Register
    },
    {
      path: "/forms/staff",
      name: "staff",
      component: Staff
    },
    {
      path: "/forms/contract",
      name: "contract",
      component: Contract
    },
    {
      path: "/forms/machine",
      name: "machine",
      component: Machine
    },
    {
      path: "/forms/addlog",
      name: "addlog",
      component: AddLog
    },
    {
      path: "/forms/editpart",
      name: "editpart",
      component: EditPart
    },
    {
      path: "/forms/jobas",
      name: "jobas",
      component: JobAssignment
    },
    {
      path: "/forms/partsInOut",
      name: "partsInOut",
      component: PartsInOut
    },
    {
      path: "/reports/Contract",
      name: "contractReport",
      component: ContractReport
    },
    {
      path: "/reports/RepairDuration",
      name: "repairDurReport",
      component: RepairDurationReport
    },
    {
      path: "/reports/Transaction",
      name: "transactionReport",
      component: TransactionReport
    },
    {
      path: "/reports/Preventive",
      name: "preventiveReport",
      component: PreventiveReport
    },
    {
      path: "/reports/Repair",
      name: "repairReport",
      component: RepairReport
    },
    {
      path: "/reports/currentJob",
      name: "currentJob",
      component: CurrentJobReport
    },
    {
      path: "/reports/customerLoyalty",
      name: "customerLoyalty",
      component: CustomerLoyalty
    },
    {
      path: "/reports/staffSalary",
      name: "staffSalary",
      component: StaffSalary
    },
    {
      path: "/reports/technicianPerformance",
      name: "technicianPerformance",
      component: TechnicianPerformance
    },
    {
      path: "/reports/technicianJobList",
      name: "technicianJobList",
      component: TechnicianJobList
    },
    {
      path: "/reports/staffVacation",
      name: "staffVacation",
      component: StaffVacation
    },
    {
      path: "/reports/machineDetails",
      name: "machineDetails",
      component: MachineDetails
    },
    {
      path: "/reports/jobAssignmentReport",
      name: "jobAssignmentReport",
      component: JobAssignmentReport
    },
    {
      path: "/reports/LogSummary",
      name: "logSummary",
      component: LogSummary
    },
    {
      path: "/reports/PartsReport",
      name: "partsReport",
      component: PartsReport
    },
    {
      path: "/reports/MachineSummary",
      name: "machineSummary",
      component: MachineSummary
    }
  ]
});
