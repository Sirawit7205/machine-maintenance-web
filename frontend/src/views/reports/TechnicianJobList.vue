<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs12 md12>
        <div class="headline mb-1">Job List - {{ staffName }}</div>
        <v-data-table :headers="joblistHeaders" :items="joblistItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.startTime}}</td>
            <td class="text-xs-center">
              [{{ props.item.machineId }}] {{ props.item.machineType }} - {{ props.item.modelNumber }}
            </td>
            <td class="text-xs-center">{{props.item.customerName}}</td>
            <td class="text-xs-center">{{props.item.priority}}</td>
            <td class="text-xs-center">{{props.item.severity}}</td>
            <td class="text-xs-center">{{props.item.details}}</td>
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
    joblistHeaders: [
      {
        text: "Start time",
        value: "time",
        align: "center"
      },
      {
        text: "Machine",
        value: "machine",
        align: "center"
      },
      {
        text: "Location",
        value: "location",
        align: "center"
      },
      {
        text: "Priority",
        value: "priority",
        align: "center"
      },
      {
        text: "Severity",
        value: "severity",
        align: "center"
      },
      {
        text: "Details",
        value: "details",
        align: "center"
      }
    ],
    joblistItems: [],

    staffId: "",
    staffName: String
  }),

  created: async function() {
  let assign = await axios.get("//localhost:80/MachineMaintenance/public/api/job/assignment/"+this.$root.authInfo.userId, {
  });
  let name = await axios.get("//localhost:80/MachineMaintenance/public/api/staff/getName/"+this.$root.authInfo.userId, {
  });

  this.staffId = this.$root.authInfo.userId;
  this.joblistItems = assign.data;
  this.staffName = name.data;
  }
};
</script>