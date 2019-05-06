<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs12 md3>
        <div class="headline mb-1">Machine list</div>
        <v-data-table :headers="machHeaders" :items="machItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.machID}}</td>
            <td class="text-xs-center">{{props.item.cusID}}</td>
            <td class="text-xs-cetner">{{props.item.mach}}</td>
            <td class="text-xs-cetner">{{props.item.totalbreakdown}}</td>
            <td class="text-xs-cetner">{{props.item.breakdownreason}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs6 md2>
        <v-data-table :headers="mach2Headers" :items="mach2Items" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.machID2}}</td>
            <td class="text-xs-center">{{props.item.avgDowntime}}</td>
            <td class="text-xs-center">{{props.item.hiavgSev}}</td>
            <td class="text-xs-center">{{props.item.lastcheck}}</td>
            <td class="text-xs-center">{{props.item.viewlog}}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    machHeaders: [
      {
        text: "Machine ID",
        value: "machID",
        align: "center"
      },
      {
        text: "Customer Machine ID",
        value: "cusID",
        align: "center"
      },
      {
        text: "Machine",
        value: "mach",
        align: "center"
      },
      {
        text: "Total Breakdown Last Year",
        value: "totalbreakdown",
        align: "center"
      },
      {
        text: "Last Breakdown Reason",
        value: "breakdownreason",
        align: "center"
      }
    ],
    machItems: [
      {
        machID: "MC0251",
        cusID: "CDG-1",
        mach: "Boiler THD090",
        totalbreakdown: "5",
        breakdownreason: "Temperature sensor#2 error"
      },
      {
        machID: "MC0252",
        cusID: "CDG-2",
        mach: "Boiler THD090",
        totalbreakdown: "2",
        breakdownreason: "Heater #1 error"
      }
    ],
    mach2Headers: [
      {
        text: "Machine ID",
        value: "machID2",
        align: "center"
      },
      {
        text: " Average Downtime Per Month(hrs)",
        value: "avgDowntime",
        align: "center"
      },
      {
        text: "Highest/Average Problem Severity",
        value: "hiavgSev",
        align: "center"
      },
      {
        text: "Last Check",
        value: "lastcheck",
        align: "center"
      },
      {
        text: "View Log",
        value: "viewlog",
        align: "center"
      }
    ],
    roleItems: [
      {
        machID2: "MC0251",
        avgDowntime: "1.5",
        hiavgSev: "3/1.1",
        lastcheck: "15/01/2019 (1 month ago)",
        viewlog: "View"
      },
      {
        machID2: "MC0252",
        avgDowntime: "2.5",
        hiavgSev: "5/2.5",
        lastcheck: "15/12/2018",
        viewlog: "View"
      }
    ]
  })
};
</script>