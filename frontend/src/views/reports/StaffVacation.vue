<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs12 md4>
        <div class="headline mb-1">Staff List</div>
        <v-data-table :headers="staffHeaders" :items="staffItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.staff}}</td>
            <td class="text-xs-center">{{props.item.position}}</td>
            <td class="text-xs-cetner">{{props.item.vacaUse}}</td>
            <td class="text-xs-cetner">{{props.item.vacaGiv}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs12 md4>
        <div class="headline mb-1">Vacation Days Given</div>
        <v-data-table :headers="vacaGivHeaders" :items="vacaGivItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.role}}</td>
            <td class="text-xs-center">{{props.item.avgvacaGiv}}</td>
            <td class="text-xs-cetner">{{props.item.minvacaGiv}}</td>
            <td class="text-xs-cetner">{{props.item.maxvacaGiv}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs12 md4>
        <div class="headline mb-1">Vacation DAys Used</div>
        <v-data-table :headers="vacaUseHeaders" :items="vacaUseItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.role2}}</td>
            <td class="text-xs-center">{{props.item.avgvacaUse}}</td>
            <td class="text-xs-cetner">{{props.item.minvacaUse}}</td>
            <td class="text-xs-cetner">{{props.item.maxvacaUse}}</td>
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
        value: "staff",
        align: "center"
      },
      {
        text: "Position",
        value: "position",
        align: "center"
      },
      {
        text: "Vacation Days Used",
        value: "vacaUse",
        align: "center"
      },
      {
        text: "Vacation Days Given",
        value: "vacaGiv",
        align: "center"
      }
    ],
    staffItems: [
      {
        staff: "Francis Jones",
        position: "Technician",
        vacaUse: "21",
        vacaGiv: "30"
      },
      {
        staff: "Sam Molina",
        position: "Technician",
        vacaUse: "16",
        vacaGiv: "30"
      },
      {
        staff: "Martin Jennings",
        position: "Supervisor",
        vacaUse: "34",
        vacaGiv: "40"
      },
      {
        staff: "Randolph Rivera",
        position: "Supervisor",
        vacaUse: "5",
        vacaGiv: "40"
      },
      {
        staff: "Cheryl Odaniel",
        position: "Manager",
        vacaUse: "21",
        vacaGiv: "45"
      }
    ],
    vacaGivHeaders: [
      {
        text: "Role",
        value: "role",
        align: "center"
      },
      {
        text: "Avg Vacation Days Given",
        value: "avgvacaGiv",
        align: "center"
      },
      {
        text: "Min Vacation Days Given",
        value: "minvacaGiv",
        align: "center"
      },
      {
        text: "Max Vacation Days Given",
        value: "maxvacaGiv",
        align: "center"
      }
    ],
    vacaGivItems: [
      {
        role: "Technician",
        avgvacaGiv: "30",
        minvacaGiv: "30",
        maxvacaGiv: "30"
      },
      {
        role: "Supervisor",
        avgvacaGiv: "40",
        minvacaGiv: "30",
        maxvacaGiv: "45"
      },
      {
        role: "Manager",
        avgvacaGiv: "40",
        minvacaGiv: "30",
        maxvacaGiv: "60"
      }
    ],
    vacaUseHeaders: [
      {
        text: "Role",
        value: "role2",
        align: "center"
      },
      {
        text: "Avg Vacation Days Used",
        value: "avgvacaUse",
        align: "center"
      },
      {
        text: "Min Vacation Days Given",
        value: "minvacaUse",
        align: "center"
      },

      {
        text: "Max Vacation Days Given",
        value: "maxvacaUse",
        align: "center"
      }
    ],
    vacaUseItems: [
      {
        role2: "Technician",
        avgvacaUse: "24",
        minvacaUse: "11",
        maxvacaUse: "30"
      },
      {
        role2: "Supervisor",
        avgvacaUse: "30",
        minvacaUse: "20",
        maxvacaUse: "36"
      },
      {
        role2: "Manager",
        avgvacaUse: "32",
        minvacaUse: "16",
        maxvacaUse: "41"
      }
    ]
  })
};
</script>