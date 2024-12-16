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
      <v-btn href="/keluarga/inputKeluarga" elevation="0" color="#C37B58" rounded="lg" prepend-icon="mdi-plus">Keluarga</v-btn>
    </div>
    <v-card
    rounded="lg"
    class="pa-4"
    elevation="0"
    >
      <v-data-table
      style="text-transform: capitalize !important;"
        :headers="head"
        :items="dataKeluarga"
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
import axios from 'axios';
import { test } from '@/stores/restrict';
const use = test();
import { useTitle } from '@/stores/title'

export default{
  setup(){
    const title = useTitle()
    title.setTitle('Data Keluarga')  // Set title halaman
    use.setup();
  },
  watch:{
    page(){
      this.updateDisplayedData();
    },
    totalData(){
      this.page=1;
      this.updateDisplayedData();
    },
    search: {
      handler() {
        this.page = 1;
        this.updateDisplayedData();
      }
    }
  },
  data(){
    return{
      isLoad:false,
      dialDetail: false,
      dialog:false,
      selectedId:null,
      dataKeluarga:[],
      allData: [],
      search: this.$route.query.search || "",
      head: [
        { title: "Nomer KK", value: "no_kk" },
        { title: "Nama", value: "kk_nama" },
        { title: "Status", value: "status" },
        { title: "User", value: "user_id" },
        { title: "Action", value: "actions" },
      ],
      page: 1,
      last_page:0,
      totalData:8
    }
  },
  mounted(){
    this.getKeluarga();

  },
  methods :{
    edit(item) {
      this.$router.push(`/keluarga/edit/${item}`);
    },
    detail(id) {
      try {
        this.load();
        axios.get(`/api/keluarga/${id}`).then((res) => {
          this.detailKeluarga = res.data;
          console.log(res.data);
          this.dialDetail = true;
          this.selectedId=id;
        });
      } catch {}
    },
    getKeluarga(){
      try{
        this.load();
        axios.get('/api/keluarga')
          .then((res) => {
            this.allData = res.data.data.map(item => ({
              ...item,
              kk_nama: this.toCapitalize(item.kk_nama),
              status: this.toCapitalize(item.status)
            }));
            this.updateDisplayedData();
          });
      } catch(error) {
        console.error('Error:', error);
      }
    },
    updateDisplayedData() {
      let filteredData = this.allData;
      if (this.search) {
        filteredData = this.allData.filter(item =>
          Object.values(item).some(val =>
            String(val).toLowerCase().includes(this.search.toLowerCase())
          )
        );
      }

      this.last_page = Math.ceil(filteredData.length / this.totalData);

      const start = (this.page - 1) * this.totalData;
      const end = start + this.totalData;
      this.dataKeluarga = filteredData.slice(start, end);
    },
    confirmDelete(id) {
      this.selectedId = id;
      this.dialog = true;
    },
    closeDialog() {
      this.dialog = false;
      this.selectedId = null;
    },
    async deleteData(id) {
      this.selectedId = id;
      try {
        await axios.delete(
          `/api/deleteKeluarga/${this.selectedId}`
        ); // Ganti dengan endpoint yang sesuai
        this.load();
        this.getKeluarga();
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
    resetSearch() {
      this.search = '';
      this.$router.replace({
        path: this.$route.path,
        query: {}
      });
      this.getKeluarga();
    },
    toCapitalize(str) {
      if (!str) return '';
      return str.toLowerCase().replace(/(?:^|\s)\w/g, function(match) {
        return match.toUpperCase();
      });
    }
  },
  created(){
    this.load();
  }
}
</script>
