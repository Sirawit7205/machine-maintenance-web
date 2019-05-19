<template>
  <div>
    <v-container grid-list-md fill-height>
      <v-layout align-start justify-space-around fill-height wrap>
        <v-flex lg12 sm12>
          <div class="headline mb-1">Top repair - this month</div>
          <v-data-table :headers="repairHeaders" :items="repairItems" class="elevation-1">
            <template v-slot:no-data>
              <v-alert :value="true" type="warning">No data available</v-alert>
            </template>
            <template v-slot:items="props">
              <td class="text-xs-center">
                [{{ props.item.machineId }}] {{ props.item.machineType }} - {{ props.item.modelNumber }}
              </td>
              <td class="text-xs-center">{{ props.item.repairAmount }}</td>
              <td class="text-xs-center">{{ props.item.avgRepairDuration }}</td>
              <td class="text-xs-center">
                <pie-chart-menu-multi :machineId="props.item.machineId"/>
              </td>
            </template>
          </v-data-table>
        </v-flex>
      </v-layout>
    </v-container>
    <v-container grid-list-md fill-height>
      <v-layout align-start justify-space-around fill-height wrap>
        <v-flex lg6 sm9>
          <div class="headline mb-1">Overall breakdown reasons - this month</div>
          <v-card>
            <v-card-text>
              <pie-chart :chartData="topBreakdownReason"/>
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
import PieChartMenuMulti from "../../components/PieChartMenuMulti.vue";

export default {
  components: {
    PieChart,
    PieChartMenuMulti
  },

  data: () => ({
    repairHeaders: [
      {
        text: "Machine",
        value: "machine",
        align: "center"
      },
      {
        text: "Times of repair",
        value: "repairAmount",
        align: "center"
      },
      {
        text: "Avg repair duration (Hours)",
        value: "avgRepairDuration",
        align: "center"
      },
      {
        text: "Breakdown reasons",
        value: "reason",
        align: "center"
      }
    ],
    repairItems: [],
    topBreakdownReason: []
  }),

  created: async function() {
  let topRepair = await axios.get("//localhost:80/MachineMaintenance/public/api/job/topRepair", {
  });
  let topReason = await axios.get("//localhost:80/MachineMaintenance/public/api/job/topReason", {
  });
  let byCustomer = await axios.get("//localhost:80/MachineMaintenance/public/api/log/byCustomer", {
  });

  this.repairItems = topRepair.data;
  this.topBreakdownReason = topReason.data;
  this.topCustomerItems = byCustomer.data;
  }
};
</script>

