<template>
  <v-card>
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
</template>
<script>
export default {
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
