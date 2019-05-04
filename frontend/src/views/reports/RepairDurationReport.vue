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
            <td class="text-xs-center">{{ props.item.maintainHours.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.repairHours.toLocaleString() }}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Average time usage by machine type</div>
        <v-card>
          <v-card-text>
            <bar-chart :chartData="chartD"/>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Average on-site time usage per job</div>
        <v-card>
          <v-card-text>
            <pie-chart :chartData="chartD2"/>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Average carry-in time usage per job</div>
        <v-card>
          <v-card-text>
            <pie-chart :chartData="chartD3"/>
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
    summaryHeaders: [
      {
        text: "Maintenance Time (Hours)",
        sortable: false,
        value: "maintainHours",
        align: "center"
      },
      {
        text: "Repair Time (Hours)",
        sortable: false,
        value: "repairHours",
        align: "center"
      }
    ],
    summaryItems: [
      {
        maintainHours: 1511,
        repairHours: 2300
      }
    ],
    chartD: {
      datasets: [
        {
          label: "Time usage",
          data: [124, 85, 116],
          backgroundColor: "#4286F4"
        }
      ],

      labels: ["Pump", "Boiler", "Other"]
    },
    chartD2: {
      datasets: [
        {
          data: ["10.5", "3.0", "1.0", "0.5"]
        }
      ],

      labels: ["Working", "Travel", "Break", "Other"]
    },
    chartD3: {
      datasets: [
        {
          data: ["7.0", "2.0", "1.0"]
        }
      ],

      labels: ["Working", "Break", "Other"]
    }
  })
};
</script>

