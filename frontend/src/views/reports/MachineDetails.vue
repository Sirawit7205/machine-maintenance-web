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
            <td class="text-xs-center">{{props.item.serialNumber}}</td>
            <td class="text-xs-center">
              {{props.item.machineType}} - {{props.item.modelNumber}}
            </td>
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
            <td class="text-xs-center">
              {{props.item.maxSeverity}} / {{props.item.avgSeverity}}
            </td>
            <td class="text-xs-center">{{props.item.lastCheck}}</td>
            <td class="text-xs-center">
              <machine-log-menu :machineId="props.item.machineId"/>
            </td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from "axios";
import MachineLogMenu from "../../components/MachineLogMenu.vue";

export default {
  components: {
    MachineLogMenu
  },

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
    mach2Headers: [
      {
        text: "Machine ID",
        value: "machineId",
        align: "center"
      },
      {
        text: " Average Downtime (hours)",
        value: "avgDowntime",
        align: "center"
      },
      {
        text: "Max/Avg Severity",
        value: "severity",
        align: "center"
      },
      {
        text: "Last Check",
        value: "lastCheck",
        align: "center"
      },
      {
        text: "Last 10 logs",
        value: "viewLog",
        align: "center"
      }
    ],
    machItems: []
  }),

  created: async function() {
  let machine = await axios.get("//localhost:80/MachineMaintenance/public/api/machine/details", {
  });

  this.machItems = machine.data;
  }
};
</script>