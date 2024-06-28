<template>
  <v-app>
  <navbar></navbar>
    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script setup>
  import navbar from './components/navbar.vue'
</script>
