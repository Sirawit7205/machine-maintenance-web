<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-space-around fill-height wrap>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Total time usage - this month</div>
        <v-data-table
          :headers="summaryHeaders"
          :items="summaryItems"
          hide-actions
          class="elevation-1"
        >
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{ props.item.maintenanceHours }}</td>
            <td class="text-xs-center">{{ props.item.repairHours }}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Average time usage by machine type</div>
        <v-card>
          <v-card-text>
            <bar-chart :chartData="summaryItems[0].hoursPerType"/>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from "axios";
import BarChart from "../../components/BarChart.vue";

export default {
  components: {
    BarChart
  },

  data: () => ({
    summaryHeaders: [
      {
        text: "Maintenance Time (Hours)",
        sortable: false,
        value: "maintenanceHours",
        align: "center"
      },
      {
        text: "Repair Time (Hours)",
        sortable: false,
        value: "repairHours",
        align: "center"
      }
    ],
    summaryItems: []
  }),

  created: async function() {
  let duration = await axios.get("//localhost:80/MachineMaintenance/public/api/job/repairDuration", {
  });

  this.summaryItems = duration.data;
  }
};
</script>

