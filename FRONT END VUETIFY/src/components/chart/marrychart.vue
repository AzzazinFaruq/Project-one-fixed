<template>
 <v-card
  class="ma-3 mr-10"
  width="500"
    elevation="10"
 >
 <apexchart width="100%" type="bar" :options="options" :series="series1" class="ma-2" ></apexchart>
</v-card>
</template>
<script>
import axios from 'axios';
export default {
data(){
  return{
    options: {
        // responsive:[{
        //   breakpoint:1000,
        //   options:{
        //     width:'30%'
        //   }
        // }],
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
methods:{
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
