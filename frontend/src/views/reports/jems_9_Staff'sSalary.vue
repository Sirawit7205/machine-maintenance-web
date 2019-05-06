<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs9 md3>
        <div class="headline mb-1">Staff List</div>
        <v-data-table :headers="staffHeaders" :items="staffItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.staff}}</td>
            <td class="text-xs-center">{{props.item.position}}</td>
            <td class="text-xs-cetner">{{props.item.salary}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs12 md4>
        <div class="headline mb-1">Role Salary</div>
        <v-data-table :headers="roleHeaders" :items="roleItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.role}}</td>
            <td class="text-xs-center">{{props.item.avgSalary}}</td>
            <td class="text-xs-cetner">{{props.item.minSalary}}</td>
            <td class="text-xs-center">{{props.item.maxSalary}}</td>
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
        text: "Salary(Baht)",
        value: "salary",
        align: "center"
      }
    ],
    staffItems: [
      {
        staff: "Francis Jones",
        position: "Technician",
        salary: "22000"
      },
      {
        staff: "Sam Molina",
        position: "Technician",
        salary: "23000"
      },
      {
        staff: "Martin Jennings",
        position: "Supervisor",
        salary: "35000"
      }
    ],
    roleHeaders: [
      {
        text: "Role",
        value: "role",
        align: "center"
      },
      {
        text: "Avg Salary(Baht)",
        value: "avgSalary",
        align: "center"
      },
      {
        text: "Min Salary(Baht)",
        value: "minSalary",
        align: "center"
      },
      {
        text: "Max Salary(Baht)",
        value: "maxSalary",
        align: "center"
      }
    ],
    roleItems: [
      {
        role: "Technician",
        avgSalary: "25000",
        minSalary: "22000",
        maxSalary: "28000"
      },
      {
        role: "Supervisor",
        avgSalary: "34000",
        minSalary: "32000",
        maxSalary: "35000"
      },
      {
        role: "Manager",
        avgSalary: "44800",
        minSalary: "41500",
        maxSalary: "46000"
      }
    ]
  })
};
</script>