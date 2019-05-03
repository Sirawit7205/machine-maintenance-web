<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg12 sm12>
        <div class="headline mb-1">Contract Summary</div>
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
            <td class="text-xs-center">{{ props.item.total.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.avgContractCust.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.avgContractPrice.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.avgContractDur.toLocaleString() }}</td>
            <td class="text-xs-center">
              <pie-chart-menu :chartData="chartD"/>
            </td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex lg12 sm12>
        <div class="headline mb-1">Contract List</div>
        <v-data-table :headers="listHeaders" :items="listItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{ props.item.contractId }}</td>
            <td class="text-xs-center">{{ props.item.customer }}</td>
            <td class="text-xs-center">{{ props.item.startEndDate }}</td>
            <td class="text-xs-center">{{ props.item.price.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.machines }}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import PieChartMenu from "../../components/PieChartMenu.vue";

export default {
  components: {
    PieChartMenu
  },

  data: () => ({
    summaryHeaders: [
      {
        text: "Total Contracts",
        sortable: false,
        value: "total",
        align: "center"
      },
      {
        text: "Avg contracts per customer",
        sortable: false,
        value: "avgContractCust",
        align: "center"
      },
      {
        text: "Avg contract price (Baht)",
        sortable: false,
        value: "avgContractPrice",
        align: "center"
      },
      {
        text: "Avg contract duration (Months)",
        sortable: false,
        value: "avgContractDur",
        align: "center"
      },
      {
        text: "Avg contract price per machine type",
        sortable: false,
        value: "avgPricePerType",
        align: "center"
      }
    ],
    listHeaders: [
      {
        text: "Contract ID",
        value: "contractId",
        align: "center"
      },
      {
        text: "Customer",
        value: "customer",
        align: "center"
      },
      {
        text: "Start - End Date",
        value: "startEndDate",
        align: "center"
      },
      {
        text: "Contract Price",
        value: "price",
        align: "center"
      },
      {
        text: "Machines in this contract",
        value: "machines",
        align: "center"
      }
    ],
    summaryItems: [
      {
        total: 1511,
        avgContractCust: 52,
        avgContractPrice: 500000,
        avgContractDur: 15,
        AvgContractType: null
      }
    ],
    listItems: [
      {
        contractId: "CN1001",
        customer: "ABC",
        startEndDate: "01/01/2018 - 01/01/2019",
        price: "100000",
        machines: "MC1001, MC1002, MC1003"
      },
      {
        contractId: "CN1002",
        customer: "BCD",
        startEndDate: "01/01/2018 - 01/01/2019",
        price: "200000",
        machines: "MC1004, MC1005, MC1006"
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

