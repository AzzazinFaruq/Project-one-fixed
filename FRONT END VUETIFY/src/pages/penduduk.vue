<template>
  <v-container class="">
    <v-card>
      <v-table>
        <thead>
          <tr>
            <th class="text-center">Nama</th>
            <th class="text-center">Calories</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="buku in getbuku" :key="buku.id">
            <td>{{ buku.nama }}</td>
            <td>{{ buku.tmp_lhr }}</td>
          </tr>
        </tbody>
      </v-table>
    </v-card>
  </v-container>
</template>
<script setup>
import HelloWorld from "@/components/HelloWorld.vue";
import axios from "axios";
import { onMounted, ref } from "vue";
const getbuku = ref([]);
// mounted
onMounted(async () => {
  // get api from laravel backend
  await axios
    .get("/api/penduduks")
    .then((response) => {
      // assign state users with response data
      console.log(response);
      getbuku.value = response.data;
    })
    .catch((error) => {
      console.log(response);
    });
});
</script>
// onMounted(()=>{ // getBuku() // }) // const getBuku = async()=>{ // let buku
= await axios.get('/getBuku') // state.dataBuku = buku.data // }
