<template>
  <v-skeleton-loader
  :loading="!loading"
  type="card"
  width="900px"
  class="mt-5"
  >
  <v-card
  elevation="10"
  class="mt-5"
  >
      <v-card-title class=" text-center" >
      <h3>RIWAYAT INPUT</h3>
      <v-divider class="my-2"></v-divider>
    </v-card-title>
    <v-row class="px-4" justify="center">
    <v-col>
      <v-select
        variant="outlined"
        :items="bulan"
        item-title="name"
        item-value="id"
        v-model="inbulan"
        label="Bulan"
        @input="fetchData"
      ></v-select>
    </v-col>
    <v-col>
      <v-select
        variant="outlined"
        :items="tahun"
        v-model="intahun"
        label="Tahun"
      ></v-select>
    </v-col>
  </v-row>
  <apexchart width="900px" height="450px"  type="line" :options="options" :series="series" class="pr-7 pb-3 "></apexchart>
  </v-card>
  </v-skeleton-loader>
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
        colors: ['#85aded'],
        xaxis: {
          categories: []
        }
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
