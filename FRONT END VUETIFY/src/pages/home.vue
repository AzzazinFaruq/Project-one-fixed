<template>
  <v-container loading="true">
    <h1>Welcome, {{ name }}</h1>
    <v-divider></v-divider>
    <v-btn color="success" class="mt-3" variant="outlined" @click="goTo()">Go to Dashboard</v-btn>
  </v-container>
</template>
<script>
import axios from 'axios';
import { computed } from 'vue';
import { useRouter } from 'vue-router';
export default{
  setup(){
    const isAdmin = computed(() => localStorage.getItem('auth') === 'true');
    const route = useRouter();
    if (!isAdmin.value) {
      route.push('/login')
    }
  },
  data(){
    return{
      name:'',
      role:'',
      success:0
    }
  },
  mounted(){
    this.user();
  },
  methods:{
    status(){
     switch(this.success){
      case 0 :
        this.$router.push('/login')
        break;
      case 1 :
        break;
     }
    },
    user(){
      try{
        axios.get("/api/user")
        .then((res)=>{
          this.name = res.data.data.name;
          this.role = res.data.data.level;
        })
      }
      catch(error){
        alert(error)
        this.$router.push('/login')
      }
    },
    goTo(){
      switch(this.role){
        case 'enum':
          this.$router.push('/user/dashboard')
          break;
        case 'admin':
          this.$router.push('/admin/admin')
          break;
        case 'superAdmin' :
          this.$router.push('/admin/admin')
      }
    }

  }

}
</script>
