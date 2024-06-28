<template>
  <v-app-bar :elevation="10" color="green" dark app>
    <v-app-bar-nav-icon @click.stop="drawer = !drawer"> </v-app-bar-nav-icon>
    <v-toolbar-title class="text-uppercase">
      <span class="font-weight-light">PROJECT ONE</span>
    </v-toolbar-title>
  </v-app-bar>
  <v-navigation-drawer v-model="drawer">
    <v-list-item title="My Application" subtitle="Vuetify"></v-list-item>
    <v-divider></v-divider>

    <v-list-item
      v-for="(links, i) in links"
      :key="i"
      :value="links"
      :to="links.route"
    >
      {{ links.text }}
    </v-list-item>
  </v-navigation-drawer>
</template>

<script>
export default {
  data: () => ({
    drawer: false,
    links: [
      { icon: "dashboard", text: "dashboard", route: "/" },
      { icon: "person", text: "data penduduk", route: "penduduk" },
      { icon: "person", text: "about", route: "about" },
    ],
  }),
};
</script>
