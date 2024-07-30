<template>
  <v-container> </v-container>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      items: [
        { id: 1, name: "Kelamin" },
        { id: 2, name: "Item 2" },
        { id: 3, name: "Item 3" },
      ],
      selectedItem: null,
    };
  },
  mounted() {
    this.getPen();
  },
  methods: {
    getPen() {
      axios.get("/api/penduduk").then((res) => {
        console.log(res.data);
      });
    },
  },
};
</script>
