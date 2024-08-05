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
     <v-btn color="red" class="ma-2" variant="outlined" @click='logout=true'>Log Out</v-btn>
  </v-card>
  <v-dialog v-model="logout" persistent max-width="290">
    <v-card>
      <v-card-title class="headline">Konfirmasi Logout</v-card-title>
      <v-card-text> Apakah Anda yakin ingin logout? </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="red darken-1" text @click="handlelogout()">Ya</v-btn>
        <v-btn color="green darken-1" text @click="logout = false">Tidak</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</v-container>
</template>
<script>
import axios from 'axios';
export default {
data(){
  return{
    userdata:[],
    logout:false
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
  handlelogout() {
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
