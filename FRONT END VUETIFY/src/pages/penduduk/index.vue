<template>
  <div class="pa-5">
    <div class="d-flex justify-end mb-5 mt-5">
      <v-btn
        rounded="lg"
        v-if="$route.query.search"
        class="mr-2"
        density=""
        variant="outlined"
        color="error"
        @click="resetSearch"
      >
        Reset Filter
      </v-btn>
      <v-btn href="/penduduk/inputPenduduk" elevation="0" color="#C37B58" rounded="lg" prepend-icon="mdi-plus">Penduduk</v-btn>
    </div>
    <v-alert
      v-model="notif"
      class="my-5"
      density='compact'
      type="success"
      variant="outlined"
      title="Sukses"
      closable
    >
    Sukses Edit Password User
    </v-alert>
    <v-card
    rounded="lg"
    class="pa-4"
    elevation="0"
    >
      <v-data-table
      style="text-transform: capitalize !important;"
        :headers="head"
        :items="getitem"
        :search="search"
        :loading="!isLoad"
        :items-per-page="totalData"
        hide-default-footer
      >
        <template v-slot:[`item.actions`]="{ item }">
          <v-chip class="px-3" color="#2184D8" variant="flat" style="font-size: 12px;" @click="edit(item.id)">Lihat Detail</v-chip>
        </template>
        <template v-slot:[`item.stat`]="{ item }">
          <v-chip
            style="font-size: 12px;"
            :color="item.stat.toLowerCase() === 'aktif' ? 'success' : 'error'"
            :text-color="white"
          >
            {{ item.stat }}
          </v-chip>
        </template>
        <!-- <template v-slot:item.tgl_lhr="{ value }">
            <v-chip>
              {{ value }}
            </v-chip>
          </template> -->
        <!-- <template v-slot:top>
          <v-row class="d-flex ma-1">
            <v-col>
            <div class="d-flex justify-start mb-2">
            <v-btn  href="/penduduk/inputPenduduk" compact>Tambah data</v-btn>
          </div>
          </v-col>
          <VSpacer/>
          <v-col>
            <div class="d-flex align-start">
            <v-select
                class="mr-2"
                :items="[5,10,20,50,100]"
                v-model="totalData"
                variant="outlined"
                width="130"
                max-width="130"
                label="Items Per Page"
                density="compact"
              ></v-select>
                <v-text-field
                density="compact"
                v-model="search"
                width="300"
                max-width="300"
                variant="outlined"
                label="Search"
                append-inner-icon="mdi-magnify"
                class=""
              ></v-text-field>
          </div>
          </v-col>
        </v-row>

        </template> -->
      </v-data-table>
    </v-card>
    <div class="d-flex justify-space-between mt-5">
      <div class="d-flex">
        <p class="pt-2" style="font-size: 14px;">Data / Halaman : </p>
        <v-number-input
          :reverse="false"
          class="ml-2"
          controlVariant="stacked"
          v-model="totalData"
          label=""
          density="compact"
          :hideInput="false"
          :inset="false"
          variant="outlined"
        ></v-number-input>
      </div>
      <div class="">
        <v-pagination
        density="comfortable"
        v-model="page"
        :length="last_page"
        :total-visible="0"
        class="custom-pagination"
        ></v-pagination>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { succes } from "./inputPenduduk.vue";
import { test } from '@/stores/restrict';
import { useTitle } from '@/stores/title'
const use = test();
export default {
  setup(){
    use.setup();
    const title = useTitle()
    title.setTitle(' Data Penduduk')  // Set title halaman
  },
  data() {
    return {
      notif:succes,
      isLoad: false,
      dialog: false,
      dialDetail: false,
      selectedId: null,
      search: this.$route.query.search || "",
      head: [
        { title: "Nomer KK", value: "nomer_kk" },
        { title: "NIK", value: "nik" },
        { title: "Nama", value: "nama" },
        { title: "Kelamin", value: "kelamin" },
        { title: "Status", value: "stat" },
        { title: "User", value: "user_id" },
        { title: "Action", value: "actions" },
      ],
      name: "",
      getitem: [],
      itemDetail: {},
      userRole:"",
      page: 1,
      last_page:0,
      totalData:8
    };
  },
  mounted() {
    this.role();
    this.getPen();
  },
  methods: {
    role(){
      try {
        axios.get("/api/user").then((res) => {
          this.data = res.data.data;
          this.level = res.data.data.level;
          // switch(this.level){
          //   case "enum":
          //     this.$router.push("/forbidden")
          //     break;
          // }
        });
      } catch (error) {
        console.error(error);
      }
    },
    edit(item) {
      this.$router.push(`/penduduk/edit/${item}`);
    },
    getPen() {
      this.load();
      try {
        axios.get(`/api/penduduk/`, {
          params: {
            page: this.page,
            item: this.totalData,
            search: this.search
          }
        })
        .then((response) => {
          this.getitem = response.data.data.data.map(item => ({
            ...item,
            nama: this.toCapitalize(item.nama),
            kelamin: this.toCapitalize(item.kelamin),
            stat: this.toCapitalize(item.stat)
          }));
          this.totalPages = response.data.data.total;
          this.last_page = response.data.data.last_page;
        });
      } catch (error) {
        console.error(error);
      }
    },
    deletePenduduk(id) {
      try {
        axios.delete(`/api/deletePenduduk/${id}`);
        this.getPen();
        alert("Data penduduk berhasil dihapus");
      } catch (error) {
        alert("Error deleting data:", error);
      }
    },
    confirmDelete(id) {
      this.selectedId = id;
      this.dialog = true;
    },
    closeDialog() {
      this.dialog = false;
      this.selectedId = null;
    },
    async deleteData() {
      try {
        await axios.delete(
          `/api/deletePenduduk/${this.selectedId}`
        ); // Ganti dengan endpoint yang sesuai
        this.load();
        this.getPen();
        this.closeDialog(); // Tutup dialog
      } catch (error) {
        console.error("Error deleting data:", error);
        this.closeDialog(); // Tutup dialog meskipun ada kesalahan
      }
    },
    load() {
      this.isLoad = false;
      setTimeout(() => {
        this.getitem;
        this.isLoad = true; // Setelah data selesai dimuat, matikan loading
      }, 2000); // Contoh delay 2 detik untuk simulasi
    },
    detail(id) {
      try {
        axios.get(`/api/penduduk/${id}`).then((res) => {
          this.itemDetail = res.data;
          console.log(this.itemDetail);
          this.dialDetail = true;
          this.selectedId=id;
        });
      } catch {}
    },
    toCapitalize(str) {
      if (!str) return '';
      return str.toLowerCase().replace(/(?:^|\s)\w/g, function(match) {
        return match.toUpperCase();
      });
    },
    resetSearch() {
      this.search = '';
      this.$router.replace({
        path: this.$route.path,
        query: {}
      });
      this.getPen();
    },
    handleSearch(newSearch) {
      this.search = newSearch;
      this.page = 1; // Reset ke halaman pertama saat melakukan pencarian
      this.getPen(); // Refresh data
    }
  },
  watch:{
    page(){
      this.getPen();
    },
    totalData(){
      this.page=1;
      this.getPen();
    },
    '$route.query.search': {
      immediate: true,
      handler(newSearch) {
        if (newSearch !== undefined) {
          this.search = newSearch;
          this.page = 1; // Reset ke halaman pertama saat melakukan pencarian
          this.getPen(); // Refresh data
        }
      }
    }
  },
  created() {
    this.load();
  }
};
</script>
<style>
.iyath {
  width: 200px; /* Contoh mengatur lebar header dengan CSS */
}

/* Style untuk tombol prev & next pagination */
.custom-pagination .v-pagination__prev,
.custom-pagination .v-pagination__next {
  border: 1px solid #E0E0E0 !important;  /* Sesuaikan warna border yang diinginkan */
  border-radius: 10px !important;
  border-color: #925C42 !important;  /* Sesuaikan warna border saat hover */
}

/* Optional: Jika ingin mengubah style saat hover */
.custom-pagination .v-pagination__prev:hover,
.custom-pagination .v-pagination__next:hover {
  border-color: #C37B58 !important;  /* Sesuaikan warna border saat hover */
}
</style>
