<template>
  <v-app>
    <navbar :key="$route.fullPath"></navbar>
    <v-main>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>

    <v-footer app> </v-footer>
  </v-app>
</template>

<script>
import navbar from "./components/navbar.vue";
export default {
  components: {
    navbar,
  },
};
</script>
