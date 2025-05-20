<template>
  <div></div>
  <v-sheet color="grey" max-width="600px"> </v-sheet>
  <v-dialog max-width="500">
    <template v-slot:activator="{ props: activatorProps }">
      <v-btn
        v-bind="activatorProps"
        color="surface-variant"
        text="Open Dialog"
        variant="flat"
      ></v-btn>
    </template>

    <template v-slot:default="{ isActive }">
      <v-card title="Dialog">
        <v-card-text v-for="item in dt" :key="item.id">
          <v-table class="border-md border-primary text-center">
            <tr class="ma-10 pa-10">
              <td>P</td>
              <td>tes</td>
            </tr>
            <v-spacer></v-spacer>
            <tr>
              <td>TEs</td>
              <td>TEs</td>
            </tr>
          </v-table>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn text="Close Dialog" @click="isActive.value = false"></v-btn>
        </v-card-actions>
      </v-card>
    </template>
  </v-dialog>
</template>
<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";

const id = 1;
const dt = ref([]);

onMounted(
  async () =>
    await axios.get("https://apikk.spora.id/api/penduduk/" + id).then((res) => {
      console.log(res.data);
      dt.value = res.data;
    })
);
</script>
