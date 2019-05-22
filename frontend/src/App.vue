<template>
  <v-app>
    <v-navigation-drawer app v-model="drawerState" width="250px" clipped>
      <v-toolbar flat>
        <v-list>
          <v-list-tile>
            <v-list-tile-title class="title">Forms</v-list-tile-title>
          </v-list-tile>
        </v-list>
      </v-toolbar>

      <v-divider></v-divider>

      <v-list dense class="pt-0">
        <v-list-tile v-for="item in formItems" :key="item.title" :to="item.to">
          <v-list-tile-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>

      <v-toolbar flat>
        <v-list>
          <v-list-tile>
            <v-list-tile-title class="title">Reports</v-list-tile-title>
          </v-list-tile>
        </v-list>
      </v-toolbar>

      <v-divider></v-divider>

      <v-list dense class="pt-0">
        <v-list-tile v-for="item in reportItems" :key="item.title" :to="item.to">
          <v-list-tile-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>

    <v-toolbar app clipped-left>
      <v-toolbar-side-icon @click="drawerState = !drawerState"></v-toolbar-side-icon>
      <img
        @click="goToHome"
        src="./assets/logo.png"
        alt="Logo"
        width="auto"
        height="65%"
        style="cursor: pointer"
      >
      <v-toolbar-title class="headline">
        <span>Machine Maintenance Database v1.0</span>
      </v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn flat outline to="/forms/register" v-if="$root.authInfo.authStatus == 0">
        <span>Register</span>
      </v-btn>
      <v-btn flat outline to="/forms/login" v-if="$root.authInfo.authStatus == 0">
        <span>Login</span>
      </v-btn>

      <div class="subheading" v-if="$root.authInfo.authStatus == 1">
        <span>Logged in as {{name}}</span>
      </div>
      <v-btn flat outline @click="resetAuthState" v-if="$root.authInfo.authStatus == 1">
        <span>Logout</span>
      </v-btn>
    </v-toolbar>

    <v-content>
      <router-view/>
    </v-content>
  </v-app>
</template>

<script>
import axios from "axios";
import Chart from "chart.js";

export default {
  name: "App",
  data() {
    return {
      formItems: [
        { title: "Home", icon: "home", to: "/" },
        { title: "Add/Edit Contract", icon: "book", to: "/forms/contract" },
        {
          title: "Add/Edit Machine",
          icon: "developer_board",
          to: "/forms/machine"
        },
        { title: "Add/Edit Parts", icon: "toys", to: "/forms/editpart" },
        { title: "Add/Edit Staff", icon: "account_box", to: "/forms/staff" },
        { title: "Add log", icon: "assignment", to: "/forms/addlog" },
        { title: "Job assignment", icon: "edit", to: "/forms/jobas" },
        {
          title: "Parts transasctions",
          icon: "compare_arrows",
          to: "/forms/partsInOut"
        }
      ],

      reportItems: [
        { title: "Contract", icon: "book", to: "/reports/contract" },
        {
          title: "Customer Loyalty",
          icon: "sentiment_satisfied_alt",
          to: "/reports/customerLoyalty"
        },
        {
          title: "Machine Details",
          icon: "developer_board",
          to: "/reports/machineDetails"
        },
        {
          title: "Machine Summary",
          icon: "view_module",
          to: "/reports/machineSummary"
        },
        { title: "Current Job", icon: "list_alt", to: "/reports/currentJob" },
        {
          title: "Job assignment",
          icon: "assignment_turned_in",
          to: "/reports/jobAssignmentReport"
        },
        {
          title: "Technician Job List",
          icon: "format_list_numbered",
          to: "/reports/technicianJobList"
        },
        {
          title: "Technician Performance",
          icon: "show_chart",
          to: "/reports/technicianPerformance"
        },
        { title: "Parts Report", icon: "toys", to: "/reports/partsReport" },
        {
          title: "Staff Salary",
          icon: "account_balance_wallet",
          to: "/reports/staffSalary"
        },
        {
          title: "Staff Vacation",
          icon: "brightness_5",
          to: "/reports/staffVacation"
        },
        {
          title: "Log Summary",
          icon: "library_books",
          to: "/reports/logSummary"
        },
        {
          title: "Preventive Maintenance",
          icon: "check_circle",
          to: "/reports/preventive"
        },
        { title: "Repair", icon: "build", to: "/reports/repair" },
        {
          title: "Repair duration",
          icon: "alarm",
          to: "/reports/repairDuration"
        },
        {
          title: "Transaction",
          icon: "attach_money",
          to: "/reports/transaction"
        }
      ],

      right: null,
      drawerState: false,
      name: ""
    };
  },
  methods: {
    goToHome() {
      if (this.$root.authInfo.authStatus == 1) {
        return this.$router.push("/internalHome");
      } else {
        return this.$router.push("/");
      }
    },

    resetAuthState() {
      this.$root.authInfo.authStatus = 0;
      this.$root.authInfo.accessLevel = null;
      this.$root.authInfo.userId = null;

      this.$router.push("/");
    }
  },

  updated: async function() {
    let staffName = await axios.get(
      "//localhost:80/MachineMaintenance/public/api/staff/getName/" +
        this.$root.authInfo.userId,
      {}
    );
    let custrName = await axios.get(
      "//localhost:80/MachineMaintenance/public/api/customer/getName/" +
        this.$root.authInfo.userId,
      {}
    );

    if (!staffName.data && custrName.data) this.name = custrName.data;
    else if (staffName.data && !custrName.data) this.name = staffName.data;
    else this.name = null;
  }
};
</script>
