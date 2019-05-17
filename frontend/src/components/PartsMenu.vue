<template>
  <v-menu
    v-model="partsmenu"
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
    <div class="partsmenu">
      <ul id="compatList">
        <li v-for="item in compatMachineList" :key="item.machineModel">
          {{ item.machineType }} - {{ item.modelNumber }}
        </li>
      </ul>
    </div>
  </v-menu>
</template>

<style scoped>
.partsmenu {
  background-color: #ffffff;
  max-width: 300px;
  border: white solid 10px;
}
.partsmenu div {
  width: 300px;
}
</style>

<script>
import axios from "axios";

export default {
  props: {
    partsId: null
  },

  data: () => ({
    partsmenu: false,

    compatMachineList: []
  }),

  methods: {
    async query() {
      let compat = await axios.get("//localhost:80/MachineMaintenance/public/api/parts/compat/"+this.partsId, {
      });

      this.compatMachineList = compat.data;
    }
  }
};
</script>
