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
        src="./assets/pelogo.png"
        alt="Logo"
        width="auto"
        height="90%"
        style="cursor: pointer"
      >
      <v-toolbar-title class="headline">
        <span>Machine Maintenance Database v1.0</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn flat to="/">
        <span>Back to homepage</span>
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
        { title: "Add/Edit Staff", icon: "account_box", to: "/staff" },
        { title: "Add/Edit Contract", icon: "book", to: "/contract" },
        { title: "Add/Edit Machine", icon: "developer_board", to: "/machine" },
        { title: "Add/Edit parts", icon: "toys", to: "/editpart" },
        { title: "Add log", icon: "assignment", to: "/addlog" },
        { title: "Job assignment", icon: "assignment_turned_in", to: "/jobas" },
        {
          title: "Parts transasctions",
          icon: "compare_arrows",
          to: "/partsInOut"
        }
      ],

      reportItems: [
        { title: "Contract", icon: "book", to: "/reports/contract" },
        {
          title: "Repair duration",
          icon: "alarm",
          to: "/reports/repairDuration"
        },
        {
          title: "Transaction",
          icon: "attach_money",
          to: "/reports/transaction"
        },
        {
          title: "Preventive Maintenance",
          icon: "check_circle",
          to: "/reports/preventive"
        },
        { title: "Repair", icon: "build", to: "/reports/repair" },
        {
          title: "Company Machine",
          icon: "dvr",
          to: "/reports/companyMachine"
        },
        { title: "Current Job", icon: "list_alt", to: "/reports/currentJob" },
        { title: "Customer Loyalty", icon: "sentiment_satisfied_alt", to: "/reports/customerLoyalty"},
        { title: "Staff Salary", icon: "account_balance_wallet", to: "/reports/staffSalary" }
      ],

      right: null,
      drawerState: false,
      text: ""
    };
  },
  /*created: async function() {
    let x = await axios.post("//localhost:8888", {
      id: 3
    });

    this.text = x.data.Course;
  },*/
  methods: {
    goToHome() {
      return this.$router.push("/");
    }
  }
};
</script>
