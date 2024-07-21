<template>
  <v-app>
    <navbar :key="$route.fullPath"></navbar>
    <v-main>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>

    <v-footer app> </v-footer>
  </v-app>
</template>

<script>
import navbar from "./components/navbar.vue";
import axios from "axios";
export default {
  components: {
    navbar,
  },
  data(){
    return{
      status:false
    }
  },
  created(){
    axios.get("http://localhost:8000/api/user")
    .then((res=>{
      console.log(res);
      this.status=false;

    }))
  }

};
</script>
