<template>
    <v-card width="700">
      <Bar
    class="pa-4"
    id="my-chart-id"
    :options="chartOptions"
    :data="chartData"
  />
    </v-card>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
export default {
  name: 'BarChart',
  components: { Bar },
  data() {
    return {
      chartData: {
        labels: [ 'January', 'February', 'March' ],
        datasets:[{
          label: 'Data One',
          backgroundColor: '#f87979',
          data: [40, 20, 12]
        }]
      },
      chartOptions: {
        responsive: true
      }
    }
  }
}
</script>
