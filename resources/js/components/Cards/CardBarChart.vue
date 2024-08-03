<template>
  <div
    class="relative flex flex-col w-full min-w-0 mb-6 break-words bg-white rounded shadow-lg"
  >
    <div class="px-4 py-3 mb-0 bg-transparent rounded-t">
      <div class="flex flex-wrap items-center">
        <div class="relative flex-1 flex-grow w-full max-w-full">
          <h6 class="mb-1 text-xs font-semibold uppercase text-blueGray-100">
            Overview
          </h6>
          <h2 class="text-xl font-semibold text-white">
            Sales value
          </h2>
        </div>
      </div>
    </div>
    <div class="flex-auto p-4">
      <!-- Chart -->
      <div class="relative h-350-px">
        <Bar
          id="my-chart-id"
          :options="chartOptions"
          :data="chartData"
        />
        </div>
    </div>
    </div>
    

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
        datasets: [ 
          { 
            label: 'Data One', 
            data: [40, 20, 12] } 
        ]
      },
      chartOptions: {
        responsive: true
      }
    }
  }
}
</script>