<template>
  <div class="flex_container">
    <div>
      <canvas id="barchart"></canvas>
    </div>
  </div>
</template>

<style scoped>
.flex_container {
  display: flex;
  align-content: center;
  justify-content: center;
  background-color: #ffffff;
  width: 500px;
  height: 300px;
}
.flex_container div {
  width: 500px;
  height: 300px;
}
</style>

<script>
export default {
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
  }),

  props: {
    chartData: null
  },

  mounted() {
    this.generateChart(this.chartData);
  },

  methods: {
    generateChart(chartData) {
      var ctx = document.getElementById("barchart");
      new Chart(ctx, {
        type: "bar",
        data: chartData,
        options: this.options
      });
    }
  }
};
</script>
