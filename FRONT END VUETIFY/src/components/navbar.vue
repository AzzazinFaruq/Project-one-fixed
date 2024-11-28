<template>
  <div class="">
    <v-navigation-drawer
    app
    v-model="drawer"
    class="custom-drawer"
  >
    <v-list >
      <v-list-item-title class="logo-wrap">
        <a href="/home">
          <img src="../assets/logo-pendataan-black.png" alt="" class="sidebar-logo mb-3">
        </a>
      </v-list-item-title>

      <!-- Loop untuk item utama lainnya -->
      <v-list-item
        class="list"
        min-width="100"
        density="default"
        v-for="(links, i) in links"
        :key="i"
        :value="links"
        :to="links.route"
        :title="links.text"
        :prepend-icon="links.icon"
        active-class="active-item"
      ></v-list-item>
    </v-list>
  </v-navigation-drawer>

  <v-app-bar
  class="pt-2"
    color=""
    prominent
    elevation="5"
    style="height: 80px;"
  >
    <div class="d-lg-none">
      <v-app-bar-nav-icon @click="drawer = !drawer">
      </v-app-bar-nav-icon>
    </div>
    <v-app-bar-title
      style="
        min-width: 100px;
        font-size: 18px;
        font-weight: 700;
        white-space: normal;
        overflow: visible;
        line-height: 1.2;
      "
    >
      {{ title.pageTitle }}
    </v-app-bar-title>

    <v-menu
      v-model="showResults"
      :close-on-content-click="false"
      location="bottom"
      transition="scale-transition"
      offset="5"
    >
      <template v-slot:activator="{ props }">
        <v-text-field
          rounded="xl"
          v-model="search"
          density="compact"
          variant="outlined"
          class="mx-4 d-none d-sm-block"
          append-inner-icon="mdi-magnify"
          placeholder="Cari data..."
          single-line
          hide-details
          style="width: 100%;"
          @update:model-value="onSearch"
          v-bind="props"
        ></v-text-field>
      </template>

      <v-card min-width="300" v-if="search">
        <v-list>
          <v-list-item
            @click="searchIn('penduduk')"
            prepend-icon="mdi-account-multiple"
          >
            <v-list-item-title>
              Cari di Data Penduduk
            </v-list-item-title>
          </v-list-item>

          <v-list-item
            @click="searchIn('keluarga')"
            prepend-icon="mdi-account"
          >
            <v-list-item-title>
              Cari di Data Keluarga
            </v-list-item-title>
          </v-list-item>
        </v-list>
      </v-card>
    </v-menu>

    <v-spacer></v-spacer>
    <div class="mr-2">
     <v-btn
     style="background-color: #FEF0EF;"
       icon="mdi-logout"
       color="#F76C5E"
       variant="outlined"
       density="compact"
       size="small"
       @click="logout()"
     ></v-btn>
    </div>
    <div class="mr-2">
      <a href="/profile">
      <v-img
        rounded="xl"
        src="../assets/avatar.png"
        alt=""
        width="32"
      ></v-img>
      </a>
    </div>
  </v-app-bar>
  </div>
</template>

<script>
import axios from "axios";
import { useRouter } from "vue-router";
import { useTitle } from '@/stores/title'
// import { useNav } from "@/stores/nav";
const usenav = 'test';
export var name ='';
export default {
  setup() {
    const router = useRouter();
    const title = useTitle()
    return { title }
  },
  data: () => ({
    role :"",
    logout: false,
    data: [],
    success: false,
    drawer: true,
    links: [
    ],
    links1: [
      { icon: "mdi-home", text: "Home", route: "/dashboard"  },
      { icon: "mdi-account-multiple", text: "Data Penduduk", route: "/penduduk" },
      { icon: "mdi-account", text: "Data Keluarga", route: "/keluarga" },
    ],
    links2: [
      { icon: "mdi-home", text: "Dashboard", route: "/dashboard"  },
      { icon: "mdi-account-multiple", text: "Data Penduduk", route: "/penduduk" },
      { icon: "mdi-account", text: "Data Keluarga", route: "/keluarga" },
    ],
    currentTitle: '',
    search: '',
    showResults: false,
  }),
  mounted() {
    this.status();
  },
  methods: {
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
          name=res.data.data.name
          this.role=res.data.data.level
          this.navlist();
        });
      } catch (error) {
        error;
        this.success = false;
        this.$router.push('/login')
      }
    },
    navlist(){
      if (this.role == 'enum') {
        this.links=this.links1;
      }
      else if (this.role == 'admin' || this.role=='superAdmin') {
        this.links=this.links2
      }
    },
    onSearch() {
      if (this.search) {
        this.showResults = true;
      } else {
        this.showResults = false;
      }
    },

    searchIn(type) {
      this.showResults = false;
      if (type === 'penduduk') {
        this.$router.push({
          path: '/penduduk',
          query: { search: this.search }  // Menggunakan query parameter
        });
      } else if (type === 'keluarga') {
        this.$router.push({
          path: '/keluarga',
          query: { search: this.search }  // Menggunakan query parameter
        });
      }
      this.search = ''; // Reset search setelah navigasi
    }
  },
  created() {
    console.log(this.success)
  },
};
</script>
<style lang="scss" scoped>
$breakpoint-mobile: 768px;
@mixin mobile {
    @media (max-width: $breakpoint-mobile) {
      @content;
    }
  }
.custom-drawer {
    color: black !important; /* Warna teks */

    .v-list-group__items .v-list-item {
      padding-inline-start: 18px !important;
  }
    .v-list-item {
        margin: 8px 18px 0px 18px;
      &:hover {
        background-color: rgba(255, 255, 255, 0.422); /* Warna saat di-hover */
        color: black;
        border-radius: 10px !important;
      }
      .v-list-item-title {
        font-weight: bold;
        font-size: 16px;
        margin-left: 10px;
        white-space: normal;
        word-wrap: break-word;
        overflow: hidden;
      }

    }
    .v-list-item__prepend {
      align-items: center;
      align-self: center;
      display: unset;
      grid-area: prepend;
  }
    .active-item {
        background-color: #C37B58; /* Warna saat item dipilih */
        color: white;
        border-radius: 10px !important;

        .v-list-item-title {
          font-weight: bold;
        }
      }
  }

  .logo-wrap{
    margin: 24px 0px 0px 24px !important;

    .sidebar-logo{
        max-width: 190px;
      }
  }

  :deep(.v-field) {
    border-radius: 8px;
  }

  // .container-avatar{
  //   width: 32px;
  //   height: 32px;
  //   border-radius: 50%;
  //   overflow: hidden;
  //   .avatar-img{
  //     border-radius: 50%;
  //     width: 100%;
  //     height: 100%;
  //     object-fit: cover;
  //   }
  // }
  /* Tambahan style untuk menu */
  :deep(.v-menu) {
    margin-top: -15px;  // Sesuaikan jarak menu dengan searchbar
  }

  :deep(.v-toolbar-title__placeholder) {
    overflow: visible !important;
    white-space: normal !important;
    text-overflow: unset !important;
  }

  /* Optional: Jika ingin mengatur ukuran lebih spesifik */
  :deep(.v-btn--size-small) {
    width: 32px;
    height: 32px;

    .v-icon {
      font-size: 18px;
    }
  }
</style>
