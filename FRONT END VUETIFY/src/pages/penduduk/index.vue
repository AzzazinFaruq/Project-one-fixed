<template>
  <v-container fluid>
    <h1 class="mb-5 ma-3">Data Penduduk</h1>
    <v-card>
      <v-data-table
        :headers="head"
        :items="getitem"
        :search="search"
        :loading="!isLoad"
      >
        <template v-slot:[`item.actions`]="{ item }">
          <v-icon class="mr-2" color="success" @click="edit(item.id)"
            >mdi-pencil</v-icon
          >
          <v-icon class="mr-2" color="red" @click="confirmDelete(item.id)"
            >mdi-delete</v-icon
          >
          <v-icon color="primary" @click="detail(item.id)">mdi-file</v-icon>
        </template>
        <!-- <template v-slot:item.tgl_lhr="{ value }">
            <v-chip>
              {{ value }}
            </v-chip>
          </template> -->
        <template v-slot:top>
          <v-row>
            <v-col>
              <v-btn class="ma-2" href="/penduduk/inputPenduduk" compact
                >Tambah data</v-btn
              ></v-col
            >
            <v-col></v-col>
            <v-col>
              <v-text-field
                density="compact"
                v-model="search"
                variant="outlined"
                label="Search"
                append-inner-icon="mdi-magnify"
                class="ma-2"
              ></v-text-field
            ></v-col>
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
      <v-dialog v-model="dialDetail" max-width="400px">
        <v-card>
          <v-card-title class="headline">Detail Penduduk</v-card-title>
          <v-card-text>
            <div v-for="item in itemDetail" :key="item.id">
              {{ item.nomer_kk }}
              <!-- <p>Nomer KK : {{ item.nomer_kk }}</p>
              <p>Nomer NIK : {{ item.nik }}</p>
              <p>Nama : {{ item.nama }}</p>
              <p>Nama : {{ item.tmp_lhr }}</p>
              <p>Nama : {{ item.tgl_lhr }}</p>
              <p>Nama : {{ item.stat_kawin }}</p>
              <p>Nama : {{ item.hub_kel }}</p>
              <p>Nama : {{ item.nama }}</p> -->
            </div>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="dialDetail = false"
              >Batal</v-btn
            >
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card>
  </v-container>
</template>
<script>
import axios from "axios";
import { useRoute, useRouter } from "vue-router";

export default {
  setup() {
    const router = useRouter();
    return {
      router,
    };
  },
  data() {
    return {
      isLoad: false,
      dialog: false,
      dialDetail: false,
      selectedId: null,
      search: "",
      head: [
        { title: "Nomer KK", value: "nomer_kk" },
        { title: "NIK", value: "nik" },
        { title: "Nama", value: "nama" },
        // { title: "Tempat Lahir", value: "tmp_lhr" },
        // { title: "Tanggal Lahir", value: "tgl_lhr" },
        { title: "Kelamin", value: "kelamin" },
        // { title: "Status Kawin", value: "stat_kawin" },
        // { title: "Hubungan Keluarga", value: "hub_kel" },
        // { title: "Warga Negara", value: "warga_neg" },
        { title: "Agama", value: "agama" },
        // { title: "Pendidikan", value: "pendidikan" },
        // { title: "Pekerjaan", value: "pekerjaan" },
        // { title: "Ayah", value: "ayah" },
        // { title: "Ibu", value: "ibu" },
        // { title: "Kepala Keluarga", value: "kepala_kel" },
        // { title: "No Hp", value: "no_hp" },
        // { title: "Domisili", value: "domisili" },
        { title: "Status", value: "stat" },
        { title: "Action", value: "actions" },
      ],
      name: "",
      getitem: [],
      itemDetail: [],
    };
  },
  mounted() {
    this.getPen();
  },

  methods: {
    edit(item) {
      this.router.push(`/penduduk/edit/${item}`);
    },

    getPen() {
      axios
        .get("http://localhost:8000/api/penduduk")
        .then((response) => {
          // assign state users with response data
          console.log(response.data);
          this.getitem = response.data.data;
        })
        .catch((error) => {
          console.log(error);
          this.router.push("/login");
        });
    },
    deletePenduduk(id) {
      try {
        axios.delete(`http://localhost:8000/api/deletePenduduk/${id}`);
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
          `http://localhost:8000/api/deletePenduduk/${this.selectedId}`
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
        axios.get(`http://localhost:8000/api/penduduk/${id}`).then((res) => {
          this.itemDetail = res.data;
          console.log(this.itemDetail);
          this.dialDetail = true;
        });
      } catch {}
    },
  },
  created() {
    this.load();
  },
};
</script>
<style>
.iyath {
  width: 200px; /* Contoh mengatur lebar header dengan CSS */
}
</style>
