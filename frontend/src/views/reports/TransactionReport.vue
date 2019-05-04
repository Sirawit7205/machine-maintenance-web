<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg12 sm12>
        <div class="headline mb-1">Transaction Summary</div>
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
            <td class="text-xs-center">{{ props.item.totalDiff.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.totalIncome.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.totalExpense.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.avgPerCustomer.toLocaleString() }}</td>
            <td class="text-xs-center">
              <pie-chart-menu :chartData="chartD"/>
            </td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Type of income</div>
        <v-card>
          <v-card-text>
            <pie-chart :chartData="chartD"/>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Type of expense</div>
        <v-card>
          <v-card-text>
            <pie-chart :chartData="chartD"/>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg12 sm12>
        <div class="headline mb-1">Income list</div>
        <v-data-table :headers="listHeaders" :items="incomeItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{ props.item.timestamp }}</td>
            <td class="text-xs-center">{{ props.item.amount.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.type }}</td>
            <td class="text-xs-center">{{ props.item.details }}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex lg12 sm12>
        <div class="headline mb-1">Expense list</div>
        <v-data-table :headers="listHeaders" :items="expenseItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{ props.item.timestamp }}</td>
            <td class="text-xs-center">{{ props.item.amount.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.type }}</td>
            <td class="text-xs-center">{{ props.item.details }}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
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
    summaryHeaders: [
      {
        text: "Total Profit (Baht)",
        sortable: false,
        value: "totalDiff",
        align: "center"
      },
      {
        text: "Total Income (Baht)",
        sortable: false,
        value: "totalIncome",
        align: "center"
      },
      {
        text: "Total expense (Baht)",
        sortable: false,
        value: "totalExpense",
        align: "center"
      },
      {
        text: "Avg profit per customer (Baht)",
        sortable: false,
        value: "avgPerCustomer",
        align: "center"
      },
      {
        text: "Avg profit per machine type",
        sortable: false,
        value: "avgPerType",
        align: "center"
      }
    ],
    listHeaders: [
      {
        text: "Timestamp",
        value: "timestamp",
        align: "center"
      },
      {
        text: "Amount (Baht)",
        value: "amount",
        align: "center"
      },
      {
        text: "Type",
        value: "type",
        align: "center"
      },
      {
        text: "Details",
        value: "details",
        align: "center"
      }
    ],
    summaryItems: [
      {
        profit: 3000000,
        income: 5000000,
        expense: 2000000,
        avgProfitCust: 150000,
        AvgProfitPerType: null
      }
    ],
    incomeItems: [
      {
        timestamp: "17/2/2019 13:16",
        amount: 150000,
        type: "Contract",
        details: "CN1001"
      },
      {
        timestamp: "19/2/2019 14:00",
        amount: 1200,
        type: "Job income",
        details: "JB1003"
      }
    ],
    expenseItems: [
      {
        timestamp: "17/2/2019 08:40",
        amount: 1700,
        type: "Part cost",
        details: "PT1001"
      },
      {
        timestamp: "19/2/2019 11:00",
        amount: 1200,
        type: "Travel cost",
        details: "JB1003"
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

