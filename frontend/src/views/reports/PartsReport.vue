<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex xs12 md6>
        <div class="headline mb-1">Parts List</div>
        <v-data-table :headers="partHeaders" :items="partItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.partname}}</td>
            <td class="text-xs-center">{{props.item.usefor}}</td>
            <td class="text-xs-cetner">{{props.item.instock}}</td>
            <td class="text-xs-center">{{props.item.useinmonth}}</td>
            <td class="text-xs-center">{{props.item.costperunit}}</td>
          </template>
        </v-data-table>
      </v-flex>
      <v-flex xs12 md6>
        <div class="headline mb-1">Nearly Run Out Parts</div>
        <v-data-table :headers="runoutHeaders" :items="runoutItems" class="elevation-1">
          <template v-slot:no-data>
            <v-alert :value="true" type="warning">No data available</v-alert>
          </template>
          <template v-slot:items="props">
            <td class="text-xs-center">{{props.item.partname2}}</td>
            <td class="text-xs-center">{{props.item.usefor2}}</td>
            <td class="text-xs-cetner">{{props.item.instock2}}</td>
            <td class="text-xs-center">{{props.item.useinmonth2}}</td>
            <td class="text-xs-center">{{props.item.costperunit2}}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    partHeaders: [
      {
        text: "Part Name",
        value: "partname",
        align: "center"
      },
      {
        text: "Use For",
        value: "usefor",
        align: "center"
      },
      {
        text: "Amount In Stock",
        value: "instock",
        align: "center"
      },
      {
        text: "Used This Month",
        value: "useinmonth",
        align: "center"
      },
      {
        text: "Cost Per Unit(Baht)",
        value: "costperunit",
        align: "center"
      }
    ],
    partItems: [
      {
        partname: "Belt-PPU-5",
        usefor: "Boiler-THD090",
        instock: "356",
        useinmonth: "14",
        costperunit: "500"
      },
      {
        partname: "Ball Bearings-SYX-88",
        usefor: "Motor-KSH5",
        instock: "312",
        useinmonth: "23",
        costperunit: "1000"
      },
      {
        partname: "Control Arm-CC-998",
        usefor: "Pelletizer",
        instock: "30",
        useinmonth: "10",
        costperunit: "20000"
      }
    ],
    runoutHeaders: [
      {
        text: "Part Name",
        value: "partname2",
        align: "center"
      },
      {
        text: "Use For",
        value: "usefor2",
        align: "center"
      },
      {
        text: "Amount In Stock",
        value: "instock2",
        align: "center"
      },
      {
        text: "Used This Month",
        value: "useinmonth2",
        align: "center"
      },
      {
        text: "Cost Per Unit(Baht)",
        value: "costperunit2",
        align: "center"
      }
    ],
    runoutItems: [
      {
        partname2: "Wormgear-GG008",
        usefor2: "Mother-KSH5",
        instock2: "8",
        useinmonth2: "25",
        costperunit2: "200"
      },
      {
        partname2: "Pressure Tube-CP709",
        usefor2: "Boiler-THD090",
        instock2: "9",
        useinmonth2: "15",
        costperunit2: "5000"
      },
      {
        partname2: "Sensor-SFP019",
        usefor2: "Boiler-THD090",
        instock2: "12",
        useinmonth2: "50",
        costperunit2: "3000"
      }
    ]
  })
};
</script>
