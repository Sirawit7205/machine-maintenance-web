<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs9 md9>
        <div class="headline mb-1">Current Job Assignments</div>
        <v-data-table :headers="currentJobHeaders" :items="currentJobItems" hide-actions class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.openJob}}</td>
            <td class="text-xs-center">{{props.item.unassignedJob}}</td>
            <td class="text-xs-center">{{props.item.assignedJob}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs9 md9>
        <div class="headline mb-1">Job Assignment Per Technician</div>
        <v-data-table :headers="technicianHeaders" :items="technicianItems" hide-actions class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.avgPerTechnician}}</td>
            <td class="text-xs-center">{{props.item.maxPerTechnician}}</td>
            <td class="text-xs-center">{{props.item.minPerTechnician}}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    currentJobHeaders: [
      {
        text: "Open Job",
        sortable: false,
        value: "openJob",
        align: "center"
      },
      {
        text: "Unassigned Job",
        sortable: false,
        value: "unassignedJob",
        align: "center"
      },
      {
        text: "Assigned Job",
        sortable: false,
        value: "assignedJob",
        align: "center"
      }
    ],
    currentJobItems: [
      {
        openJob: "131",
        unassignedJob: "17",
        assignedJob: "114"
      }
    ],
    technicianHeaders: [
      {
        text: "Average per Technician",
        sortable: false,
        value: "avgPerTechnician",
        align: "center"
      },
      {
        text: "Max per Technician",
        sortable: false,
        value: "maxPerTechnician",
        align: "center"
      },
      {
        text: "Min per Technician",
        sortable: false,
        value: "minPerTechnician",
        align: "center"
      }
    ],
    technicianItems: [
      {
        avgPerTechnician: "1.6",
        maxPerTechnician: "4",
        minPerTechnician: "1"
      }
    ]
  })
};
</script>
