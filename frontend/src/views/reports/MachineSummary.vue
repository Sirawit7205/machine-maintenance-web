<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg12 sm12>
        <div class="headline mb-1">Machine Summary - {{companyName}}</div>
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
            <td class="text-xs-center">{{ props.item.totalRepairCost.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.machineList }}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Machine types</div>
        <v-card>
          <v-card-text>
            <pie-chart :chartData="chartD"/>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Avg cost of repair</div>
        <v-card>
          <v-card-text>
            <bar-chart :chartData="chartD2"/>
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
    companyName: "XXXXX",

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
        text: "Total repair cost last year (Baht)",
        sortable: false,
        value: "totalRepairCost",
        align: "center"
      },
      {
        text: "Machine list",
        sortable: false,
        value: "machineList",
        align: "center"
      }
    ],
    summaryItems: [
      {
        machineCount: 20,
        machineTypeCount: 5,
        totalBreakdown: 10,
        totalRepairCost: 10000,
        machineList: "View"
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
    },

    chartD2: {
      datasets: [
        {
          label: "Time usage",
          data: [124, 85, 116],
          backgroundColor: "#4286F4"
        }
      ],

      labels: ["Pump", "Boiler", "Other"]
    },
  })
};
</script>

