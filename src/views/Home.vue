<template>
  <div id="home">
    <HelloWorld/>
    <v-btn to="/login">Login</v-btn>
    <v-btn to="/staff">Add/Edit staff</v-btn>
    <pie-chart-menu :chartData="chartD"/>
    <pie-chart-menu :chartData="chartD2"/>
    <pie-chart :chartData="chartD"/>
    <pie-chart :chartData="chartD2"/>
    <bar-chart :chartData="chartD"/>
    <bar-chart :chartData="chartD2"/>
  </div>
</template>

<script>
import HelloWorld from "../components/HelloWorld";
import PieChart from "../components/PieChart.vue";
import PieChartMenu from "../components/PieChartMenu.vue";
import BarChart from "../components/BarChart.vue";

export default {
  components: {
    HelloWorld,
    PieChart,
    PieChartMenu,
    BarChart
  },
  data: () => ({
    chartD: {
      datasets: [
        {
          data: [124, 85, 116],
          backgroundColor: ["#2a43b2", "#4c9c30", "#583aa8"]
        }
      ],

      labels: ["Pump", "Boiler", "Other"]
    },
    chartD2: {
      datasets: [
        {
          data: [1, 8, 11],
          backgroundColor: ["#2a43b2", "#4c9c30", "#583aa8"]
        }
      ],

      labels: ["Pump", "Boiler", "Other"]
    }
  })
};
</script>
