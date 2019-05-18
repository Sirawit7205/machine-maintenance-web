<template>
  <v-menu
    v-model="contractmenu"
    :close-on-content-click="false"
    :nudge-bottom="10"
    transition="slide-y-transition"
    origin="top center"
    offset-y
    full-width
  >
    <template v-slot:activator="{ on }">
      <v-btn flat v-on="on" @click="query">View</v-btn>
    </template>
    <div class="contractmenu">
      <ul id="machineList">
        <li v-for="item in machineList" :key="item.machineId">
          {{ item.machineId }} - {{ item.machineType }}
        </li>
      </ul>
    </div>
  </v-menu>
</template>

<style scoped>
.contractmenu {
  background-color: #ffffff;
  max-width: 300px;
  border: white solid 10px;
}
.contractmenu div {
  width: 300px;
}
</style>

<script>
import axios from "axios";

export default {
  props: {
    contractId: null
  },

  data: () => ({
    contractmenu: false,

    machineList: []
  }),

  methods: {
    async query() {
      let machine = await axios.get("//localhost:80/MachineMaintenance/public/api/contract/machine/"+this.contractId, {
      });

      this.machineList = machine.data;
    }
  }
};
</script>
