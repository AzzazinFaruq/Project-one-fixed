<template>
  <v-container class="">
    <v-row>
      <v-col>tes</v-col>
       <v-icon icon="mdi-chart-histogram"></v-icon>

    </v-row>
  </v-container>
</template>

<script setup>
import {ref,onMounted} from 'vue'
import axios from 'axios'
const user =ref();
onMounted(async ()=>{
  const data = await axios.get('/api/user')
  console.log(data)
})
</script>
