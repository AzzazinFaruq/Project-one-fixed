<template>
  <v-skeleton-loader
  type="card"
  width="500"
  :loading="!loading"
  class="ma-1"
  >
  <v-card
  class="ma-3 mr-10"
  min-width="350"
  elevation="10"
 >
 <apexchart width="500" type="bar" :options="options" :series="series1" class="ma-2" ></apexchart>
</v-card>
  </v-skeleton-loader>
</template>
<script>
import axios from 'axios';
export default {
data(){
  return{
    loading:false,
    options: {
        responsive:[{
          breakpoint:350,
          options:{
            width:350
          }
        }],
        fill: {
        colors: '#49aa27'
        },
        xaxis: {
          categories: ['Belum Kawin','Sudah Kawin','Cerai Hidup','Cerai Mati']
        }
      },
      series1: [],
  }
},
mounted(){
this.marry();
},
created() {
  this.load();
},
methods:{
  load() {
      setTimeout(() => {
        this.marry();
        this.loading = true; // Setelah data selesai dimuat, matikan loading
      }, 4000); // Contoh delay 2 detik untuk simulasi
    },
  marry(){
        axios.get('/api/marry')
        .then((res)=>{
          const val=res.data.data
          this.series1=[{
            name:'Data Kawin',
            data:[val[0],val[1],val[2],val[3]]
          }]
        })
    },
}
}
</script>i
