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
            <td class="text-xs-center">{{props.item.partsName}}</td>
            <td class="text-xs-center">
              <parts-menu :partsId="props.item.partsId"/>
            </td>
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
            <td class="text-xs-center">{{props.item.partsName}}</td>
            <td class="text-xs-center">
              <parts-menu :partsId="props.item.partsId"/>
            </td>
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
import axios from "axios";
import PartsMenu from "../../components/PartsMenu.vue";

export default {
  components: {
    PartsMenu
  },

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
    ],
    partItems: []
  }),

  created: async function() {
  let partList = await axios.get("//localhost:80/MachineMaintenance/public/api/parts/list", {
  });

  this.partItems = partList.data;
  }
};
</script>
