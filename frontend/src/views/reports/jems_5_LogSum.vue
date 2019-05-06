<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs12 md2>
        <div class="headline mb-1">Log Generated</div>
        <v-data-table :headers="logHeaders" :items="logItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.thismonth}}</td>
            <td class="text-xs-center">{{props.item.info}}</td>
            <td class="text-xs-center">{{props.item.error}}</td>
            <td class="text-xs-center">{{props.item.maintenance}}</td>
            <td class="text-xs-center">{{props.item.repiar}}</td>
            <td class="text-xs-center">{{props.item.other}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs4 md3>
        <div class="headline mb-1">Top Log Machine Type</div>
        <v-data-table :headers="topmachineHeaders" :items="topmachineItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.machinetype}}</td>
            <td class="text-xs-center">{{props.item.loggen1}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs4 md3>
        <div class="headline mb-1">Top Log Per Customer</div>
        <v-data-table :headers="topcustomerHeaders" :items="topcustomerItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.customer}}</td>
            <td class="text-xs-center">{{props.item.loggen2}}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>
                                        
<script>
export default {
  data: () => ({
    logHeaders: [
      {
        text: "This month",
        value: "thismonth",
        align: "center"
      },
      {
        text: "Info",
        value: "info",
        align: "center"
      },
      {
        text: "Error",
        value: "error",
        align: "center"
      },
      {
        text: "Maintenance",
        value: "maintenance",
        align: "center"
      },
      {
        text: "Repair",
        value: "repair",
        align: "center"
      },
      {
        text: "Other",
        value: "other",
        align: "center"
      }
    ],
    logItems: [
      {
        thismonth: "409",
        info: "23",
        error: "127",
        maintenance: "148",
        repair: "167",
        other: "44"
      }
    ],
    topmachineHeaders: [
      {
        text: "Machine Type",
        value: "machinetype",
        align: "center"
      },
      {
        text: "Log Generated",
        value: "loggen1",
        align: "center"
      }
    ],
    topmachineItems: [
      {
        machinetype: "Boiler",
        loggen1: "45"
      },
      {
        machinetype: "Motor",
        loggen1: "37"
      },
      {
        machinetype: "Packer",
        loggen1: "27"
      },
      {
        machinetype: "Burner",
        loggen1: "15"
      }
    ],
    topcustomerHeaders: [
      {
        text: "Customer",
        value: "customer",
        align: "center"
      },
      {
        text: "Log Generated",
        value: "loggen2",
        align: "center"
      }
    ],
    topcustomerItems: [
      {
        customer: "Fority Inc",
        loggen2: "67"
      },
      {
        customer: "Quilium Eng.",
        loggen2: "31"
      },
      {
        customer: "KMUTT",
        loggen2: "23"
      },
      {
        customer: "Syend Inc.",
        loggen2: "22"
      }
    ]
  })
};
</script>