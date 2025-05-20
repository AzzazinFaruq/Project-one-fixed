<template>
  <v-container class="pa-0 pa-sm-3">
    <v-stepper
      alt-labels
      hide-actions
      v-model="step"
      :items="['Input Data Keluarga', 'Input Data Kepala Keluarga']"
    >
      <template v-slot:item.1>
        <v-form ref="keluargaForm" v-model="isFormValid" @submit.prevent="post" class="ma-2 pa-2 pa-sm-4">
          <!-- Form KK dan NIK -->
          <v-row class="form-row">
            <v-col cols="12" sm="6" class="form-col">
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
            <v-col cols="12" sm="6" class="form-col">
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
          <v-col cols="12" class="form-col">
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
          </v-col>

          <v-col cols="12" class="form-col">
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
          </v-col>

          <!-- RT/RW dan Kode Pos -->
          <v-row class="form-row">
            <v-col cols="12" sm="4" class="form-col">
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
            <v-col cols="12" sm="4" class="form-col">
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
            <v-col cols="12" sm="4" class="form-col">
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
          <v-col cols="12" class="form-col">
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
          </v-col>

          <!-- Map -->
          <v-col cols="12" class="form-col">
            <label>Lokasi</label>
            <div style="height: 400px; position: relative;" class="mt-3 mb-4">
              <l-map
                ref="map"
                v-model:zoom="zoom"
                :center="center"
                :use-global-leaflet="false"
                @click="handleMapClick"
              >
                <l-tile-layer
                  url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                />
                <l-marker
                  v-if="form.latitude && form.longtitude"
                  :lat-lng="[form.latitude, form.longtitude]"
                  draggable
                  @dragend="handleMarkerDrag"
                />
              </l-map>
              <v-btn
                color="primary"
                size="small"
                class="get-location-btn"
                @click="getCurrentLocation"
              >
                <v-icon>mdi-crosshairs-gps</v-icon>
                Lokasi Saat Ini
              </v-btn>
            </div>
          </v-col>

          <!-- Latitude/Longitude -->
          <v-row class="form-row">
            <v-col cols="12" sm="6" class="form-col">
              <v-text-field
                v-model="form.latitude"
                label="Latitude"
                type="number"
                step="0.000001"
                variant="outlined"
                :rules="[rules.required]"
                required
              />
            </v-col>
            <v-col cols="12" sm="6" class="form-col">
              <v-text-field
                v-model="form.longtitude"
                label="Longitude"
                type="number"
                step="0.000001"
                variant="outlined"
                :rules="[rules.required]"
                required
              />
            </v-col>
          </v-row>

          <!-- File Uploads -->
          <v-row class="form-row">
            <v-col cols="12" sm="6" class="form-col">
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
            <v-col cols="12" sm="6" class="form-col">
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

          <!-- Buttons -->
          <div class="d-flex justify-end button-group">
            <v-btn
              height="60"
              width="150"
              prepend-icon="mdi-close"
              class="mt-4 mr-2 action-button"
              elevation="2"
              color="red"
              @click="back"
            >
              Batal
            </v-btn>
            <v-btn
              height="60"
              width="150"
              prepend-icon="mdi-content-save"
              class="mt-4 action-button"
              type="submit"
              elevation="2"
              color="green"
              @click="post"
            >
              Simpan
            </v-btn>
          </div>
        </v-form>
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
import 'leaflet/dist/leaflet.css'
import { LMap, LTileLayer, LMarker } from "@vue-leaflet/vue-leaflet";

export default {
  components: {
    formPenduduk,
    LMap,
    LTileLayer,
    LMarker
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
        latitude: '',
        longtitude: '',
      },
      rules: {
        required: (v) => !!v || "Form Tidak Boleh Kosong!",
      },
      zoom: 18,
      center: [-6.2088, 106.8456],
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

    handleMapClick(event) {
      const { lat, lng } = event.latlng;
      this.form.latitude = lat;
      this.form.longtitude = lng;
      this.center = [lat, lng];
      this.zoom = 18;
    },

    handleMarkerDrag(event) {
      const { lat, lng } = event.target.getLatLng();
      this.form.latitude = lat;
      this.form.longtitude = lng;
      this.center = [lat, lng];
      this.zoom = 18;
    },

    getCurrentLocation() {
      if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(
          position => {
            const { latitude, longitude, accuracy } = position.coords;
            this.form.latitude = latitude;
            this.form.longtitude = longitude;
            this.center = [latitude, longitude];

            if (accuracy < 100) {
              this.zoom = 18;
            } else if (accuracy < 500) {
              this.zoom = 16;
            } else {
              this.zoom = 14;
            }

            if (this.$refs.map) {
              this.$refs.map.leafletObject.setView([latitude, longitude], this.zoom);
            }
          },
          error => {
            console.error("Error getting location:", error);
            Swal.fire({
              title: 'Error!',
              text: 'Tidak dapat mengakses lokasi Anda',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          },
          {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0,
          }
        );
      } else {
        Swal.fire({
          title: 'Error!',
          text: 'Geolocation tidak didukung di browser ini',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
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

        formData.append('no_kk', this.form.no_kk.toString());
        formData.append('kk_nik', this.form.kk_nik.toString());
        formData.append('kk_nama', this.form.kk_nama);
        formData.append('alamat', this.form.alamat);
        formData.append('rt', this.form.rt.toString());
        formData.append('rw', this.form.rw.toString());
        formData.append('kode_pos', this.form.kode_pos.toString());
        formData.append('status', this.form.status.toString());
        formData.append('user_id', this.form.user_id.toString());

        formData.append('latitude', Number(this.form.latitude).toString());
        formData.append('longtitude', Number(this.form.longtitude).toString());

        if (this.form.foto_kk) {
          formData.append('foto_kk', this.form.foto_kk, this.form.foto_kk.name);
        }
        if (this.form.foto_rumah) {
          formData.append('foto_rumah', this.form.foto_rumah, this.form.foto_rumah.name);
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
    if (this.previewKK) URL.revokeObjectURL(this.previewKK);
    if (this.previewRumah) URL.revokeObjectURL(this.previewRumah);
  },
};
</script>

<style scoped lang="scss">
.form-row {
  display: flex;
  flex-wrap: wrap;
  margin: -8px;
}

.form-col {
  padding: 8px;
}

@media (max-width: 600px) {
  .form-row {
    display: block;
    margin: 0;
  }

  .form-col {
    padding: 4px 0;
    width: 100% !important;
    flex: none !important;
  }

  .v-col-sm-6, .v-col-md-4 {
    flex: 0 0 100% !important;
    max-width: 100% !important;
  }

  .action-button {
    height: 48px !important;
    width: 104px !important;
    font-size: 0.825rem !important;
  }
}

.v-input {
  margin-top: 6px !important;
}

label {
  font-size: 14px;
  font-weight: 600;
}

.get-location-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 1000;
}

.v-img {
  border: 1px solid #ddd;
  border-radius: 8px;
  margin-top: 8px;
}
</style>