<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg9 sm12>
        <div class="headline mb-1">Most valued customer</div>
        <v-data-table :headers="valueHeaders" :items="valueItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{ props.item.customer }}</td>
            <td class="text-xs-center">{{ props.item.contractCount.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.totalContractValue.toLocaleString() }}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex lg9 sm12>
        <div class="headline mb-1">Nearly expired contracts</div>
        <v-data-table :headers="expiredHeaders" :items="expiredItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{ props.item.contractId }}</td>
            <td class="text-xs-center">{{ props.item.customer }}</td>
            <td class="text-xs-center">{{ props.item.contractValue.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.daysLeft }}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    valueHeaders: [
      {
        text: "Customer",
        value: "customer",
        align: "center"
      },
      {
        text: "Contracts Signed",
        value: "contractCount",
        align: "center"
      },
      {
        text: "Total contract value (Baht)",
        value: "totalContractValue",
        align: "center"
      }
    ],
    expiredHeaders: [
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
        text: "Contract value (Baht)",
        value: "contractValue",
        align: "center"
      },
      {
        text: "Days left",
        value: "daysLeft",
        align: "center"
      }
    ],
    valueItems: [
      {
        customer: "ABCD",
        contractCount: 33,
        totalContractValue: 1000000
      },
      {
        customer: "EFG",
        contractCount: 15,
        totalContractValue: 5000000
      }
    ],
    expiredItems: [
      {
        contractId: "CN1008",
        customer: "ABCD",
        contractValue: 100000,
        daysLeft: 10
      },
      {
        contractId: "CN1009",
        customer: "EFG",
        contractValue: 50000,
        daysLeft: 18
      }
    ]
  })
};
</script>

