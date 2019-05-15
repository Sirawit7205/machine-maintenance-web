<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs12 md9>
        <div class="headline mb-1">Staff List</div>
        <v-data-table :headers="staffHeaders" :items="staffItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.staffName}}</td>
            <td class="text-xs-center">{{props.item.position}}</td>
            <td class="text-xs-center">{{props.item.salary.toLocaleString()}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs12 md9>
        <div class="headline mb-1">Role Salary</div>
        <v-data-table :headers="roleHeaders" :items="roleItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.position}}</td>
            <td class="text-xs-center">{{props.item.avgSalary.toLocaleString()}}</td>
            <td class="text-xs-center">{{props.item.minSalary.toLocaleString()}}</td>
            <td class="text-xs-center">{{props.item.maxSalary.toLocaleString()}}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    staffHeaders: [
      {
        text: "Staff Name",
        value: "staffName",
        align: "center"
      },
      {
        text: "Position",
        value: "position",
        align: "center"
      },
      {
        text: "Salary (Baht)",
        value: "salary",
        align: "center"
      }
    ],
    roleHeaders: [
      {
        text: "Position",
        value: "position",
        align: "center"
      },
      {
        text: "Avg Salary(Baht)",
        value: "avgSalary",
        align: "center"
      },
      {
        text: "Min Salary(Baht)",
        value: "minSalary",
        align: "center"
      },
      {
        text: "Max Salary(Baht)",
        value: "maxSalary",
        align: "center"
      }
    ],
    staffItems: [],
    roleItems: []
  }),

  created: async function() {
    let salPos = await axios.get("//localhost:80/MachineMaintenance/public/api/staff/salaryPosition", {
    });
    let salList = await axios.get("//localhost:80/MachineMaintenance/public/api/staff/salaryList", {
    });

    this.roleItems = salPos.data;
    this.staffItems = salList.data;
  }
};
</script>