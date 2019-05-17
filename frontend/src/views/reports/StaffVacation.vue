<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs9 md9>
        <div class="headline mb-1">Staff List</div>
        <v-data-table :headers="staffHeaders" :items="staffItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.staffName}}</td>
            <td class="text-xs-center">{{props.item.position}}</td>
            <td class="text-xs-center">{{props.item.status}}</td>
            <td class="text-xs-center">{{props.item.vacationTotal}}</td>
            <td class="text-xs-center">{{props.item.vacationLeft}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs9 md9>
        <div class="headline mb-1">Vacation Days Given</div>
        <v-data-table :headers="vacGivenHeaders" :items="vacGivenItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.position}}</td>
            <td class="text-xs-center">{{props.item.avgGiven}}</td>
            <td class="text-xs-center">{{props.item.minGiven}}</td>
            <td class="text-xs-center">{{props.item.maxGiven}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs9 md9>
        <div class="headline mb-1">Vacation Days Used</div>
        <v-data-table :headers="vacUsedHeaders" :items="vacUsedItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.position}}</td>
            <td class="text-xs-center">{{props.item.avgUsed}}</td>
            <td class="text-xs-center">{{props.item.minUsed}}</td>
            <td class="text-xs-center">{{props.item.maxUsed}}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    staffHeaders: [
      {
        text: "Staff",
        value: "staffName",
        align: "center"
      },
      {
        text: "Position",
        value: "position",
        align: "center"
      },
      {
        text: "Status",
        value: "status",
        align: "center"
      },
      {
        text: "Vacation Days Given",
        value: "vacationTotal",
        align: "center"
      },
      {
        text: "Vacation Days Left",
        value: "vacationLeft",
        align: "center"
      }
    ],
    vacGivenHeaders: [
      {
        text: "Role",
        value: "role",
        align: "center"
      },
      {
        text: "Avg Vacation Days Given",
        value: "avgGiven",
        align: "center"
      },
      {
        text: "Min Vacation Days Given",
        value: "minGiven",
        align: "center"
      },
      {
        text: "Max Vacation Days Given",
        value: "maxGiven",
        align: "center"
      }
    ],
    vacUsedHeaders: [
      {
        text: "Role",
        value: "role2",
        align: "center"
      },
      {
        text: "Avg Vacation Days Used",
        value: "avgLeft",
        align: "center"
      },
      {
        text: "Min Vacation Days Given",
        value: "minLeft",
        align: "center"
      },

      {
        text: "Max Vacation Days Given",
        value: "maxLeft",
        align: "center"
      }
    ],
    staffItems: [],
    vacGivenItems: [],
    vacUsedItems: []
  }),

  created: async function() {
  let vacationList = await axios.get("//localhost:80/MachineMaintenance/public/api/staff/vacationList", {
  });
  let vacationGiven = await axios.get("//localhost:80/MachineMaintenance/public/api/staff/vacationGiven", {
  });
  let vacationUsed = await axios.get("//localhost:80/MachineMaintenance/public/api/staff/vacationUsed", {
  });

  this.staffItems = vacationList.data;
  this.vacGivenItems = vacationGiven.data;
  this.vacUsedItems = vacationUsed.data;
  }
};
</script>