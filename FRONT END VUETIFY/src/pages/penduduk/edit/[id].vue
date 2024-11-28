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
              :rules="rules"
              variant="outlined"
              v-model="form.nik"
              required
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
        ><v-autocomplete
          class="mt-3"
          rounded="lg"
          :rules="rules"
          variant="outlined"
          :items="stat"
          item-title="name"
          item-value="id"
          required
          v-model="form.stat"
        ></v-autocomplete>
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
import { ref, onMounted } from "vue";
import { useRouter, useRoute, RouterLink } from "vue-router";
import { useCons } from "@/stores/constant";
import { test } from '@/stores/restrict';
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
      datakel:[],
      domisili:useData.domisili,
      kelamin: useData.kelamin,
      statusKawin: useData.statusKawin,
      hubungan: useData.hubungan,
      warga: useData.warga,
      agama: useData.agama,
      pendidikan: useData.pendidikan,
      pekerjaan: useData.pekerjaan,
      stat: useData.stat,
      form: [
        {
        nomer_kk: "",
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
        kepala_kel: "",
        no_hp: "",
        domisili:0,
        stat: "",
        user_id:'',
        valid: false,
        },
      ],

      rules: [(v) => !!v || "Wajib Diisi!"],
    };
  },
  mounted() {
    this.get();
  },
  setup() {},
  methods: {
    getKeluarga(){
      try{
        axios.get("/api/keluargaidx")
        .then((res)=>{
          console.log(res.data);
          this.dataKel=res.data.data;
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
          .get(`/api/byID/${route.params.id}`)
          .then((response) => {
            console.log(response.data);
            this.form = response.data.data[0];
            this.form.tgl_lhr = new Date(response.data.data[0].tgl_lhr);
            console.log(this.form);
            // this.form.value = response.data;
          });
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    },
    post(id) {
      try {
        this.form.tgl_lhr = new Date(this.form.tgl_lhr)
          .toISOString()
          .split("T")[0];
        axios
          .put(
            `/api/updatePenduduk/${id}`,

            this.form
          )
          .then((res) => {
            console.log(res.message);
            this.$router.go(-1);
          });
      } catch (error) {
        error;
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
<style lang="scss">
.v-input{
  margin-top: 10px;
}
label{
  font-size: 14px;
  font-weight: 600;
}
</style>
