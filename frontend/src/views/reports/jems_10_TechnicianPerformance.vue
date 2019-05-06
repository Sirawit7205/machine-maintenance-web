<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs12 md4>
        <div class="headline mb-1">Technician List</div>
        <v-data-table :headers="techHeaders" :items="techItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.staff}}</td>
            <td class="text-xs-center">{{props.item.exp}}</td>
            <td class="text-xs-cetner">{{props.item.jobdone}}</td>
            <td class="text-xs-cetner">{{props.item.avgtime}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs6 md2>
        <div class="headline mb-1">Current Status</div>
        <v-data-table :headers="roleHeaders" :items="roleItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.totaltech}}</td>
            <td class="text-xs-center">{{props.item.avgexp}}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    techHeaders: [
      {
        text: "Staff",
        value: "staff",
        align: "center"
      },
      {
        text: "Experience",
        value: "exp",
        align: "center"
      },
      {
        text: "Job Done This Month",
        value: "jobdone",
        align: "center"
      },
      {
        text: "Average Time Per Job",
        value: "avgtime",
        align: "center"
      }
    ],
    techItems: [
      {
        staff: "Francis Jones",
        exp: "203",
        jobdone: "21",
        avgtime: "3.6"
      },
      {
        staff: "Sam Molina",
        exp: "196",
        jobdone: "16",
        avgtime: "3.9"
      },
      {
        staff: "Dominic Shumpert",
        exp: "117",
        jobdone: "13",
        avgtime: "4.2"
      }
    ],
    roleHeaders: [
      {
        text: "Total Technician",
        value: "totaltech",
        align: "center"
      },
      {
        text: "Avg Experience",
        value: "avgexp",
        align: "center"
      }
    ],
    roleItems: [
      {
        totaltech: "308",
        avgexp: "214"
      }
    ]
  })
};
</script>