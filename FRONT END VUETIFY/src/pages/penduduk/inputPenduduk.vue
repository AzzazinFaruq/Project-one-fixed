<template lang="">
  <v-container class="">
    <v-card class="" elevation="4" max-width=""
      >
      <v-form class="ma-2 pa-2" @submit.prevent="post(form.id)">
        <v-row class="">
          <v-col>
            <label for="">Keluarga</label>
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
          <v-col>
            <label class="">NIK</label>
            <v-text-field
              class="mt-3"
              rounded="lg"
              clearable
              :rules="rules.nik"
              variant="outlined"
              v-model="form.nik"
              type="number"
              required
              hint="Masukkan 16 digit NIK"
              persistent-hint
            ></v-text-field>
          </v-col>
        </v-row>
        <label for="">Nama Lengkap</label>
        <v-text-field
          class="mt-3"
          rounded="lg"
          clearable
          :rules="rules"
          variant="outlined"
          v-model="form.nama"
          required
        ></v-text-field>
        <v-row class="">
          <v-col>
            <label for="">Tempat Lahir</label>
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
          <v-col>
            <label for="">Tanggal Lahir</label>
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
        <v-row class="">
          <v-col>
            <label for="">Jenis Kelamin</label>
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
          <v-col>
            <label for="">Status Kawin</label
            ><v-autocomplete
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
          <v-col>
            <label for="">Hubungan Keluarga</label
            ><v-autocomplete
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
        <v-row class="">
          <v-col>
            <label for="">Warga Negara</label>
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
            ></v-autocomplete
          ></v-col>
          <v-col>
            <label for="">Agama</label
            ><v-autocomplete
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
        <v-row class="">
          <v-col>
            <label for="">Pendidikan</label>
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
            ></v-autocomplete
          ></v-col>
          <v-col>
            <label for="">Pekerjaan</label
            ><v-autocomplete
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
        <v-row class="">
          <v-col>
            <label class="custom-label">Ayah</label>
            <v-text-field
              class="mt-3"
              rounded="lg"
              id="input-1"
              clearable
              :rules="rules"
              variant="outlined"
              required
              v-model="form.ayah"
            ></v-text-field>
          </v-col>
          <v-col>
            <label class="">Ibu</label>
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
        <label class="">Nomor HP</label>
        <v-text-field
          class="mt-3"
          rounded="lg"
          clearable
          :rules="rules"
          variant="outlined"
          required
          v-model="form.no_hp"
        ></v-text-field>
        <label class="">Domisili</label>
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
        <label>Status</label
        ><v-select
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
      </v-form>
    </v-card>
  </v-container>
</template>
<script>
import axios from "axios";
import { useRouter } from "vue-router";
import { useCons } from "@/stores/constant";
import { test } from '@/stores/restrict';
import Swal from 'sweetalert2';
const use = test();
const useData = useCons();
export var succes=false;
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
      user:[],
      dataKel:[],
      domisili:useData.domisili,
      kelamin: useData.kelamin,
      statusKawin: useData.statusKawin,
      hubungan: useData.hubungan,
      warga: useData.warga,
      agama: useData.agama,
      pendidikan: useData.pendidikan,
      pekerjaan: useData.pekerjaan,
      stat: useData.stat,


      form: {
        nomer_kk: "",
        kels_id:1,
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
        kepala_kel: "",
        no_hp: "",
        domisili: "",
        status: "",
        user_id:'',
        valid: false,

      },

      rules: {
        required: [(v) => !!v || "Form Tidak Boleh Kosong!"],
        nik: [
          (v) => !!v || "NIK tidak boleh kosong!",
          (v) => /^\d+$/.test(v) || "NIK harus berupa angka",
          (v) => v.length === 16 || "NIK harus 16 digit"
        ]
      },
    };
  },
  mounted() {
    this.getKeluarga();
    this.inputter();
  },

  methods: {
    inputter(){
      axios.get("api/user")
      .then((res)=>{
        console.log(res.data.data.Id);
        this.form.user_id=res.data.data.Id;
      })
    },
    getKeluarga(){
      try{
        axios.get("/api/keluarga")
        .then((res)=>{
          console.log(res.data);
          this.dataKel=res.data.data;
          this.form.kels_id=res.data.data[0].id;
        })

      }
      catch(error){
        return error;
      }
    },

    post() {
      let date = new Date(this.form.tgl_lhr);
      let tzOffset = "+07:00";

      try {
        const formData = {
          ...this.form,
          nik: String(this.form.nik).trim(),
          tgl_lhr: date.getFullYear() + '-' +
            String(date.getMonth() + 1).padStart(2, '0') + '-' +
            String(date.getDate()).padStart(2, '0') + 'T' +
            String(date.getHours()).padStart(2, '0') + ':' +
            String(date.getMinutes()).padStart(2, '0') + ':' +
            String(date.getSeconds()).padStart(2, '0') +
            tzOffset,
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

        // Validasi
        if (!formData.status) {
          Swal.fire({
            title: 'Error!',
            text: 'Status harus diisi!',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6',
          });
          return;
        }

        axios
          .post("/api/addpenduduk", formData)
          .then((res) => {
            this.form.valid = res.data.valid;
            if (this.form.valid == false) {
              Swal.fire({
                title: 'Error!',
                text: res.data.massage,
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
              });
            } else {
              Swal.fire({
                title: 'Berhasil!',
                text: res.data.massage,
                icon: 'success',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
              }).then(() => {
                succes = true;
                this.$router.push('/penduduk');
              });
            }
          })
          .catch((error) => {
            Swal.fire({
              title: 'Error!',
              text: 'Terjadi kesalahan saat menyimpan data',
              icon: 'error',
              confirmButtonText: 'OK',
              confirmButtonColor: '#3085d6',
            });
          });
      } catch (error) {
        Swal.fire({
          title: 'Error!',
          text: 'Terjadi kesalahan sistem',
          icon: 'error',
          confirmButtonText: 'OK',
          confirmButtonColor: '#3085d6',
        });
        this.$router.push("/login");
      }
    },
    itemProps (item) {
        return {
          title: item.no_kk+' ['+item.kk_nama+']'
        }
      }
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
