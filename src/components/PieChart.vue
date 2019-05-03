<template>
  <div class="piechart">
    <pie-chart :chartData="chartData"/>
  </div>
</template>

<style scoped>
.piechart {
  background-color: white;
  max-width: 400px;
  margin: 30px auto;
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
  }
};
</script>

