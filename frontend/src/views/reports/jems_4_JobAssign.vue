<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs9 md6>
        <div class="headline mb-1">Current Job Assignments</div>
        <v-data-table :headers="currentjobHeaders" :items="currentjobItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.Openjobs}}</td>
            <td class="text-xs-center">{{props.item.Unjobs}}</td>
            <td class="text-xs-center">{{props.item.Asjobs}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs9 md6>
        <div class="headline mb-1">Job Assign Per Day</div>
        <v-data-table :headers="jobperdayHeaders" :item="jobperdayItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.avgTech}}</td>
            <td class="text-xs-center">{{props.item.maxTech}}</td>
            <td class="text-xs-center">{{props.item.minTech}}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    currentjobHeaders: [
      {
        text: "Open Job",
        value: "Openjobs",
        align: "center"
      },
      {
        text: "Unassigned Job",
        value: "Unjobs",
        align: "center"
      },
      {
        text: "Assigned Job",
        value: "Asjobs",
        align: "center"
      }
    ],
    currentjobItems: [
      {
        Openjobs: "131",
        Unjobs: "17",
        Asjobs: "114"
      },
      {
        Openjobs: "",
        Unjobs: "",
        Asjobs: ""
      }
    ],
    jobperdayHeaders: [
      {
        text: "Average per Technician",
        value: "avgTech",
        align: "center"
      },
      {
        text: "Max per Technician",
        value: "maxTech",
        align: "center"
      },
      {
        text: "Min per Technician",
        value: "minTech",
        align: "center"
      }
    ],
    jobperdayItems: [
      {
        avgTech: "1.6",
        maxTech: "4",
        minTech: "1"
      }
    ]
  })
};
</script>
