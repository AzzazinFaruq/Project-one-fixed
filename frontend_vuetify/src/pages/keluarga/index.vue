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
  <div class="d-flex flex-nowrap"> <!-- Tambahkan wrapper div dengan flex -->
    <v-chip 
      class="px-3" 
      color="#2184D8" 
      variant="flat" 
      style="font-size: 12px; white-space: nowrap;" 
      @click="edit(item.id)"
    >
      Lihat Detail
    </v-chip>
    <v-chip 
      class="px-3 ml-2" 
      color="brown" 
      variant="flat" 
      style="font-size: 12px; white-space: nowrap;" 
      @click="plusAnggota(item.id)"
    >
      + Anggota
    </v-chip>
  </div>
</template>
        <template v-slot:[`item.status`]="{ item }">
          <v-chip
            style="font-size: 12px;"
            :color="item.status.toLowerCase() === 'aktif' ? 'success' : 'error'"
            :text-color="white"
          >
            {{ item.status }}
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
    <!-- Tambahkan dialog form -->
    <v-dialog v-model="dialogAddAnggota" max-width="700px">
      <v-card>
        <v-card-title class="text-h6 pa-4 d-flex justify-space-between">
          <span>Tambah Anggota Keluarga</span>
          <v-btn
            icon="mdi-plus"
            size="small"
            color="primary"
            @click="tambahFormAnggota"
          ></v-btn>
        </v-card-title>
        <v-card-text>
          <v-form @submit.prevent="submitAnggota">
            <div v-for="(anggota, index) in formAnggota" :key="index" class="mb-4">
              <div class="d-flex justify-space-between align-center mb-2">
                <span class="text-subtitle-1">Anggota #{{index + 1}}</span>
                <v-btn
                  v-if="index > 0"
                  icon="mdi-delete"
                  size="small"
                  color="error"
                  variant="text"
                  @click="hapusFormAnggota(index)"
                ></v-btn>
              </div>
              <v-text-field
                v-model="anggota.nik"
                label="NIK"
                variant="outlined"
                density="compact"
                class="mb-2"
                type="number"
                :rules="[v => !!v || 'NIK wajib diisi', v => v.length === 16 || 'NIK harus 16 digit']"
              ></v-text-field>
              <v-text-field
                v-model="anggota.nama"
                label="Nama Anggota"
                variant="outlined"
                density="compact"
                class="mb-2"
                :rules="[v => !!v || 'Nama wajib diisi']"
              ></v-text-field>
              <v-select
                v-model="anggota.hub_kel"
                :items="hubunganItems"
                label="Hubungan Keluarga"
                item-title="name"
                item-value="id"
                variant="outlined"
                density="compact"
                class="mb-2"
                :rules="[v => !!v || 'Hubungan keluarga wajib diisi']"
              ></v-select>
              <v-divider v-if="index < formAnggota.length - 1" class="mt-4"></v-divider>
            </div>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="error" variant="text" @click="tutupDialog">Batal</v-btn>
          <v-btn color="primary" variant="text" @click="submitAnggota">Simpan</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import axios from 'axios';
import { test } from '@/stores/restrict';
import { useCons } from '@/stores/constant';
const useData = useCons();
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
      totalData:8,
      dialogAddAnggota: false,
      selectedKelsId: null,
      formAnggota: [],
      hubunganItems: useData.hubungan,
      user_id:null,
    }
  },
  mounted(){
    this.getKeluarga();
    this.inputter();

  },
  methods :{
    inputter(){
      axios.get("api/user")
      .then((res)=>{
        this.user_id=res.data.data.Id;
      })
    },
    buatFormKosong() {
      return {
        nik: '',
        nama: '',
        hub_kel: '',
        tgl_lhr: new Date().toISOString().split('T')[0], // Format YYYY-MM-DD
        kels_id: this.selectedKelsId,
        user_id: this.user_id,
        stat: 2
      }
    },
    plusAnggota(id) {
      this.selectedKelsId = id;
      this.formAnggota = [this.buatFormKosong()];
      this.dialogAddAnggota = true;
    },
    tambahFormAnggota() {
      this.formAnggota.push(this.buatFormKosong());
    },
    hapusFormAnggota(index) {
      this.formAnggota.splice(index, 1);
    },
    tutupDialog() {
      this.dialogAddAnggota = false;
      this.formAnggota = [];
      this.selectedKelsId = null;
    },
    async submitAnggota() {
      try {
        // Validasi form
        const formValid = this.formAnggota.every(anggota =>
          anggota.nik &&
          anggota.nama &&
          anggota.hub_kel &&
          anggota.tgl_lhr
        );

        if (!formValid) {
          alert('Mohon lengkapi semua data yang wajib diisi');
          return;
        }

        // Kirim data
        for (const anggota of this.formAnggota) {
          const payload = {
            nik: parseInt(anggota.nik),
            nama: anggota.nama,
            hub_kel: anggota.hub_kel,
            tgl_lhr: anggota.tgl_lhr + 'T00:00:00Z',
            kels_id: this.selectedKelsId,
            user_id: this.user_id,
            stat: anggota.stat
          };

          await axios.post('/api/addpenduduk', payload);
        }

        this.tutupDialog();
        this.getKeluarga();

      } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan data');
      }
    },
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

<style scoped>
/* Pastikan tombol tidak wrap dan tetap inline */
.d-flex.flex-nowrap {
  flex-wrap: nowrap !important;
  overflow-x: auto; /* Untuk scroll horizontal jika sangat sempit */
}

/* Hilangkan margin-right di mobile jika perlu */
@media (max-width: 600px) {
  .v-chip {
    min-width: max-content; /* Lebar sesuai teks */
    margin-right: 4px !important; /* Jarak lebih ketat */
  }
}
</style>