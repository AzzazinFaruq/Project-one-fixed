<template>
    <v-card class="pa-5" min-width="295" elevation="0" rounded="lg">
      <div class="d-flex justify-space-between">
        <p class="text-h6">{{ title }}</p>
        <div class="icon-wrapper" :style="{ backgroundColor: bgColor, color: iconColor }">
          <v-icon size="32">{{ icon }}</v-icon>
        </div>
      </div>
      <div class="">
        <h1>{{ count }}</h1>
      </div>
  </v-card>

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
      }, 2000); // Contoh delay 2 detik untuk simulasi
    },
  },
  props: {
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
      type: String,
      required: true
    },
    bgColor: {
      type: String,
      default: '#F0FFF0' // warna default jika tidak ada props
    },
    iconColor: {
      type: String,
      default: '#F0FFF0' // warna default jika tidak ada props
    }
  }
}
</script>

<style scoped>
.icon-wrapper{
  border-radius: 50%;
  padding: 10px;
}
</style>
