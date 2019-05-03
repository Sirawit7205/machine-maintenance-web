<template>
  <div class="barchart">
    <bar-chart :chartData="chartData" :options="options"/>
  </div>
</template>

<style scoped>
.barchart {
  background-color: white;
  max-width: 400px;
  margin: 30px auto;
}
</style>


<script>
import BarChart from "./BarChartRenderer.js";

export default {
  components: {
    BarChart
  },

  props: {
    chartData: null
  },

  data: () => ({
    options: {
      scales: {
        yAxes: [
          {
            display: true,
            ticks: {
              suggestedMin: 0,
              beginAtZero: true
            }
          }
        ]
      }
    }
  })
};
</script>

