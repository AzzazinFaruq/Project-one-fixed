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
      level:"none"
    };
  },
  mounted() {
    this.status();
  },
  methods: {
    status() {
      try {
        axios.get("/api/user").then((res) => {
          this.data = res.data.data;
          this.level = res.data.data.level
          switch(this.level){
            case "enum":
              this.$router.push("/forbidden")
              break;
            default:
              break;
          }

        });
      } catch (error) {
        console.error(error);
      }

    },
  },
  created() {

  },
};

</script>

<style>

</style>
