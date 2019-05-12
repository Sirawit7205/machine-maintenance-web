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
        <v-data-table :headers="vacLeftHeaders" :items="vacLeftItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.position}}</td>
            <td class="text-xs-center">{{props.item.avgLeft}}</td>
            <td class="text-xs-center">{{props.item.minLeft}}</td>
            <td class="text-xs-center">{{props.item.maxLeft}}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
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
    staffItems: [
      {
        staffName: "Francis Jones",
        position: "Technician",
        vacationLeft: "21",
        vacationTotal: "30"
      },
      {
        staffName: "Sam Molina",
        position: "Technician",
        vacationLeft: "16",
        vacationTotal: "30"
      },
      {
        staffName: "Martin Jennings",
        position: "Supervisor",
        vacationLeft: "34",
        vacationTotal: "40"
      },
      {
        staffName: "Randolph Rivera",
        position: "Supervisor",
        vacationLeft: "5",
        vacationTotal: "40"
      },
      {
        staffName: "Cheryl Odaniel",
        position: "Manager",
        vacationLeft: "21",
        vacationTotal: "45"
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
    vacGivenItems: [
      {
        position: "Technician",
        avgGiven: "30",
        minGiven: "30",
        maxGiven: "30"
      },
      {
        position: "Supervisor",
        avgGiven: "40",
        minGiven: "30",
        maxGiven: "45"
      },
      {
        position: "Manager",
        avgGiven: "40",
        minGiven: "30",
        maxGiven: "60"
      }
    ],
    vacLeftHeaders: [
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
    vacLeftItems: [
      {
        position: "Technician",
        avgLeft: "24",
        minLeft: "11",
        maxLeft: "30"
      },
      {
        position: "Supervisor",
        avgLeft: "30",
        minLeft: "20",
        maxLeft: "36"
      },
      {
        position: "Manager",
        avgLeft: "32",
        minLeft: "16",
        maxLeft: "41"
      }
    ]
  })
};
</script>