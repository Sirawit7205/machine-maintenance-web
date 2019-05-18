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
              <pie-chart-menu :chartData="props.item.avgContractType"/>
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
            <td class="text-xs-center">{{ props.item.startDate }}</td>
            <td class="text-xs-center">{{ props.item.endDate }}</td>
            <td class="text-xs-center">{{ props.item.price.toLocaleString() }}</td>
            <td class="text-xs-center">
              <contract-menu :contractId="props.item.contractId"/>
            </td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from "axios";
import PieChartMenu from "../../components/PieChartMenu.vue";
import ContractMenu from "../../components/ContractMenu.vue";

export default {
  components: {
    PieChartMenu,
    ContractMenu
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
        text: "Start Date",
        value: "startDate",
        align: "center"
      },
      {
        text: "End Date",
        value: "endDate",
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
    summaryItems: [],
    listItems: []
  }),

  created: async function() {
  let sumData = await axios.get("//localhost:80/MachineMaintenance/public/api/contract/summary", {
  });
  let conList = await axios.get("//localhost:80/MachineMaintenance/public/api/contract/list", {
  });

  this.summaryItems = sumData.data;
  this.listItems = conList.data;
  }
};
</script>

