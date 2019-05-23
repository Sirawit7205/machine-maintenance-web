<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg12 sm12>
        <div class="headline mb-1">Current resource status</div>
        <v-data-table
          :headers="statusHeaders"
          :items="statusItems"
          hide-actions
          class="elevation-1"
        >
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{ props.item.avgPriority }}</td>
            <td class="text-xs-center">{{ props.item.stressScore }}</td>
            <td class="text-xs-center">{{ props.item.assignedTech.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.availTech.toLocaleString() }}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex lg12 sm12>
        <div class="headline mb-1">Current open jobs</div>
        <v-data-table :headers="jobHeaders" :items="jobItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">
              [{{ props.item.machineID }}] {{ props.item.machineType }} - {{ props.item.modelNumber }}
            </td>
            <td class="text-xs-center">{{ props.item.status }}</td>
            <td class="text-xs-center">{{ props.item.severity }}</td>
            <td class="text-xs-center">{{ props.item.priority }}</td>
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
    statusHeaders: [
      {
        text: "Average priority",
        sortable: false,
        value: "avgPriority",
        align: "center"
      },
      {
        text: "Stress score",
        sortable: false,
        value: "stressScore",
        align: "center"
      },
      {
        text: "Assigned Technicians",
        sortable: false,
        value: "assignedTech",
        align: "center"
      },
      {
        text: "Available Technicians",
        sortable: false,
        value: "availTech",
        align: "center"
      }
    ],
    jobHeaders: [
      {
        text: "Machine",
        value: "machine",
        sortable: false,
        align: "center"
      },
      {
        text: "Status",
        value: "status",
        sortable: false,
        align: "center"
      },
      {
        text: "Severity",
        value: "severity",
        sortable: false,
        align: "center"
      },
      {
        text: "Priority",
        value: "priority",
        sortable: false,
        align: "center"
      }
    ],
    statusItems: [],
    jobItems: []
  }),

  created: async function() {
  let resList = await axios.get("//localhost:80/MachineMaintenance/public/api/job/resource", {
  });
  let openList = await axios.get("//localhost:80/MachineMaintenance/public/api/job/open", {
  });

  this.statusItems = resList.data;
  this.jobItems = openList.data;
  }
};
</script>

