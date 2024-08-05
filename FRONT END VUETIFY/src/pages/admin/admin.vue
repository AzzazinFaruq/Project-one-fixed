<template>
  <v-container >
    <h1>Admin Dashboard</h1>
    <p>Ini Adalah Halaman Dashboard Admin</p>
    <v-divider class="my-2"></v-divider>
    <h5>Selamat Datang {{ data.name }}</h5>
  </v-container>
  <v-container >

    <v-card class="pa-2">
      <h3 class="ma-2">DATA TERBARU</h3>
      <v-divider></v-divider>
    <v-tabs
      v-model="tab"
      variant="outlined"
      bg-color="deep-green-accent-4"
    >
      <v-tab value="one">DATA KELUARGA</v-tab>
      <v-tab value="two">DATA PENDUDUK</v-tab>
    </v-tabs>

    <v-card-text>
      <v-tabs-window v-model="tab">
        <v-tabs-window-item value="one">
          <v-card>
      <v-table>
        <thead>
      <tr>
        <th class="text-left">
          NOMOR KK
        </th>
        <th class="text-left">
          NOMOR NIK
        </th>
        <th class="text-left">
          NAMA
        </th>
        <th class="text-left">
          STATUS
        </th>
        <th class="text-left">
          USER
        </th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="item in dtkel"
        :key="item.id"
      >
        <td>{{ item.no_kk }}</td>
        <td>{{ item.kk_nik }}</td>
        <td>{{ item.kk_nama }}</td>
        <td>{{ item.status }}</td>
        <td>{{ item.user_id }}</td>
      </tr>
    </tbody>
      </v-table>
    </v-card>
        </v-tabs-window-item>

        <v-tabs-window-item value="two">
          Two
        </v-tabs-window-item>

        <v-tabs-window-item value="three">
          Three
        </v-tabs-window-item>
      </v-tabs-window>
    </v-card-text>
  </v-card>
  </v-container>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      tab: null,
      data: [],
      level:"none",
      dtkel:[]
    };
  },
  mounted() {
    this.status();
    this.datalast();
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
    datalast(){
      axios.get('/api/latestkel')
      .then((res)=>{
        console.log(res.data)
        this.dtkel = res.data;
      })
    }
  },
  created() {

  },
};

</script>

<style>

</style>
