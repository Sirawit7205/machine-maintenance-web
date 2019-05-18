<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg9 sm9>
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
          </template>
        </v-data-table>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Type of income</div>
        <v-card>
          <v-card-text>
            <pie-chart :chartData="incomeChartData"/>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Type of expense</div>
        <v-card>
          <v-card-text>
            <pie-chart :chartData="expenseChartData"/>
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
import axios from "axios";
import PieChart from "../../components/PieChart.vue";

export default {
  components: {
    PieChart
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
    summaryItems: [],
    incomeItems: [],
    expenseItems: [],
    incomeChartData: [],
    expenseChartData: []
  }),
  
  created: async function() {
  let incList = await axios.get("//localhost:80/MachineMaintenance/public/api/transaction/income", {
  });
  let excList = await axios.get("//localhost:80/MachineMaintenance/public/api/transaction/expense", {
  });
  let summaryList = await axios.get("//localhost:80/MachineMaintenance/public/api/transaction/summary", {
  });
  let incChart = await axios.get("//localhost:80/MachineMaintenance/public/api/transaction/incomeChart", {
  });
  let excChart = await axios.get("//localhost:80/MachineMaintenance/public/api/transaction/expenseChart", {
  });

  this.incomeItems = incList.data;
  this.expenseItems = excList.data;
  this.summaryItems = summaryList.data;
  this.incomeChartData = incChart.data;
  this.expenseChartData = excChart.data;
  }
};
</script>

