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
              <td class="text-xs-center">{{ props.item.machine }}</td>
              <td class="text-xs-center">{{ props.item.repairAmount }}</td>
              <td class="text-xs-center">{{ props.item.avgRepairDuration }}</td>
              <td class="text-xs-center">{{ props.item.avgPartsUsage }}</td>
              <td class="text-xs-center">
                <pie-chart-menu :chartData="props.item.reason"/>
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
              <pie-chart :chartData="chartD"/>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
import PieChart from "../../components/PieChart.vue";
import PieChartMenu from "../../components/PieChartMenu.vue";

export default {
  components: {
    PieChart,
    PieChartMenu
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
        text: "Avg parts usage",
        value: "avgPartsUsage",
        align: "center"
      },
      {
        text: "Breakdown reasons",
        value: "reason",
        align: "center"
      }
    ],
    repairItems: [
      {
        machine: "MC1001",
        repairAmount: 6,
        avgRepairDuration: 1.5,
        avgPartsUsage: 2,
        reason: {
          datasets: [
            {
              data: ["1", "2", "4"]
            }
          ],

          labels: ["A", "B", "C"]
        }
      },
      {
        machine: "MC1004",
        repairAmount: 5,
        avgRepairDuration: 3.5,
        avgPartsUsage: 7,
        reason: {
          datasets: [
            {
              data: ["3", "1", "1"]
            }
          ],

          labels: ["A", "B", "C"]
        }
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

      labels: ["A", "B", "Other"]
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

