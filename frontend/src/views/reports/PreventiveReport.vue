<template>
  <div>
    <v-container grid-list-md fill-height>
      <v-layout align-start justify-space-around fill-height wrap>
        <v-flex lg6 sm9>
          <div class="headline mb-1">Least maintained machines</div>
          <v-data-table :headers="maintainHeaders" :items="maintainItems" class="elevation-1">
            <template v-slot:no-data>
              <v-alert :value="true" type="warning">No data available</v-alert>
            </template>
            <template v-slot:items="props">
              <td class="text-xs-center">
                [{{ props.item.machineID }}] {{ props.item.machineType }} - {{ props.item.modelNumber }}
              </td>
              <td class="text-xs-center">{{ props.item.lastCheck }}</td>
            </template>
          </v-data-table>
        </v-flex>
        <v-flex lg6 sm9>
          <div class="headline mb-1">Last check status</div>
          <v-card>
            <v-card-text>
              <pie-chart :chartData="lastStatus"/>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";
import PieChart from "../../components/PieChart.vue";

export default {
  components: {
    PieChart
  },

  data: () => ({
    maintainHeaders: [
      {
        text: "Machine",
        value: "machine",
        sortable: false,
        align: "center"
      },
      {
        text: "Last check",
        value: "lastCheck",
        sortable: false,
        align: "center"
      }
    ],
    maintainItems: [],
    lastStatus: []
  }),

  created: async function() {
  let maintain = await axios.get("//localhost:80/MachineMaintenance/public/api/machine/leastMaintain", {
  });
  let last = await axios.get("//localhost:80/MachineMaintenance/public/api/machine/lastStatus", {
  });

  this.maintainItems = maintain.data;
  this.lastStatus = last.data;
  }
};
</script>

