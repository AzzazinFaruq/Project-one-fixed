<template>
  <v-skeleton-loader
  type="card"
  width="100%"
  :loading="!loading"
  class="ma-1"
  >
  <v-card
  width="100%"
  >
      <v-table>
        <thead>
      <tr>
        <th class="text-left"
         v-for="item in dthead"
        :key="item.id"
        >
         {{item.name}}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="item in dtbody"
        :key="item.id"
      >
        <td>{{ item.kk }}</td>
        <td>{{ item.nik }}</td>
        <td>{{ item.nama }}</td>
        <td>{{ item.status }}</td>
        <td>{{ item.user_id }}</td>
      </tr>
    </tbody>
      </v-table>
    </v-card>
  </v-skeleton-loader>
</template>
<script>
export default {
  data(){
    return{
      loading:false
    }
  },
  methods: {
    load() {
      setTimeout(() => {
        this.loading = true; // Setelah data selesai dimuat, matikan loading
      },4000); // Contoh delay 2 detik untuk simulasi
    },
  },
created() {
  this.load();
},
  props: {
    dthead:{
      type: Array,
      required: true
    },
    dtbody:{
      type: Array,
      required: true
    },
  }
}
</script>
