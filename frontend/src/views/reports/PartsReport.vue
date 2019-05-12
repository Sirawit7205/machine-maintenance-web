<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs12 md12>
        <div class="headline mb-1">Parts List</div>
        <v-data-table :headers="partHeaders" :items="partItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.partName}}</td>
            <td class="text-xs-center">{{props.item.compatMachine}}</td>
            <td class="text-xs-center">{{props.item.stockAmount}}</td>
            <td class="text-xs-center">{{props.item.usedAmount}}</td>
            <td class="text-xs-center">{{props.item.price}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs12 md12>
        <div class="headline mb-1">Nearly Run Out Parts</div>
        <v-data-table :headers="runoutHeaders" :items="partItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.partName}}</td>
            <td class="text-xs-center">{{props.item.compatMachine}}</td>
            <td class="text-xs-center">{{props.item.stockAmount}}</td>
            <td class="text-xs-center">{{props.item.usedAmount}}</td>
            <td class="text-xs-center">{{props.item.price}}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    partHeaders: [
      {
        text: "Part Name",
        value: "partName",
        align: "center"
      },
      {
        text: "Use For",
        value: "compatMachine",
        align: "center"
      },
      {
        text: "Amount In Stock",
        value: "stockAmount",
        align: "center"
      },
      {
        text: "Used This Month",
        value: "usedAmount",
        align: "center"
      },
      {
        text: "Cost Per Unit(Baht)",
        value: "price",
        align: "center"
      }
    ],
    partItems: [
      {
        partName: "Belt-PPU-5",
        compatMachine: "Boiler-THD090",
        stockAmount: "356",
        usedAmount: "14",
        price: "500"
      },
      {
        partName: "Ball Bearings-SYX-88",
        compatMachine: "Motor-KSH5",
        stockAmount: "312",
        usedAmount: "23",
        price: "1000"
      },
      {
        partName: "Control Arm-CC-998",
        compatMachine: "Pelletizer",
        stockAmount: "30",
        usedAmount: "10",
        price: "20000"
      }
    ],
    runoutHeaders: [
      {
        text: "Part Name",
        value: "partname",
        align: "center"
      },
      {
        text: "Use For",
        value: "compatMachine",
        align: "center"
      },
      {
        text: "Amount In Stock",
        value: "stockAmount",
        align: "center"
      },
      {
        text: "Used This Month",
        value: "usedAmount",
        align: "center"
      },
      {
        text: "Cost Per Unit (Baht)",
        value: "price",
        align: "center"
      }
    ]
  })
};
</script>
