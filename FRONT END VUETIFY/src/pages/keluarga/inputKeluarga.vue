<template>
  <v-container>
    <v-stepper
      alt-labels
      hide-actions
      v-model="step"
      :items="['Input Data Keluarga', 'Input Data Kepala Keluarga']"
    >
      <template v-slot:item.1>
        <v-form ref="keluargaForm" v-model="isFormValid" @submit.prevent="post">
          <!-- Form KK dan NIK -->
          <v-row>
            <v-col>
              <label>No. Kartu Keluarga</label>
              <v-text-field
                v-model="form.no_kk"
                class="mt-3"
                rounded="lg"
                clearable
                :rules="[rules.required]"
                variant="outlined"
                required
              />
            </v-col>
            <v-col>
              <label>No. Induk Kependudukan (NIK)</label>
              <v-text-field
                v-model="form.kk_nik"
                class="mt-3"
                rounded="lg"
                clearable
                :rules="[rules.required]"
                variant="outlined"
                required
              />
            </v-col>
          </v-row>

          <!-- Nama dan Alamat -->
          <label>Nama Lengkap Kepala Keluarga</label>
          <v-text-field
            v-model="form.kk_nama"
            class="mt-3"
            rounded="lg"
            clearable
            :rules="[rules.required]"
            variant="outlined"
            required
          />

          <label>Alamat</label>
          <v-text-field
            v-model="form.alamat"
            class="mt-3"
            rounded="lg"
            clearable
            :rules="[rules.required]"
            variant="outlined"
            required
          />

          <!-- RT/RW dan Kode Pos -->
          <v-row>
            <v-col>
              <label>RT</label>
              <v-text-field
                v-model="form.rt"
                class="mt-3"
                rounded="lg"
                clearable
                :rules="[rules.required]"
                variant="outlined"
                required
              />
            </v-col>
            <v-col>
              <label>RW</label>
              <v-text-field
                v-model="form.rw"
                class="mt-3"
                rounded="lg"
                clearable
                :rules="[rules.required]"
                variant="outlined"
                required
              />
            </v-col>
            <v-col>
              <label>Kode Pos</label>
              <v-text-field
                v-model="form.kode_pos"
                class="mt-3"
                rounded="lg"
                clearable
                :rules="[rules.required]"
                variant="outlined"
                required
              />
            </v-col>
          </v-row>

          <!-- Status -->
          <label>Status</label>
          <v-select
            v-model="form.status"
            class="mt-3"
            rounded="lg"
            clearable
            :rules="[rules.required]"
            variant="outlined"
            :items="stat"
            item-title="name"
            item-value="id"
            required
          />

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
              <v-img
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
              <v-img
                :src="previewRumah"
                max-height="200"
                contain
                class="mt-2 bg-grey-lighten-2"
              />
            </v-col>
          </v-row>
        </v-form>
          <!-- Buttons -->
          <div class="d-flex justify-end">
            <v-btn
              height="60"
              width="150"
              prepend-icon="mdi-close"
              class="mt-4 mr-2"
              elevation="2"
              color="red"
              text="Batal"
              @click="back"
            />
            <v-btn
              height="60"
              width="150"
              prepend-icon="mdi-content-save"
              class="mt-4"
              type="submit"
              elevation="2"
              color="green"
              text="Simpan"
              @click="post"
            />
          </div>
      </template>

      <template v-slot:item.2>
        <formPenduduk />
      </template>
    </v-stepper>
  </v-container>
</template>

<script>
import axios from "axios";
import { useRouter } from "vue-router";
import { useCons } from "@/stores/constant";
import { test } from '@/stores/restrict';
import formPenduduk from "@/components/formPenduduk.vue";
import Swal from 'sweetalert2';

export default {
  components: {
    formPenduduk
  },

  setup() {
    const use = test();
    use.setup();
    const useData = useCons();
    const router = useRouter();
    return { useData, router };
  },

  data() {
    return {
      step: 1,
      isFormValid: false,
      stat: this.useData.stat,
      previewKK: null,
      previewRumah: null,
      form: {
        no_kk: "",
        kk_nik: "",
        kk_nama: "",
        alamat: "",
        rt: "",
        rw: "",
        kode_pos: "",
        status: "",
        user_id: "",
        foto_kk: null,
        foto_rumah: null,
      },
      rules: {
        required: (v) => !!v || "Form Tidak Boleh Kosong!",
      }
    };
  },

  mounted() {
    this.getUserId();
  },

  methods: {
    getUserId() {
      axios.get("/api/user")
        .then(res => {
          this.form.user_id = res.data.data.Id;
        })
        .catch(error => console.error("Error fetching user:", error));
    },

    back() {
      this.router.push('/keluarga');
    },

    previewFile(file, previewType) {
      if (!file) {
        this[previewType] = null;
        return;
      }
      this[previewType] = URL.createObjectURL(file);
    },

    async post() {
      if (!this.$refs.keluargaForm.validate()) {
        Swal.fire({
          title: 'Error!',
          text: 'Semua field wajib diisi dengan benar',
          icon: 'error',
          confirmButtonText: 'OK'
        });
        return;
      }

      try {
        const formData = new FormData();

        // Tambahkan data form satu per satu untuk memastikan data terkirim dengan benar
        formData.append('no_kk', this.form.no_kk.toString());
        formData.append('kk_nik', this.form.kk_nik.toString());
        formData.append('kk_nama', this.form.kk_nama);
        formData.append('alamat', this.form.alamat);
        formData.append('rt', this.form.rt.toString());
        formData.append('rw', this.form.rw.toString());
        formData.append('kode_pos', this.form.kode_pos.toString());
        formData.append('status', this.form.status.toString());
        formData.append('user_id', this.form.user_id.toString());

        // Tambahkan file dengan nama yang sesuai
        if (this.form.foto_kk) {
          formData.append('foto_kk', this.form.foto_kk, this.form.foto_kk.name);
        }
        if (this.form.foto_rumah) {
          formData.append('foto_rumah', this.form.foto_rumah, this.form.foto_rumah.name);
        }

        // Tambahkan log untuk memeriksa data yang akan dikirim
        for (let [key, value] of formData.entries()) {
          console.log(`${key}: ${value}`);
        }

        const response = await axios.post('/api/addkeluarga', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });

        this.step = 2;
        Swal.fire({
          title: 'Berhasil!',
          text: response.data.message,
          icon: 'success',
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
        });

      } catch (error) {
        console.error('Error:', error.response?.data);
        Swal.fire({
          title: 'Error!',
          text: error.response?.data?.error || error.response?.data?.message || 'Terjadi kesalahan sistem',
          icon: 'error',
          confirmButtonText: 'OK'
        });
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

<style scoped>
.v-img {
  border: 1px solid #ddd;
  border-radius: 8px;
  margin-top: 8px;
}

label {
  font-size: 14px;
  font-weight: 600;
}

.v-input {
  margin-top: 10px;
}
</style>
