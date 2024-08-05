<template>
<v-container>
  <h1>Profile User</h1>
  <v-card class="mt-5" max-width="500">
     <v-row class="ma-2">

      <v-col><h4>Name</h4></v-col>
      <v-divider vertical :thickness="4" class="mx-2"></v-divider>
      <v-col>{{ userdata.name }}</v-col>
     </v-row>
     <v-row class="ma-2">

      <v-col><h4>Email</h4></v-col>
      <v-divider vertical :thickness="4" class="mx-2"></v-divider>
      <v-col>{{ userdata.email }}</v-col>
     </v-row>
     <v-btn color="black" class="ma-2" variant="outlined" href="/edit">Edit Profile</v-btn>
     <v-btn color="red" class="ma-2" variant="outlined" @click='logout()'>Log Out</v-btn>
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
  },
  logout() {
      try {
        axios.post("/api/logout").then((res) => {
          console.log("Logout response:", res.data);
          this.success = false;
          this.$router.push("/");
          localStorage.removeItem('auth')
        });
      } catch (error) {
        error;

      }
}
}
}

</script>
