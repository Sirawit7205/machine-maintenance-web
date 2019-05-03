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
        <bar-chart :chartData="chartD"/>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
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
    }
  })
};
</script>

