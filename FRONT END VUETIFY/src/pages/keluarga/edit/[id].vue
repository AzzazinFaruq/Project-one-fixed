<template lang="">
  <v-container class="">
    <v-card rounded="lg" class="pa-4" elevation="0" max-width=""
      >
      <v-form class="ma-2" @submit.prevent="post(form.id)">
        <v-row>
          <v-col>
        <label for="">No. Kartu Keluarga</label>
        <v-text-field
          class="mt-3"
          rounded="lg"
          clearable
          :rules="rules"
          variant="outlined"
          v-model="form.no_kk"
          required
        ></v-text-field>
        </v-col>
        <v-col>
        <label for="">No. Induk Kependudukan (NIK)</label>
        <v-text-field
          class="mt-3"
          rounded="lg"
          clearable
          :rules="rules"
          variant="outlined"
          v-model="form.kk_nik"
          required
        ></v-text-field>
        </v-col>
      </v-row>
        <label for="">Nama Lengkap Kepala Keluarga</label>
        <v-text-field
          class="mt-3"
          rounded="lg"
          clearable
          :rules="rules"
          variant="outlined"
          v-model="form.kk_nama"
          required
        ></v-text-field>
        <label for="">Alamat</label>
        <v-text-field
          clearable
          class="mt-3"
          rounded="lg"
          :rules="rules"
          variant="outlined"
          v-model="form.alamat"
          required
        ></v-text-field>
        <v-row>
        <v-col>
        <label for="">RT</label>
        <v-text-field
          clearable
          :rules="rules"
          class="mt-3"
          rounded="lg"
          variant="outlined"
          v-model="form.rt"
          required
        ></v-text-field>
        </v-col>
        <v-col>
        <label for="">RW</label>
        <v-text-field
          clearable
          :rules="rules"
          class="mt-3"
          rounded="lg"
          variant="outlined"
          v-model="form.rw"
          required
        ></v-text-field>
        </v-col>
        <v-col>
          <label for="">Kode Pos</label>
        <v-text-field
          clearable
          :rules="rules"
          class="mt-3"
          rounded="lg"
          variant="outlined"
          v-model="form.kode_pos"
          required
        ></v-text-field>
        </v-col>
      </v-row>

        <label for="">Status</label>
       <v-select
            class="mt-3"
          rounded="lg"
          clearable
          :rules="rules"
          variant="outlined"
          :items="stat"
          item-title="name"
          item-value="id"
          required
          v-model="form.status"
       ></v-select>

        <!-- Upload Files -->
        <v-row>
          <v-col>
            <label>Foto KK</label>
            <v-file-input
              v-model="form.foto_kk"
              class="mt-3"
              rounded="lg"
              variant="outlined"
              accept="image/*"
              prepend-icon=""
              label="Pilih file"
              :rules="[v => !!v || 'Foto KK diperlukan']"
              @update:model-value="previewFile($event, 'previewKK')"
              required
            />
            <!-- Tampilkan gambar dari database jika ada -->
            <v-img
              v-if="form.foto_kk && typeof form.foto_kk === 'string'"
              :src="`${baseURL}/${form.foto_kk}`"
              max-height="200"
              contain
              class="mt-2 bg-grey-lighten-2"
            />
            <!-- Tampilkan preview untuk file baru -->
            <v-img
              v-else-if="previewKK"
              :src="previewKK"
              max-height="200"
              contain
              class="mt-2 bg-grey-lighten-2"
            />
          </v-col>
          <v-col>
            <label>Foto Rumah</label>
            <v-file-input
              v-model="form.foto_rumah"
              class="mt-3"
              rounded="lg"
              variant="outlined"
              accept="image/*"
              prepend-icon=""
              label="Pilih file"
              :rules="[v => !!v || 'Foto Rumah diperlukan']"
              @update:model-value="previewFile($event, 'previewRumah')"
              required
            />
            <!-- Tampilkan gambar dari database jika ada -->
            <v-img
              v-if="form.foto_rumah && typeof form.foto_rumah === 'string'"
              :src="`${baseURL}/${form.foto_rumah}`"
              max-height="200"
              contain
              class="mt-2 bg-grey-lighten-2"
            />
            <!-- Tampilkan preview untuk file baru -->
            <v-img
              v-else-if="previewRumah"
              :src="previewRumah"
              max-height="200"
              contain
              class="mt-2 bg-grey-lighten-2"
            />
          </v-col>
        </v-row>
      </v-form>
      <div class="d-flex justify-end">
          <v-btn
            height="60"
            width="150"
            prepend-icon="mdi-delete"
            class="mt-4 mr-2"
            type="submit"
            elevation="2"
            color="red"
            text="Hapus"
            @click="deletePenduduk(form.id)"
            ></v-btn
          >
          <v-btn
            height="60"
            width="150"
            prepend-icon="mdi-content-save"
            class="mt-4"
            type="submit"
            elevation="2"
            color="green"
            text="Simpan"
            @click="post(form.id)"
            ></v-btn
          >
        </div>
    </v-card>
  </v-container>
</template>
<script>
import axios from "axios";
import { useRoute } from "vue-router";
import { useCons } from "@/stores/constant";
import { test } from '@/stores/restrict';
import Swal from 'sweetalert2';
const use = test();
const useData = useCons();
export default {
  setup() {
    use.setup();
    const useData = useCons();
    return {
      useData,
    };
  },
  data() {
    return {
      kelamin: useData.kelamin,
      statusKawin: useData.statusKawin,
      hubungan: useData.hubungan,
      warga: useData.warga,
      agama: useData.agama,
      pendidikan: useData.pendidikan,
      pekerjaan: useData.pekerjaan,
      stat: useData.stat,
      user:[],
      form: {
        no_kk: "",
        kk_nik: "",
        kk_nama: "",
        alamat: "",
        rt: "",
        rw: "",
        kode_pos: "",
        status: "",
        user_id:'',
        foto_kk: null,
        foto_rumah: null,
      },
      baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8080',
      previewKK: null,
      previewRumah: null,
      rules: [(v) => !!v || "Form Tidak Boleh Kosong!"],
    };
  },
  mounted() {
    this.get();
  },

  methods: {
    get() {
      const route = useRoute();
      try {
        axios.get(`/api/keluarga/${route.params.id}`)
        .then((res)=>{
          this.form =  res.data.data;

          // Simpan path file yang ada
          if (this.form.foto_kk && typeof this.form.foto_kk === 'string') {
            this.existingFotoKK = this.form.foto_kk;
          }
          if (this.form.foto_rumah && typeof this.form.foto_rumah === 'string') {
            this.existingFotoRumah = this.form.foto_rumah;
          }
        })
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    },
    getUser(){
      try{
        axios.get("/api/user")
        .then((res)=>{
          this.user=res.data;
          this.form.user_id=res.data.data.id
          console.log(res.data.data.id)
        })
      }
      catch(error){
        return error;
      }
    },
    deletePenduduk(id){
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`/api/deletekeluarga/${id}`)
            .then((res) => {
              Swal.fire({
                title: 'Terhapus!',
                text: 'Data berhasil dihapus',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
              }).then(() => {
                this.$router.push('/keluarga');
              });
            });
        }
      });
    },
    previewFile(file, previewType) {
      if (!file) {
        this[previewType] = null;
        return;
      }
      // Jika file adalah objek File (file baru), buat preview
      if (file instanceof File) {
        this[previewType] = URL.createObjectURL(file);
      }
    },
    post(id) {
      try {
        const formData = new FormData();

        formData.append('no_kk', this.form.no_kk.toString());
        formData.append('kk_nik', this.form.kk_nik.toString());
        formData.append('kk_nama', this.form.kk_nama);
        formData.append('alamat', this.form.alamat);
        formData.append('rt', this.form.rt.toString());
        formData.append('rw', this.form.rw.toString());
        formData.append('kode_pos', this.form.kode_pos.toString());
        formData.append('status', this.form.status.toString());
        formData.append('user_id', this.form.user_id.toString());

        // Tambahkan semua field non-file
        Object.keys(this.form).forEach(key => {
          if (key !== 'foto_kk' && key !== 'foto_rumah') {
            formData.append(key, this.form[key]);
          }
        });

        // Tambahkan file hanya jika ada file baru
        if (this.form.foto_kk instanceof File) {
          formData.append('foto_kk', this.form.foto_kk);
        }
        if (this.form.foto_rumah instanceof File) {
          formData.append('foto_rumah', this.form.foto_rumah);
        }

        const response = axios.put(`/api/editkeluarga/${id}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });

        // ... kode response handling ...
      } catch (error) {
        // ... kode error handling ...
      }
    },
  },
  beforeUnmount() {
    // Bersihkan URL objek untuk mencegah memory leak
    if (this.previewKK) URL.revokeObjectURL(this.previewKK);
    if (this.previewRumah) URL.revokeObjectURL(this.previewRumah);
  },
};
</script>
<style scoped lang="scss">
.v-input{
  margin-top: 10px;
}
label{
  font-size: 14px;
  font-weight: 600;
}
</style>

