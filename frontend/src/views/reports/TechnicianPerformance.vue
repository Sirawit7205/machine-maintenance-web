<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs9 md9>
        <div class="headline mb-1">Technician List</div>
        <v-data-table :headers="techHeaders" :items="techItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.staffName}}</td>
            <td class="text-xs-center">{{props.item.experience}}</td>
            <td class="text-xs-center">{{props.item.jobCount}}</td>
            <td class="text-xs-center">{{props.item.avgTime}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs9 md9>
        <div class="headline mb-1">Current Status</div>
        <v-data-table :headers="statusHeaders" :items="statusItems" hide-actions class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.totalTechnician}}</td>
            <td class="text-xs-center">{{props.item.avgExperience}}</td>
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
    techHeaders: [
      {
        text: "Staff",
        value: "staffName",
        align: "center"
      },
      {
        text: "Experience",
        value: "experience",
        align: "center"
      },
      {
        text: "Job Done This Month",
        value: "jobCount",
        align: "center"
      },
      {
        text: "Average Time Per Job",
        value: "avgTime",
        align: "center"
      }
    ],
    statusHeaders: [
      {
        text: "Total Technician",
        sortable: false,
        value: "totalTechnician",
        align: "center"
      },
      {
        text: "Avg Experience",
        sortable: false,
        value: "avgExperience",
        align: "center"
      }
    ],
    techItems: [],
    statusItems: []
  }),

  created: async function() {
  let perfData = await axios.get("//localhost:80/MachineMaintenance/public/api/staff/performance", {
  });
  let statData = await axios.get("//localhost:80/MachineMaintenance/public/api/staff/status", {
  });

  this.techItems = perfData.data;
  this.statusItems = statData.data;
  }
};
</script>