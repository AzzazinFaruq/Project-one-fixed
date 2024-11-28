<template>

 <apexchart type="bar" :options="options"  :series="series1" height="400px"  class="ma-2" ></apexchart>

</template>
<script>
import axios from 'axios';
export default {
data(){
  return{
    loading:false,
    options: {
        width:'500px',
        responsive:[{
          breakpoint:400,
          options:{
            width:'300px'
          }
        }],
        fill: {
        colors: '#2184D8'
        },
        xaxis: {
          categories: ['Belum Kawin','Sudah Kawin','Cerai Hidup','Cerai Mati']
        },
        yaxis: {
          tickAmount: 3,
          min: 0,
          max: function(max) {
            return Math.ceil(max / 5) * 5;
          },
          labels: {
            formatter: function(value) {
              return Math.round(value);
            }
          }
        }
      },
      series1: [],
  }
},
mounted(){
this.marry();
this.updatewidth()
},
created() {
  this.load();
},
methods:{
  updatewidth(){
    console.log(document.getElementById('container'))
  },
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
