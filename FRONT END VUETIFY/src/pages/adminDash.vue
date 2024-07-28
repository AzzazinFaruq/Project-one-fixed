<template>
  <v-container >
    <h1>Admin Dashboard</h1>
    <p>Ini Adalah Halaman Dashboard Admin</p>
    <v-divider class="my-2"></v-divider>
    <h5>Selamat Datang {{ data.name }}</h5>

  </v-container>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      data: [],
      level:""
    };
  },
  mounted() {
    this.status();
  },
  methods: {
    status() {
      try {
        axios.get("http://localhost:8000/api/user").then((res) => {
          console.log(res.data);
          this.data = res.data.data;
          this.level = res.data.data.level
          console.log(this.level)
          switch(this.level){
            case "superAdmin":
              break;
            case "enum":
              this.$router.push("/dashboard")
              break;
            case "admin":
              break;
          }

        });
      } catch (error) {
        console.error(error);
      }

    },
    config(){
      switch(this.level){
            case "superAdmin":
              alert("iya")
              break;
            case "enum":
              this.$router.push("/dashboard")
              break;
            case "admin":
              alert('iya')
              break;

          }

    }
  },
  created() {

  },
};

</script>

<style>

</style>
