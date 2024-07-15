<template lang="">
  <v-container class="">
    <v-card class="" elevation="4" max-width=""
      ><v-card-title>
        <h3 class="font-weight-medium font-weight: 400;">Input Penduduk</h3>
      </v-card-title>

      <v-form class="ma-2 pa-2" @submit.prevent="post" lazy-validation>
        <v-row class="">
          <v-col>
            <label>Nomer KK</label>
            <v-text-field
              clearable
              :rules="rules"
              variant="outlined"
              v-model="form.nomer_kk"
              required
            ></v-text-field>
          </v-col>
          <v-col>
            <label class="">NIK</label>
            <v-text-field
              clearable
              :rules="rules"
              variant="outlined"
              v-model="form.nik"
              required
            ></v-text-field>
          </v-col>
        </v-row>
        <label for="">Nama Lengkap</label>
        <v-text-field
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
            <v-select
              :rules="rules"
              :items="kelamin"
              item-title="name"
              item-value="id"
              v-model="form.kelamin"
              variant="outlined"
              required
            ></v-select>
            <h1>{{ form.kelamin }}</h1>
          </v-col>
          <v-col>
            <label for="">Status Kawin</label
            ><v-select
              :rules="rules"
              variant="outlined"
              :items="statusKawin"
              item-title="name"
              item-value="id"
              required
              v-model="form.stat_kawin"
            ></v-select>
          </v-col>
          <v-col>
            <label for="">Hubungan Keluarga</label
            ><v-select
              :rules="rules"
              variant="outlined"
              :items="hubungan"
              item-title="name"
              item-value="id"
              required
              v-model="form.hub_kel"
            ></v-select>
          </v-col>
        </v-row>
        <v-row class="">
          <v-col>
            <label for="">Warga Negara</label>
            <v-select
              :rules="rules"
              variant="outlined"
              :items="warga"
              item-title="name"
              item-value="id"
              required
              v-model="form.warga_neg"
            ></v-select
          ></v-col>
          <v-col>
            <label for="">Agama</label
            ><v-select
              :rules="rules"
              variant="outlined"
              :items="agama"
              item-title="name"
              item-value="id"
              required
              v-model="form.agama"
            ></v-select>
          </v-col>
        </v-row>
        <v-row class="">
          <v-col>
            <label for="">Pendidikan</label>
            <v-select
              :rules="rules"
              variant="outlined"
              :items="pendidikan"
              item-title="name"
              item-value="id"
              required
              v-model="form.pendidikan"
            ></v-select
          ></v-col>
          <v-col>
            <label for="">Pekerjaan</label
            ><v-select
              :rules="rules"
              variant="outlined"
              :items="pekerjaan"
              item-title="name"
              item-value="id"
              required
              v-model="form.pekerjaan"
            ></v-select>
          </v-col>
        </v-row>
        <v-row class="">
          <v-col>
            <label class="custom-label">Ayah</label>
            <v-text-field
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
              clearable
              :rules="rules"
              variant="outlined"
              required
              v-model="form.ibu"
            ></v-text-field>
          </v-col>
        </v-row>
        <label class="">Kepala Keluarga</label>
        <v-text-field
          clearable
          :rules="rules"
          variant="outlined"
          required
          v-model="form.kepala_kel"
        ></v-text-field>
        <label class="">Nomor HP</label>
        <v-text-field
          clearable
          :rules="rules"
          variant="outlined"
          required
          v-model="form.no_hp"
        ></v-text-field>
        <label class="">Domisili</label>
        <v-textarea
          clearable
          :rules="rules"
          variant="outlined"
          required
          v-model="form.domisili"
        ></v-textarea>
        <label>Status</label
        ><v-select
          :rules="rules"
          variant="outlined"
          :items="stat"
          item-title="name"
          item-value="id"
          required
          v-model="form.stat"
        ></v-select>
        <v-btn
          class="mt-4"
          location="center"
          type="submit"
          elevation="2"
          color="green"
          >Submit</v-btn
        >
      </v-form>
    </v-card>
  </v-container>
</template>
<script>
import axios from "axios";
import { useRouter } from "vue-router";
import { useCons } from "@/stores/constant";
const useData = useCons();
export default {
  setup() {
    const useData = useCons();
    const router = useRouter();

    return {
      useData,
      router,
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


      form: {
        nomer_kk: "",
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
        stat: "",
        valid: false,

      },

      rules: [(v) => !!v || "Form Tidak Boleh Kosong!"],
    };
  },
  mounted() {
    console.log(this.kelamin);
  },

  methods: {
    post() {
      this.form.tgl_lhr = new Date(this.form.tgl_lhr)
        .toISOString()
        .split("T")[0];
      try {
        axios
          .post("http://localhost:8000/api/addPenduduk", this.form)
          .then((res) => {
            console.log(res);
            this.form.valid = res.data.valid;
            if (this.form.valid == false) {
              alert(res.data.massage);
            } else {
              alert(res.data.massage);
              this.router.push("/penduduk");
            }
          });
      } catch (error) {
        error, router.push("/login");
      }
    },
  },
};
</script>
<style lang=""></style>
