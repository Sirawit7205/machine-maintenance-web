<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg12 sm12>
        <div class="headline mb-1">Machine Summary - {{customerName}}</div>
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
            <td class="text-xs-center">{{ props.item.machineCount.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.machineTypeCount.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.totalBreakdown.toLocaleString() }}</td>
            <td class="text-xs-center">
              <machine-list-menu :customerId="customerId"/>
            </td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Machine types</div>
        <v-card>
          <v-card-text>
            <pie-chart :chartData="summaryItems[0].machineAmount"/>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Contract price by type</div>
        <v-card>
          <v-card-text>
            <bar-chart :chartData="summaryItems[0].contractPricePerType"/>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from "axios";
import BarChart from "../../components/BarChart.vue";
import PieChart from "../../components/PieChart.vue";
import MachineListMenu from "../../components/MachineListMenu.vue";

export default {
  components: {
    BarChart,
    PieChart,
    MachineListMenu
  },

  data: () => ({
    summaryHeaders: [
      {
        text: "Total machines",
        sortable: false,
        value: "machineCount",
        align: "center"
      },
      {
        text: "Type of machines",
        sortable: false,
        value: "machineTypeCount",
        align: "center"
      },
      {
        text: "Total breakdown last year",
        sortable: false,
        value: "totalBreakdown",
        align: "center"
      },
      {
        text: "Machine list",
        sortable: false,
        value: "machineList",
        align: "center"
      }
    ],
    summaryItems: [],

    customerId: "",
    customerName: ""
  }),

  created: async function() {
  let summary = await axios.get("//localhost:80/MachineMaintenance/public/api/machine/byCustomer/"+this.$root.authInfo.userId, {
  });
  let name = await axios.get("//localhost:80/MachineMaintenance/public/api/customer/getName/"+this.$root.authInfo.userId, {
  });

  this.customerId = this.$root.authInfo.userId;
  this.summaryItems = summary.data;
  this.customerName = name.data;
  }
};
</script>

