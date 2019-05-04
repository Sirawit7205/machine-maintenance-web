<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg12 sm12>
        <div class="headline mb-1">Machine summary - {{companyName}}</div>
        <v-data-table
          :headers="machineHeaders"
          :items="machineItems"
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
            <td class="text-xs-center">{{ props.item.totalRepairCost.toLocaleString() }}</td>
            <td class="text-xs-center">
              <v-menu
                v-model="machineListMenu"
                :close-on-content-click="false"
                :nudge-bottom="10"
                transition="slide-y-transition"
                origin="top center"
                offset-y
                full-width
              >
                <template v-slot:activator="{ on }">
                  <v-btn flat v-on="on">View</v-btn>
                </template>
                <div style="background-color: white; border: 10px solid white">
                  <ul>
                    <li
                      v-for="item in props.item.machineList"
                      :key="item.id"
                    >{{ item.id }} - {{ item.model }}</li>
                  </ul>
                </div>
              </v-menu>
            </td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex lg6 sm12>
        <div class="headline mb-1">Machine type</div>
        <v-card>
          <v-card-text>
            <pie-chart :chartData="chartD"/>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg6 sm12>
        <div class="headline mb-1">Avg Cost of repair by type</div>
        <v-card>
          <v-card-text>
            <bar-chart :chartData="chartD"/>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import BarChart from "../../components/BarChart.vue";
import PieChart from "../../components/PieChart.vue";

export default {
  components: {
    BarChart,
    PieChart
  },

  data: () => ({
    machineListMenu: false,
    companyName: "ABCD Inc.",

    machineHeaders: [
      {
        text: "Total machines",
        sortable: false,
        value: "machineCount",
        align: "center"
      },
      {
        text: "Types of machine",
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
        text: "Repair cost last year (Baht)",
        sortable: false,
        value: "totalRepairCost",
        align: "center"
      },
      {
        text: "View machine list",
        sortable: false,
        value: "machineList",
        align: "center"
      }
    ],
    machineItems: [
      {
        machineCount: 25,
        machineTypeCount: 3,
        totalBreakdown: 10,
        totalRepairCost: 10000,
        machineList: [
          { id: "MC1001", model: "HXH001" },
          { id: "MC1002", model: "HXH001" },
          { id: "MC1003", model: "HXH005" }
        ]
      }
    ],
    chartD: {
      datasets: [
        {
          data: [124, 85, 116],
          backgroundColor: ["#292049", "#489430", "#583928"]
        }
      ],

      labels: ["Pump", "Boiler", "Other"]
    }
  })
};
</script>

