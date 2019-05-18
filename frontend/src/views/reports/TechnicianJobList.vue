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
    joblistItems: [
      {
        time: "09:00",
        machine: "MC0017-Motor EDSX320",
        location: "KMUTT",
        priority: "4",
        severity: "2",
        details: "High pitch noise on start. Low torque"
      },
      {
        time: "11:00",
        machine: "MC0255-Boiler THD050",
        location: "Syned Inc.",
        priority: "3",
        severity: "3",
        details: "No heat."
      },
      {
        time: "15:00",
        machine: "MC0252-Boiler THD090",
        location: "Syned Inc.",
        priority: "3",
        severity: "2",
        details: "No heat. Error code E08"
      },
      {
        time: "16:00",
        machine: "MC0019-Motor BSDX-118",
        location: "Quilium Engineering",
        priority: "1",
        severity: "1",
        details: "Monthly maintenance"
      },
      {
        time: "17:00",
        machine: "MC0020-Motor BSDX-118",
        location: "Quilium Engineering",
        priority: "1",
        severity: "1",
        details: "Monthly maintenance"
      }
    ],

    staffId: "ST0003",
    staffName: String
  }),

  created: async function() {
  let assign = await axios.get("//localhost:80/MachineMaintenance/public/api/job/assignment/"+this.staffId, {
  });
  let name = await axios.get("//localhost:80/MachineMaintenance/public/api/staff/getName/"+this.staffId, {
  });

  this.joblistItems = assign.data;
  this.staffName = name.data;
  }
};
</script>