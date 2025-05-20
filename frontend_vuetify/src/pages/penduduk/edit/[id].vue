<template>
  <v-container class="pa-0 pa-sm-3">
    <v-card class="mx-auto" elevation="4" max-width="1200">
      <v-form class="ma-2 pa-2 pa-sm-4" @submit.prevent="post(form.id)">
        <!-- Keluarga & NIK -->
        <v-row class="form-row">
          <v-col cols="12" sm="6" class="form-col">
            <label>Keluarga</label>
            <v-autocomplete
              class="mt-3"
              rounded="lg"
              :item-props="itemProps"
              :rules="rules"
              :items="dataKel"
              item-title="kels_id"
              item-value="id"
              v-model="form.kels_id"
              variant="outlined"
              required
            ></v-autocomplete>
          </v-col>
          <v-col cols="12" sm="6" class="form-col">
            <label>NIK</label>
            <v-text-field
              class="mt-3"
              rounded="lg"
              clearable
              :rules="rules"
              variant="outlined"
              v-model="form.nik"
              required
            ></v-text-field>
          </v-col>
        </v-row>

        <!-- Nama Lengkap -->
        <v-col cols="12" class="form-col">
          <label>Nama Lengkap</label>
          <v-text-field
            class="mt-3"
            rounded="lg"
            clearable
            :rules="rules"
            variant="outlined"
            v-model="form.nama"
            required
          ></v-text-field>
        </v-col>

        <!-- Tempat & Tanggal Lahir -->
        <v-row class="form-row">
          <v-col cols="12" sm="6" class="form-col">
            <label>Tempat Lahir</label>
            <v-text-field
              class="mt-3"
              rounded="lg"
              clearable
              :rules="rules"
              variant="outlined"
              required
              v-model="form.tmp_lhr"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" class="form-col">
            <label>Tanggal Lahir</label>
            <v-date-input
              class="mt-3"
              rounded="lg"
              clearable
              :rules="rules"
              variant="outlined"
              :prepend-icon="null"
              :append-icon="null"
              required
              v-model="form.tgl_lhr"
            ></v-date-input>
          </v-col>
        </v-row>

        <!-- Jenis Kelamin, Status Kawin, Hubungan Keluarga -->
        <v-row class="form-row">
          <v-col cols="12" sm="6" md="4" class="form-col">
            <label>Jenis Kelamin</label>
            <v-autocomplete
              class="mt-3"
              rounded="lg"
              :rules="rules"
              :items="kelamin"
              item-title="name"
              item-value="id"
              v-model="form.kelamin"
              variant="outlined"
              required
            ></v-autocomplete>
          </v-col>
          <v-col cols="12" sm="6" md="4" class="form-col">
            <label>Status Kawin</label>
            <v-autocomplete
              class="mt-3"
              rounded="lg"
              :rules="rules"
              variant="outlined"
              :items="statusKawin"
              item-title="name"
              item-value="id"
              required
              v-model="form.stat_kawin"
            ></v-autocomplete>
          </v-col>
          <v-col cols="12" sm="6" md="4" class="form-col">
            <label>Hubungan Keluarga</label>
            <v-autocomplete
              class="mt-3"
              rounded="lg"
              :rules="rules"
              variant="outlined"
              :items="hubungan"
              item-title="name"
              item-value="id"
              required
              v-model="form.hub_kel"
            ></v-autocomplete>
          </v-col>
        </v-row>

        <!-- Warga Negara & Agama -->
        <v-row class="form-row">
          <v-col cols="12" sm="6" class="form-col">
            <label>Warga Negara</label>
            <v-autocomplete
              class="mt-3"
              rounded="lg"
              :rules="rules"
              variant="outlined"
              :items="warga"
              item-title="name"
              item-value="id"
              required
              v-model="form.warga_neg"
            ></v-autocomplete>
          </v-col>
          <v-col cols="12" sm="6" class="form-col">
            <label>Agama</label>
            <v-autocomplete
              class="mt-3"
              rounded="lg"
              :rules="rules"
              variant="outlined"
              :items="agama"
              item-title="name"
              item-value="id"
              required
              v-model="form.agama"
            ></v-autocomplete>
          </v-col>
        </v-row>

        <!-- Pendidikan & Pekerjaan -->
        <v-row class="form-row">
          <v-col cols="12" sm="6" class="form-col">
            <label>Pendidikan</label>
            <v-autocomplete
              class="mt-3"
              rounded="lg"
              :rules="rules"
              variant="outlined"
              :items="pendidikan"
              item-title="name"
              item-value="id"
              required
              v-model="form.pendidikan"
            ></v-autocomplete>
          </v-col>
          <v-col cols="12" sm="6" class="form-col">
            <label>Pekerjaan</label>
            <v-autocomplete
              class="mt-3"
              rounded="lg"
              :rules="rules"
              variant="outlined"
              :items="pekerjaan"
              item-title="name"
              item-value="id"
              required
              v-model="form.pekerjaan"
            ></v-autocomplete>
          </v-col>
        </v-row>

        <!-- Ayah & Ibu -->
        <v-row class="form-row">
          <v-col cols="12" sm="6" class="form-col">
            <label>Ayah</label>
            <v-text-field
              class="mt-3"
              rounded="lg"
              clearable
              :rules="rules"
              variant="outlined"
              required
              v-model="form.ayah"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" class="form-col">
            <label>Ibu</label>
            <v-text-field
              class="mt-3"
              rounded="lg"
              clearable
              :rules="rules"
              variant="outlined"
              required
              v-model="form.ibu"
            ></v-text-field>
          </v-col>
        </v-row>

        <!-- Nomor HP -->
        <v-col cols="12" class="form-col">
          <label>Nomor HP</label>
          <v-text-field
            class="mt-3"
            rounded="lg"
            clearable
            :rules="rules"
            variant="outlined"
            required
            v-model="form.no_hp"
          ></v-text-field>
        </v-col>

        <!-- Domisili & Status -->
        <v-row class="form-row">
          <v-col cols="12" sm="6" class="form-col">
            <label>Domisili</label>
            <v-select
              class="mt-3"
              rounded="lg"
              clearable
              :rules="rules"
              variant="outlined"
              :items="domisili"
              item-title="name"
              item-value="id"
              required
              v-model="form.domisili"
            ></v-select>
          </v-col>
          <v-col cols="12" sm="6" class="form-col">
            <label>Status</label>
            <v-select
              class="mt-3"
              rounded="lg"
              :rules="rules"
              variant="outlined"
              :items="stat"
              item-title="name"
              item-value="id"
              required
              v-model="form.status"
            ></v-select>
          </v-col>
        </v-row>

        <!-- Tombol Aksi -->
        <div class="d-flex justify-end button-group">
          <v-btn
            height="60"
            width="150"
            prepend-icon="mdi-delete"
            class="mt-4 mr-2 action-button"
            type="submit"
            elevation="2"
            color="red"
            @click="deletePenduduk(form.id)"
          >
            Hapus
          </v-btn>
          <v-btn
            height="60"
            width="150"
            prepend-icon="mdi-content-save"
            class="mt-4 action-button"
            type="submit"
            elevation="2"
            color="green"
            @click="post(form.id)"
          >
            Simpan
          </v-btn>
        </div>
      </v-form>
    </v-card>
  </v-container>
</template>

<script>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRouter, useRoute, RouterLink } from "vue-router";
import { useCons } from "@/stores/constant";
import { test } from '@/stores/restrict';
import Swal from 'sweetalert2';
const use = test();
const useData = useCons();

export default {
  setup() {
    use.setup();
    const useData = useCons();
    const router = useRouter();

    return {
      useData,
      router,
    };
  },
  data() {
    return {
      dataKel: [],
      domisili: useData.domisili,
      kelamin: useData.kelamin,
      statusKawin: useData.statusKawin,
      hubungan: useData.hubungan,
      warga: useData.warga,
      agama: useData.agama,
      pendidikan: useData.pendidikan,
      pekerjaan: useData.pekerjaan,
      stat: useData.stat,
      form: {
        kels_id:'',
        nik: "",
        nama: "",
        tmp_lhr: "",
        tgl_lhr: new Date(),
        kelamin: "",
        stat_kawin: "",
        hub_kel: "",
        warga_neg: "",
        agama: "",
        pendidikan: "",
        pekerjaan: "",
        ayah: "",
        ibu: "",
        no_hp: "",
        domisili:"",
        status: "",
        user_id:'',
        id:''
      },
      rules: [(v) => !!v || "Wajib Diisi!"],
    };
  },
  mounted() {
    this.get();
  },
  setup() {},
  methods: {
    deletePenduduk(id){
      axios.delete(`/api/deletependuduk/${id}`)
      .then((res)=>{
        Swal.fire({
          title: 'Berhasil!',
          text: 'Data berhasil dihapus',
          icon: 'success',
          confirmButtonText: 'OK'
        });
        this.$router.push('/penduduk');
      });
    },
    getKeluarga(){
      try{
        axios.get("/api/keluarga")
        .then((res)=>{
          this.dataKel=res.data.data;
          console.log(this.dataKel);
        })

      }
      catch(error){
        return error;
      }
    },
    get() {
      this.getKeluarga();
      try {
        const route = useRoute();
        axios
          .get(`/api/penduduk/${route.params.id}`)
          .then((response) => {
            console.log(response.data);
            this.form = response.data.data;
            this.form.tgl_lhr = new Date(response.data.data.tgl_lhr);
            console.log(this.form);
            // this.form.value = response.data;
          });
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    },
    post(id) {
      try {
        // Format tanggal dengan timezone Asia/Jakarta
        let date = new Date(this.form.tgl_lhr);
        let tzOffset = "+07:00";

        const formData = {
          ...this.form,
          // Konversi tanggal
          tgl_lhr: date.getFullYear() + '-' +
            String(date.getMonth() + 1).padStart(2, '0') + '-' +
            String(date.getDate()).padStart(2, '0') + 'T' +
            String(date.getHours()).padStart(2, '0') + ':' +
            String(date.getMinutes()).padStart(2, '0') + ':' +
            String(date.getSeconds()).padStart(2, '0') +
            tzOffset,
          // Konversi field-field ke number
          nik: Number(this.form.nik),
          agama: Number(this.form.agama),
          user_id: Number(this.form.user_id),
          kelamin: Number(this.form.kelamin),
          stat_kawin: Number(this.form.stat_kawin),
          hub_kel: Number(this.form.hub_kel),
          warga_neg: Number(this.form.warga_neg),
          pendidikan: Number(this.form.pendidikan),
          pekerjaan: Number(this.form.pekerjaan),
          domisili: Number(this.form.domisili),
          status: Number(this.form.status),
          kels_id: Number(this.form.kels_id)
        };

        axios.put(`/api/updatependuduk/${id}`, formData)
          .then((res) => {
            Swal.fire({
              title: 'Berhasil!',
              text: 'Data berhasil diperbarui',
              icon: 'success',
              confirmButtonText: 'OK'
            });
            this.$router.push('/penduduk');
          });
      } catch (error) {
        console.error(error);
      }
    },
    itemProps(item) {
      return {
        title: item.no_kk + ' [' + item.kk_nama + ']'
      }
    }
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
</style>