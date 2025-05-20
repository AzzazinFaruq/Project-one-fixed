<template>
    <v-row class="" justify="center">
    <v-col>
      <v-select
        rounded="xl"
        density="compact"
        variant="outlined"
        :items="bulan"
        item-title="name"
        item-value="id"
        v-model="inbulan"
        @input="fetchData"
      ></v-select>
    </v-col>
    <v-col>
      <v-select
        rounded="xl"
        density="compact"
        variant="outlined"
        :items="tahun"
        v-model="intahun"
      ></v-select>
    </v-col>
  </v-row>
  <div class="chart-wrapper">
    <apexchart width="100%" height="450px"  type="line" :options="options" :series="series" class="pr-7 pb-3 "></apexchart>
  </div>
</template>
<script>
import axios from "axios";
import { useCons } from "@/stores/constant";
const useData = useCons();
export default {
  data() {
    return {
      loading:false,
      tahun:[],
      bulan:useData.bulan,
      inbulan:0,
      intahun:0,
      options: {
        colors: ['#F76C5E'],
        chart: {
          zoom: {
            enabled: false
          },
          toolbar: {
            show: false
          },
          scrollable: true
        },
        xaxis: {
          categories: [],
          scrollable: true
        },
        yaxis: {
          tickAmount: 4
        },
        grid: {
          row: {
            colors: ['#FEE9E7','#FFFFFF' ],
            opacity: 1
          }
        },
        responsive: [{
          breakpoint: 600,
          options: {
            chart: {
              width: 800
            }
          }
        }]
      },
      series: [{
        name:'Total Input',
        data:[]
      }
      ]
    }

  },
  mounted() {
    this.fetchData();
    this.current();
  },
  methods: {
    load() {
      setTimeout(() => {
        this.fetchData();
        this.loading = true; // Setelah data selesai dimuat, matikan loading
      },3000); // Contoh delay 2 detik untuk simulasi
    },
    current(){
    const today = new Date();
     this.intahun = parseInt(today.getFullYear());
     this.inbulan = parseInt(today.getMonth() + 1);
    },
    fetchData() {
        axios.get('/api/data',{
          params:{
            month:this.inbulan,
            year:this.intahun
          }
        }
        )
        .then((res)=>{
          let val=res.data.data;
          console.log(res.data.data)
          let panjang = val.length;
          for (let index = 0; index < panjang; index++) {
            this.options.xaxis.categories[index]=(index+1)
          }
          this.series[0].data=val
          console.log(this.bulan)
        })
        var tahun=2000;
        for (let index = 0; index < 50; index++) {
          this.tahun[index]=tahun;
          ++tahun;



        }
    },
  },
  watch:{
    inbulan(){
      this.fetchData();
    },
    intahun(){
      this.fetchData();
    }
  },
  created() {
    this.load();
  },
};
</script>

<style scoped>
.chart-wrapper {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}
</style>
