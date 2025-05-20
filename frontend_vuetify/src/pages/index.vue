<template>
  <v-container fluid class="">
    <!-- <v-card class="" elevation="" max-width="">
      <v-card-title>
       Anda Belum login
      </v-card-title>
      <v-card-actions>
        <v-btn text color="" href="/login">Login</v-btn>
      </v-card-actions>
    </v-card> -->
  </v-container>
</template>
<script>
export default{
  mounted(){
    if(localStorage.getItem('auth')==='true'){
      this.$router.push('/dashboard')
    }
    else{
      this.$router.push('/login')
    }
  }
}

</script>
