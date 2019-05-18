<template>
  <v-menu
    v-model="machinelogmenu"
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
    <div class="machinelogmenu">
      <ul id="machineList">
        <li v-for="item in logList" :key="item.logId">
          {{ item.logType }} - {{ item.details }}
        </li>
      </ul>
    </div>
  </v-menu>
</template>

<style scoped>
.machinelogmenu {
  background-color: #ffffff;
  max-width: 300px;
  border: white solid 10px;
}
.machinelogmenu div {
  width: 300px;
}
</style>

<script>
import axios from "axios";

export default {
  props: {
    machineId: null
  },

  data: () => ({
    machinelogmenu: false,

    logList: []
  }),

  methods: {
    async query() {
      let machineLog = await axios.get("//localhost:80/MachineMaintenance/public/api/log/lastTen/"+this.machineId, {
      });

      this.logList = machineLog.data;
    }
  }
};
</script>
