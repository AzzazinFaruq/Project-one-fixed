<template>
  <v-card
  width="100%"
  ele
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
        <td>
          <v-chip
            style="font-size: 12px;"
            :color="item.status.toLowerCase() === 'aktif' ? 'success' : 'error'"
            :text-color="white"
          >
            {{ item.status }}
          </v-chip>
        </td>
        <td>{{ item.user_id }}</td>
      </tr>
    </tbody>
      </v-table>
    </v-card>
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
