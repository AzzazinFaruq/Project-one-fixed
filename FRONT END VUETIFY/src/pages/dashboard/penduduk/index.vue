<template>
  <v-container fluid class="">
    <h1 class="mb-2 ma-3">Data Penduduk</h1>
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
    elevation="5"
    >
      <v-data-table
        :headers="head"
        :items="getitem"
        :search="search"
        :loading="!isLoad"
        :items-per-page="totalData"
        hide-default-footer
      >
      <template v-slot:bottom>
        <VDivider/>
        <div class="ma-2">
          <v-pagination
          v-model="page"
          :length="last_page"
          :total-visible="7"
        ></v-pagination>
        </div>
      </template>
        <template v-slot:[`item.actions`]="{ item }">
          <v-icon  class="mr-2" color="success" @click="edit(item.id)"
            >mdi-pencil</v-icon
          >
          <v-icon  class="mr-2" color="red" @click="confirmDelete(item.id)"
            >mdi-delete</v-icon
          >
          <v-icon  color="primary" @click="detail(item.id)">mdi-file</v-icon>
        </template>
        <!-- <template v-slot:item.tgl_lhr="{ value }">
            <v-chip>
              {{ value }}
            </v-chip>
          </template> -->
        <template v-slot:top>
          <v-row class="d-flex ma-1">
            <v-col>
            <div class="d-flex justify-start mb-2">
            <v-btn  href="/dashboard/penduduk/inputPenduduk" compact>Tambah data</v-btn>
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

        </template>
      </v-data-table>
      <v-dialog v-model="dialog" max-width="400px">
        <v-card>
          <v-card-title class="headline">Konfirmasi Penghapusan</v-card-title>
          <v-card-text>Kamu yakin ingin menghapus data ini?</v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="closeDialog"
              >Batal</v-btn
            >
            <v-btn color="red darken-1" text @click="deleteData">Hapus</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="dialDetail" width="1000px">
        <v-card>
          <v-card-title class="headline mt-2">Detail Penduduk</v-card-title>
          <v-card-text>
            <div v-for="data in itemDetail" :key="data.id">
              <v-row>
                <v-col>NIK</v-col>
                <v-col>{{ data[0].nik }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Nomer KK</v-col>
                <v-col>{{ data[0].nomer_kk }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Nama</v-col>
                <v-col>{{ data[0].nama }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Tempat Lahir</v-col>
                <v-col>{{ data[0].tmp_lhr }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Tanggal Lahir</v-col>
                <v-col>{{ data[0].tgl_lhr }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Jenis Kelamin</v-col>
                <v-col>{{ data[0].kelamin }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Status Kawin</v-col>
                <v-col>{{ data[0].stat_kawin }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Hubungan Keluarga</v-col>
                <v-col>{{ data[0].hub_kel }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Warga Negara</v-col>
                <v-col>{{ data[0].warga_neg }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Agama</v-col>
                <v-col>{{ data[0].agama }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Pendidikan</v-col>
                <v-col>{{ data[0].pendidikan }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Pekerjaan</v-col>
                <v-col>{{ data[0].pekerjaan }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Ayah</v-col>
                <v-col>{{ data[0].ayah }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Ibu</v-col>
                <v-col>{{ data[0].ibu }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Kepala Keluarga</v-col>
                <v-col>{{ data[0].kepala_kel }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Nomer HP</v-col>
                <v-col>{{ data[0].no_hp }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Domisili</v-col>
                <v-col>{{ data[0].domisili }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Status</v-col>
                <v-col>{{ data[0].stat }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>User</v-col>
                <v-col>{{ data[0].user_id }}</v-col>
              </v-row>

            </div>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="dialDetail = false"
              >OKE</v-btn
            >
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card>
  </v-container>
</template>
<script>
import axios from "axios";
import { succes } from "./inputPenduduk.vue";
import { test } from '@/stores/restrict';
const use = test();
export default {
  setup(){
    use.setup();
  },
  data() {
    return {
      notif:succes,
      isLoad: false,
      dialog: false,
      dialDetail: false,
      selectedId: null,
      search: "",
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
      totalData:5
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
      this.$router.push(`/dashboard/penduduk/edit/${item}`);
    },
    getPen() {
      this.load();
      try{
        axios
        .get(`/api/penduduk/?page=${this.page}&item=${this.totalData}`)
        .then((response) => {
          console.log(response.data.data.last_page);
          this.getitem = response.data.data.data;
          this.totalPages = response.data.data.total;
          this.last_page = response.data.data.last_page
        })

      }
        catch{

        };
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


  },
  watch:{
    page(){
      this.getPen();
    },
    totalData(){
      this.page=1;
      this.getPen();
    },
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
</style>
