<template>
  <v-card
  class="ma-3 ml-10"
  width="500"
  elevation="10"
  >
<apexchart width="100%" type="pie" :options="options" :series="series2" ></apexchart>
  </v-card>
</template>
<script>
import axios from 'axios';
export default {
data(){
  return{
    options: {
        labels:['LAKI-LAKI','PEREMPUAN']
      },
      series2: [],
  }
},
mounted(){
this.gender();
},
methods:{
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
