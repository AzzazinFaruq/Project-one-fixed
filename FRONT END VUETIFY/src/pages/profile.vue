<template>
<div class="pa-5">
  <v-tabs
      v-model="tab"
      align-tabs="left"
      color="#F76C5E"
    >
      <v-tab :value="one">Edit Profil</v-tab>
      <v-tab :value="two">Keamanan</v-tab>
    </v-tabs>

    <v-card class="mt-5 pa-10" elevation="0">
      <v-tabs-window v-model="tab">
        <v-tabs-window-item value="one">
          <div class="d-flex justify-center">
            <div class="rounded-circle" style="background-color: #F76C5E; width: 150px; height: 150px;">
              <v-img src="../assets/avatar.png" width="150" height="150"></v-img>
            </div>
          </div>
          <div class="mt-5">
            <label class="">Nama</label>
            <v-text-field
              class="mt-2"
              v-model="userdata.name"
              variant="outlined"
              density="comfortable"
            ></v-text-field>
            <label class="">Email</label>
            <v-text-field
              class="mt-2"
              v-model="userdata.email"
              variant="outlined"
              density="comfortable"
            ></v-text-field>
          </div>
          <div class="d-flex justify-end">
            <v-btn color="#01A65D" prepend-icon="mdi-content-save" class="text-white">Simpan</v-btn>
          </div>
        </v-tabs-window-item>
        <v-tabs-window-item value="two">
          Two
        </v-tabs-window-item>
      </v-tabs-window>
    </v-card>
</div>
</template>
<script>
import axios from 'axios';
import { test } from '@/stores/restrict';
const use = test();
export default {
setup(){
  use.setup();
},
data(){
  return{
    tab:1,
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
<style scoped>
label{
  font-size: 16px;
  font-weight: 600;

}
</style>
