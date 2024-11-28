<template>
  <div class="">
<apexchart  type="pie" :options="options" height="350px"  :series="series2" ></apexchart>
</div>
<div class="">
  <v-row class="d-flex justify-space-evenly ">
    <v-col cols="6"  class="text-center">
      <h1>{{ series2[0] }}</h1>
      <p class="label-with-box">
        <span class="color-box" style="background-color: #2196F3;"></span>
        Laki-Laki
      </p>
    </v-col>
    <v-col cols="6"  class="text-center">
      <h1>{{ series2[1] }}</h1>
      <p class="label-with-box">
        <span class="color-box" style="background-color: #FF4081;"></span>
        Perempuan
      </p>
    </v-col>
  </v-row>
</div>
</template>
<script>
import axios from 'axios';
export default {
data(){
  return{
    loading:false,
    options: {
        responsive:[
          {
            breakpoint: 1100,
            options: {
              chart: {
                width: '100%',
                height: '300px'
              }
            }
          },
          {
            breakpoint: 400,
            options: {
              chart: {
                width: '100%',
                height: '250px'
              }
            }
          }
        ],
        labels:['LAKI-LAKI','PEREMPUAN'],
        colors: ['#BAD9F3', '#FDD1CD'],
        dataLabels: {
          enabled: false
        },
        legend: {
          show: false
        }
      },
      series2: [],
  }
},
mounted(){
this.gender();
},
created() {
  this.load();
},
methods:{
  load() {
      setTimeout(() => {
        this.gender();
        this.loading = true; // Setelah data selesai dimuat, matikan loading
      }, 4000); // Contoh delay 2 detik untuk simulasi
    },
  gender(){
      axios.get('/api/gender')
        .then((res)=>{
          const val=res.data.data
          this.series2=[val[0],val[1]]
        })
    },
}
}
</script>

<style scoped>
.label-with-box {
  gap: 8px;
}

.color-box {
  display: inline-block;
  width: 12px;
  height: 12px;
  border-radius: 2px;
}
</style>
