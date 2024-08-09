import { defineStore } from "pinia";

export const useNav = defineStore({
  id: "options",
  state: () => ({
    links1: [
      { icon: "mdi-view-dashboard", text: "Dashboard", route: "/dashboard"  },
      { icon: "mdi-folder", text: "Data Penduduk", route: "/dashboard/penduduk" },
      { icon: "mdi-folder-home", text: "Data Keluarga", route: "/dashboard/keluarga" },
      { icon: "mdi-account", text: "Profile", route: "/profile" },
      { icon: "mdi-information", text: "About", route: "/about" },
    ],
    links2: [
      { icon: "mdi-view-dashboard", text: "Dashboard", route: "/dashboard"  },
      { icon: "mdi-folder", text: "Data Penduduk", route: "/dashboard/penduduk" },
      { icon: "mdi-folder-home", text: "Data Keluarga", route: "/dashboard/keluarga" },
      { icon: "mdi-account", text: "Profile", route: "/profile" },
      { icon: "mdi-information", text: "About", route: "/about" },
      { icon: "mdi-information", text: "Tambah User", route: "/about" },
    ],
  })

})
