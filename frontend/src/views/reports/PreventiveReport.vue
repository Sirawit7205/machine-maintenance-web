<template>
  <div>
    <v-container grid-list-md fill-height>
      <v-layout align-start justify-space-around fill-height wrap>
        <v-flex lg9 sm9>
          <div class="headline mb-1">Least maintained machines</div>
          <v-data-table :headers="maintainHeaders" :items="maintainItems" class="elevation-1">
            <template v-slot:no-data>
              <v-alert :value="true" type="warning">No data available</v-alert>
            </template>
            <template v-slot:items="props">
              <td class="text-xs-center">{{ props.item.machine }}</td>
              <td class="text-xs-center">{{ props.item.lastCheck }}</td>
            </template>
          </v-data-table>
        </v-flex>
      </v-layout>
    </v-container>
    <v-container grid-list-md fill-height>
      <v-layout align-start justify-space-around fill-height wrap>
        <v-flex lg6 sm9>
          <div class="headline mb-1">Average last check time</div>
          <v-card>
            <v-card-text>
              <bar-chart :chartData="chartD"/>
            </v-card-text>
          </v-card>
        </v-flex>
        <v-flex lg6 sm9>
          <div class="headline mb-1">Last check status</div>
          <v-card>
            <v-card-text>
              <pie-chart :chartData="chartD2"/>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
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
    maintainHeaders: [
      {
        text: "Machine",
        value: "machine",
        align: "center"
      },
      {
        text: "Last check",
        value: "lastCheck",
        align: "center"
      }
    ],
    maintainItems: [
      {
        machine: "MC1001",
        lastCheck: "10/1/2017"
      },
      {
        machine: "MC1002",
        lastCheck: "31/7/2018"
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
    }
  })
};
</script>

