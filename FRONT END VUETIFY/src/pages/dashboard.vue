<template>
  <v-container class="">
    <h1>Halaman Dashboard</h1>
    <p>Ini Adalah Halaman Dashboard</p>
  </v-container>
</template>

<script>
import axios from "axios";

import { useRouter } from "vue-router";
useRouter;
export default {
  data() {
    return {
      nama: [],
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
          this.nama = res.data.data;
        });
      } catch (error) {
        console.error(error);
      }
     
    },
  },
  created() {},
};
</script>
