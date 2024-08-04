<template>
<v-container>
  <v-card >
    <h1>{{ userdata }}</h1>
  </v-card>
</v-container>
</template>
<script>
import axios from 'axios';
export default {
data(){
  return{
    userdata:[]
  }
},
mounted(){
this.user();
},
methods:{
  user(){
    try{
      axios.get('/api/user')
      .then((res)=>{
        console.log(res.data.data)
        this.userdata = res.data.data
      })
    }
    catch{

    }
  }
}
}

</script>
