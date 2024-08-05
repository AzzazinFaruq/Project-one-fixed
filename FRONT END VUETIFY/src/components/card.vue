<template>
  <v-card class="mx-auto my-4" :color="card" min-width="300">
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
          <v-btn class="ml-3" append-icon="mdi-arrow-right" :color="color">Detail</v-btn>
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
</template>

<script>
export default {
  name: 'DataCard',
  props: {
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
