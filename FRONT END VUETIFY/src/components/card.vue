<template>
        <v-skeleton-loader
          min-width="295"
          class="mr-2 my-4"
          :loading="!loading"
          type="card"
        >
        <v-card class="" :color="card" min-width="295" elevation="10">
      <v-row class="ma-1">
        <v-col>
          <h1>{{ title }}</h1>
          <p class="text-body-1 "> {{ description }}</p>
        </v-col>
        <v-col class="text-right">
          <v-icon  class="text-left" size="80">{{ icon }}</v-icon>
        </v-col>
      </v-row>
      <div>
        <v-row class="">
        <v-col class="">
          <v-btn class="ml-3" append-icon="mdi-arrow-right" :color="color" :href="route">Detail</v-btn>
        </v-col>
        <v-col class="text-right pt-2">
        <v-chip
        size="x-large"
        color="white"
        class=" mr-3 mb-2"
      >
      <h3>{{ count }}</h3>
      </v-chip>
        </v-col>
      </v-row>

      </div>
  </v-card>
        </v-skeleton-loader>
</template>

<script>
export default {
  name: 'DataCard',
  data(){
    return{
      loading:false
    }
  },
  created() {
    this.load();
  },

  methods:{
    load() {
      setTimeout(() => {
        this.loading = true; // Setelah data selesai dimuat, matikan loading
      }, 4000); // Contoh delay 2 detik untuk simulasi
    },
  },
  props: {
    route:{
      type: String,
      required: true
    },
    card:{
      type: String,
      required: true
    },
    color:{
      type: String,
      required: true
    },
    icon: {
      type: String,
      required: true
    },
    title: {
      type: String,
      required: true
    },
    description: {
      type: String,
      required: true
    },
    count: {
      type: Number,
      required: true
    }
  }
}
</script>

<style scoped>
.v-card {
  max-width: 400px;
}
</style>
