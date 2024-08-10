<template>
  <v-container>
    <h1>Data Keluarga</h1>
<v-card class="mt-3">
  <v-data-table
  :headers="head"
  :items="dataKeluarga"
  :search="search"
  :loading="!isLoad"
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
  <v-icon  class="mr-2" color="success" @click="edit(item.id)">mdi-pencil</v-icon>
  <v-icon  class="mr-2" color="red" @click="confirmDelete(item.id)">mdi-delete</v-icon>
  <v-icon  color="primary" @click="detail(item.id)">mdi-file</v-icon>
</template>
<template v-slot:top>
  <v-row class="ma-1">
    <v-col>
      <v-btn class="" color="white" href="/dashboard/keluarga/inputKeluarga">Tambah Keluarga</v-btn>
    </v-col>
    <VSpacer/>
            <v-col>
              <v-row class="">
                <v-col>
                <v-select
                :items="[5,10,20,50,100]"
                v-model="totalData"
                variant="outlined"
                label="Items Per Page"
                density="compact"
              ></v-select>
                </v-col>
                <v-col>
                <v-text-field
                density="compact"
                v-model="search"
                variant="outlined"
                label="Search"
                append-inner-icon="mdi-magnify"
                class=""
              ></v-text-field>
                </v-col>
              </v-row>
            </v-col>
  </v-row>
</template>
</v-data-table>
<v-dialog v-model="dialDetail" max-width="400px">
        <v-card>
          <v-card-title class="headline mt-2">Detail Penduduk</v-card-title>
          <v-card-text>
            <div v-for="data in detailKeluarga" :key="data.id">
              <v-row>
                <v-col>Nomer KK</v-col>
                <v-col>{{ data.no_kk }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>NIK</v-col>
                <v-col>{{ data.kk_nik }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Nama</v-col>
                <v-col>{{ data.kk_nama}}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>RT</v-col>
                <v-col>{{ data.rt }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>RW</v-col>
                <v-col>{{ data.rw }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Kode Pos</v-col>
                <v-col>{{ data.kode_pos }}</v-col>
              </v-row>
              <v-divider class="my-2"></v-divider>
              <v-row>
                <v-col>Status</v-col>
                <v-col>{{ data.status }}</v-col>
              </v-row>
              <v-row>
                <v-col>User</v-col>
                <v-col>{{ data.user_name }}</v-col>
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
<v-dialog v-model="dialog" max-width="400px">
        <v-card>
          <v-card-title class="headline">Konfirmasi Penghapusan</v-card-title>
          <v-card-text>Kamu yakin ingin menghapus data ini?</v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="closeDialog"
              >Batal</v-btn
            >
            <v-btn color="red darken-1" text @click="deleteData(selectedId)">Hapus</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
  </v-container>
</template>
<script>
import axios from 'axios';
import { test } from '@/stores/restrict';
const use = test();
export default{
  setup(){
    use.setup();
  },
  watch:{
    page(){
      this.getKeluarga();
    },
    totalData(){
      this.page=1;
      this.getKeluarga();
    },
  },
  data(){
    return{
      isLoad:false,
      dialDetail: false,
      dialog:false,
      selectedId:null,
      dataKeluarga:[],
      detailKeluarga:[],
      search:"",
      head: [
        { title: "Nomer KK", value: "no_kk" },
        { title: "Nama", value: "kk_nama" },
        { title: "Status", value: "status" },
        { title: "User", value: "user_id" },
        { title: "Action", value: "actions" },
      ],
      page: 1,
      last_page:0,
      totalData:5
    }
  },
  mounted(){
    this.getKeluarga();

  },
  methods :{
    edit(item) {
      this.$router.push(`/dashboard/keluarga/edit/${item}`);
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
        axios.get(`/api/keluarga/?page=${this.page}&item=${this.totalData}`)
        .then((res)=>{
          console.log(res.data)
          this.dataKeluarga=res.data.data;
          this.totalPages = res.data.total;
          this.last_page = res.data.last_page;
        })

      }
      catch(error){
        return error;
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
  },
  created(){
    this.load();
  }
}
</script>
