<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs12 md12>
        <div class="headline mb-1">Log Generated</div>
        <v-data-table :headers="logHeaders" :items="logItems" hide-actions class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.total}}</td>
            <td class="text-xs-center">{{props.item.info}}</td>
            <td class="text-xs-center">{{props.item.error}}</td>
            <td class="text-xs-center">{{props.item.maintenance}}</td>
            <td class="text-xs-center">{{props.item.repair}}</td>
            <td class="text-xs-center">{{props.item.other}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs9 md6>
        <div class="headline mb-1">Top Log Per Machine Type</div>
        <v-data-table :headers="topMachineHeaders" :items="topMachineItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.machineType}}</td>
            <td class="text-xs-center">{{props.item.logCount}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs9 md6>
        <div class="headline mb-1">Top Log Per Customer</div>
        <v-data-table :headers="topCustomerHeaders" :items="topCustomerItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.customerName}}</td>
            <td class="text-xs-center">{{props.item.logCount}}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>
                                        
<script>
import axios from "axios";

export default {
  data: () => ({
    logHeaders: [
      {
        text: "This month",
        sortable: false,
        value: "total",
        align: "center"
      },
      {
        text: "Info",
        sortable: false,
        value: "info",
        align: "center"
      },
      {
        text: "Error",
        sortable: false,
        value: "error",
        align: "center"
      },
      {
        text: "Maintenance",
        sortable: false,
        value: "maintenance",
        align: "center"
      },
      {
        text: "Repair",
        sortable: false,
        value: "repair",
        align: "center"
      },
      {
        text: "Other",
        sortable: false,
        value: "other",
        align: "center"
      }
    ],
    logItems: [
      {
        total: "409",
        info: "23",
        error: "127",
        maintenance: "148",
        repair: "167",
        other: "44"
      }
    ],
    topMachineHeaders: [
      {
        text: "Machine Type",
        value: "machineType",
        align: "center"
      },
      {
        text: "Log Generated",
        value: "logCount",
        align: "center"
      }
    ],
    topMachineItems: [
      {
        machineType: "Boiler",
        logCount: "45"
      },
      {
        machineType: "Motor",
        logCount: "37"
      },
      {
        machineType: "Packer",
        logCount: "27"
      },
      {
        machineType: "Burner",
        logCount: "15"
      }
    ],
    topCustomerHeaders: [
      {
        text: "Customer",
        value: "customerName",
        align: "center"
      },
      {
        text: "Log Generated",
        value: "logCount",
        align: "center"
      }
    ],
    topCustomerItems: [
      {
        customerName: "Fority Inc",
        logCount: "67"
      },
      {
        customerName: "Quilium Eng.",
        logCount: "31"
      },
      {
        customerName: "KMUTT",
        logCount: "23"
      },
      {
        customerName: "Syend Inc.",
        logCount: "22"
      }
    ]
  }),

  created: async function() {
  let byLogType = await axios.get("//localhost:80/MachineMaintenance/public/api/log/byLogType", {
  });
  let byMachineType = await axios.get("//localhost:80/MachineMaintenance/public/api/log/byMachineType", {
  });
  let byCustomer = await axios.get("//localhost:80/MachineMaintenance/public/api/log/byCustomer", {
  });

  this.logItems = byLogType.data;
  this.topMachineItems = byMachineType.data;
  this.topCustomerItems = byCustomer.data;
  }
};
</script>