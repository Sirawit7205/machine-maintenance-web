<template>
  <v-menu
    v-model="pieChartMenu"
    :close-on-content-click="false"
    :nudge-bottom="10"
    transition="slide-y-transition"
    origin="top center"
    offset-y
    full-width
  >
    <template v-slot:activator="{ on }">
      <v-btn flat v-on="on">View chart</v-btn>
    </template>
    <div class="piechartmenu">
      <pie-chart :chartData="chartData"/>
    </div>
  </v-menu>
</template>

<style scoped>
.piechartmenu {
  background-color: #ffffff;
  max-width: 300px;
}
.piechartmenu div {
  width: 300px;
}
</style>

<script>
import PieChart from "./PieChartRenderer.js";

export default {
  components: {
    PieChart
  },

  props: {
    chartData: null
  },

  data: () => ({
    pieChartMenu: false
  })
};
</script>
