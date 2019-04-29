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
    <div class="flex_container">
      <div>
        <canvas id="piechart"></canvas>
      </div>
    </div>
  </v-menu>
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
    pieChartMenu: false,

    chartOptions: {
      cutoutPercentage: 0,
      backgroundColor: "rgba(255, 255, 255, 1)"
    }
  }),

  props: {
    label: String,
    chartData: null
  },

  mounted() {
    this.generateChart(this.chartData);
  },

  methods: {
    generateChart(chartData) {
      var ctx = document.getElementById("piechart");
      new Chart(ctx, {
        type: "pie",
        data: chartData,
        options: this.chartOptions
      });
      this.pieChartMenu = false;
    }
  }
};
</script>
