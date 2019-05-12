<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs12 md12>
        <div class="headline mb-1">Machine list</div>
        <v-data-table :headers="machHeaders" :items="machItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.machineId}}</td>
            <td class="text-xs-center">{{props.item.customerMachineId}}</td>
            <td class="text-xs-center">{{props.item.machineName}}</td>
            <td class="text-xs-center">{{props.item.totalBreakdown}}</td>
            <td class="text-xs-center">{{props.item.lastBreakReason}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs12 md12>
        <v-data-table :headers="mach2Headers" :items="machItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.machineId}}</td>
            <td class="text-xs-center">{{props.item.avgDowntime}}</td>
            <td class="text-xs-center">{{props.item.severity}}</td>
            <td class="text-xs-center">{{props.item.lastCheck}}</td>
            <td class="text-xs-center">{{props.item.viewLog}}</td>
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
        value: "machineId",
        align: "center"
      },
      {
        text: "Customer Machine ID",
        value: "customerMachineId",
        align: "center"
      },
      {
        text: "Machine",
        value: "machineName",
        align: "center"
      },
      {
        text: "Total Breakdown Last Year",
        value: "totalBreakdown",
        align: "center"
      },
      {
        text: "Last Breakdown Reason",
        value: "lastBreakReason",
        align: "center"
      }
    ],
    machItems: [
      {
        machineId: "MC0251",
        customerMachineId: "CDG-1",
        machineName: "Boiler THD090",
        totalBreakdown: "5",
        lastBreakReason: "Temperature sensor#2 error",
        avgDowntime: "1.5",
        severity: "4",
        lastCheck: "17/2/2018",
        viewLog: "View"
      },
      {
        machineId: "MC0252",
        customerMachineId: "CDG-2",
        machineName: "Boiler THD090",
        totalBreakdown: "2",
        lastBreakReason: "Heater #1 error",
        avgDowntime: "1.0",
        severity: "1",
        lastCheck: "11/5/2018",
        viewLog: "View"
      }
    ],
    mach2Headers: [
      {
        text: "Machine ID",
        value: "machineId",
        align: "center"
      },
      {
        text: " Average Downtime Per Month (hours)",
        value: "avgDowntime",
        align: "center"
      },
      {
        text: "Highest Severity",
        value: "severity",
        align: "center"
      },
      {
        text: "Last Check",
        value: "lastCheck",
        align: "center"
      },
      {
        text: "View Log",
        value: "viewLog",
        align: "center"
      }
    ]
  })
};
</script>