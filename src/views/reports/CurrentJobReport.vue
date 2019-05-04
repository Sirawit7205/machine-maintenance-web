<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg12 sm12>
        <div class="headline mb-1">Current resource status</div>
        <v-data-table
          :headers="statusHeaders"
          :items="statusItems"
          hide-actions
          class="elevation-1"
        >
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{ props.item.avgPriority }}</td>
            <td class="text-xs-center">{{ props.item.stressScore }}</td>
            <td class="text-xs-center">{{ props.item.assignedTech.toLocaleString() }}</td>
            <td class="text-xs-center">{{ props.item.availTech.toLocaleString() }}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex lg12 sm12>
        <div class="headline mb-1">Current open jobs</div>
        <v-data-table :headers="jobHeaders" :items="jobItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{ props.item.machine }}</td>
            <td class="text-xs-center">{{ props.item.status }}</td>
            <td class="text-xs-center">{{ props.item.severity }}</td>
            <td class="text-xs-center">{{ props.item.priority }}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    jobHeaders: [
      {
        text: "Machine",
        value: "machine",
        align: "center"
      },
      {
        text: "Status",
        value: "status",
        align: "center"
      },
      {
        text: "Severity",
        value: "severity",
        align: "center"
      },
      {
        text: "Priority",
        value: "priority",
        align: "center"
      }
    ],
    statusHeaders: [
      {
        text: "Average priority",
        sortable: false,
        value: "avgPriority",
        align: "center"
      },
      {
        text: "Stress score",
        sortable: false,
        value: "stressScore",
        align: "center"
      },
      {
        text: "Assigned Technicians",
        sortable: false,
        value: "assignedTech",
        align: "center"
      },
      {
        text: "Available Technicians",
        sortable: false,
        value: "availTech",
        align: "center"
      }
    ],
    jobItems: [
      {
        machine: "MC1001",
        status: "Waiting for repair",
        severity: "Medium",
        priority: "Medium"
      }
    ],
    statusItems: [
      {
        avgPriority: 2.5,
        stressScore: 3.1,
        assignedTech: 115,
        availTech: 50
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

