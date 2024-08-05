<template>
  <v-app-bar v-if="success=true" :elevation="10" color="green" dark app >
    <v-app-bar-nav-icon @click.stop="drawer = !drawer"> </v-app-bar-nav-icon>
    <v-toolbar-title class="text-uppercase">
      <span class="">PROJECT DATA</span>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <v-btn icon="mdi-logout" color="red" @click="logout=true"></v-btn>

    <v-menu>
      <template v-slot:activator="{ props }">
        <v-btn icon v-bind="props">
          <v-icon color="">mdi-dots-vertical</v-icon>
        </v-btn>
      </template>
      <v-list density="comfortable">
        <v-list-item
          class=""
          min-width="100"
          density="default"
          v-for="(links, i) in drawerdt"
          :key="i"
          :value="links"
          :prepend-icon="links.icon"
          :to="links.route"
          :title="links.text"
        >
        </v-list-item>
      </v-list>
    </v-menu>
  </v-app-bar>
  <v-navigation-drawer
    location="start"
    class="text-white"
    v-model="drawer"
    color="green-lighten-2"
  >
    <v-list-item-title class="mb-11 ma-4">
      <h3>{{ data.name }}</h3>
      <p>{{ data.email }}</p>
    </v-list-item-title>

    <v-divider></v-divider>

    <v-list-item
      class=""
      min-height=""
      density="default"
      v-for="(links, i) in links"
      :key="i"
      :value="links"
      :to="links.route"
      :prepend-icon="links.icon"
      :title="links.text"
    >
    </v-list-item>
  </v-navigation-drawer>
  <v-dialog v-model="logout" persistent max-width="290">
    <v-card>
      <v-card-title class="headline">Konfirmasi Logout</v-card-title>
      <v-card-text> Apakah Anda yakin ingin logout? </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="red darken-1" text @click="handleLogout">Ya</v-btn>
        <v-btn color="green darken-1" text @click="logout = false">Tidak</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from "axios";
import { useRouter } from "vue-router";


export default {
  setup() {
    const router = useRouter();
  },
  data: () => ({
    role :"",
    logout: false,
    data: [],
    success: false,
    drawer: true,
    drawerdt:[
      { icon: "mdi-view-dashboard", text: "Home", route: "/home" },
      { icon: "mdi-account", text: "Profile", route: "/profile" },

    ],
    links: [],
    links1: [
      { icon: "mdi-view-dashboard", text: "Dashboard", route: "/admin/admin"  },
      { icon: "mdi-folder", text: "Data Penduduk", route: "/admin/penduduk" },
      { icon: "mdi-folder-home", text: "Data Keluarga", route: "/admin/keluarga" },
      { icon: "mdi-account", text: "Profile", route: "/profile" },
      { icon: "mdi-information", text: "About", route: "/about" },
    ],
    links2: [
      { icon: "mdi-view-dashboard", text: "Dashboard", route: "/user/dashboard" },
      { icon: "mdi-folder", text: "Data Penduduk", route: "/user/penduduk" },
      { icon: "mdi-folder-home", text: "Data Keluarga", route: "/user/keluarga" },
      { icon: "mdi-information", text: "About", route: "/about" },
      { icon: "mdi-account", text: "Profile", route: "/profile" },
    ],
  }),
  mounted() {
    this.status();
    this.navlist();
  },
  methods: {
    navlist() {
      switch(this.role){
            case "superAdmin":
              this.links=this.links1
              break;
            case "enum":
              this.links=this.links2
              break;
            case "admin":
              this.links=this.links2
              break;

          }
    },
    handleLogout() {
      try {
        axios.post("/api/logout").then((res) => {
          console.log("Logout response:", res.data);
          this.logout = false;
          this.status();
          this.success = false;
          this.$router.push("/");
          this.navlist();
          localStorage.removeItem('auth')
        });
      } catch (error) {
        error;

      }
    },

    status() {
      try {
        axios.get("/api/user").then((res) => {
          this.data = res.data.data;
          this.success = res.data.success;
          this.role=res.data.data.level
          this.navlist();
        });
      } catch (error) {
        error;
        this.success = false;
      }
    },
  },
  created() {
    console.log(this.success)
  },
};
</script>
