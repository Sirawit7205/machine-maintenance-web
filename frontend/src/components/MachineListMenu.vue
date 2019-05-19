<template>
  <v-menu
    v-model="machinelistmenu"
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
    <div class="machinelistmenu">
      <ul id="machineList">
        <li v-for="item in machineList" :key="item.machineId">
          {{ item.machineType }} {{ item.modelNumber }} - {{ item.serviceType }}
        </li>
      </ul>
    </div>
  </v-menu>
</template>

<style scoped>
.machinelistmenu {
  background-color: #ffffff;
  max-width: 500px;
  border: white solid 10px;
}
.machinelistmenu div {
  width: 500px;
}
</style>

<script>
import axios from "axios";

export default {
  props: {
    customerId: null
  },

  data: () => ({
    machinelistmenu: false,

    machineList: []
  }),

  methods: {
    async query() {
      let machine = await axios.get("//localhost:80/MachineMaintenance/public/api/machine/listByCustomer/"+this.customerId, {
      });

      this.machineList = machine.data;
    }
  }
};
</script>
