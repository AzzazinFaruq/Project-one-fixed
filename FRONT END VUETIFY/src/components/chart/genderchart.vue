<template>
   <v-skeleton-loader
  type="card"
  width="500"
  :loading="!loading"
  class="ma-1"
  >
  <v-card
  class="ma-3 ml-10"
  min-width="500"
  elevation="10"
  >
<apexchart width="100%" type="pie" :options="options" :series="series2" ></apexchart>
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
        labels:['LAKI-LAKI','PEREMPUAN']
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
