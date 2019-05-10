<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs12 md6>
        <div class="headline mb-1">Job List- {{workerName}}</div>
        <v-data-table :headers="joblistHeaders" :items="joblistItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.machine}}</td>
            <td class="text-xs-center">{{props.item.locaiton}}</td>
            <td class="text-xs-cetner">{{props.item.priority}}</td>
            <td class="text-xs-cetner">{{props.item.severity}}</td>
            <td class="text-xs-cetner">{{props.item.details}}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    workerName: "xxxxxx",
    joblistHeaders: [
      {
        text: "Machine",
        value: "machine",
        align: "center"
      },
      {
        text: "Location",
        value: "location",
        align: "center"
      },
      {
        text: "Priority",
        value: "priority",
        align: "center"
      },
      {
        text: "Severity",
        value: "severity",
        align: "center"
      },
      {
        text: "Details",
        value: "details",
        align: "center"
      }
    ],
    joblistItems: [
      {
        machine: "MC0017-Motor EDSX320",
        location: "KMUTT",
        priority: "4",
        severity: "2",
        details: "High pitch noise on start. Low torque"
      },
      {
        machine: "MC0255-Boiler THD050",
        location: "Syned Inc.",
        priority: "3",
        severity: "3",
        details: "No heat."
      },
      {
        machine: "MC0252-Boiler THD090",
        location: "Syned Inc.",
        priority: "3",
        severity: "2",
        details: "No heat. Error code E08"
      },
      {
        machine: "MC0019-Motor BSDX-118",
        location: "Quilium Engineering",
        priority: "1",
        severity: "1",
        details: "Monthly maintenance"
      },
      {
        machine: "MC0020-Motor BSDX-118",
        location: "Quilium Engineering",
        priority: "1",
        severity: "1",
        details: "Monthly maintenance"
      }
    ]
  })
};
</script>