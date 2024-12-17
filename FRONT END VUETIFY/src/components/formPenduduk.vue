<template lang="">
  <v-container class="">
    <v-form class="ma-2 pa-2" @submit.prevent="post(form.id)">
        <v-row class="">
          <v-col>
            <label for="">Keluarga</label>
            <v-autocomplete
            disabled
              class="mt-3"
              rounded="lg"
              :item-props="itemProps"
              :rules="rules"
              :items="dataKel"
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
            disabled
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
  </v-container>
</template>
<script>
import axios from "axios";
import { useRouter } from "vue-router";
import { useCons } from "@/stores/constant";
import { test } from '@/stores/restrict';
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
        kels_id:"",
        nik: "",
        nama: "",
        tmp_lhr: "",
        tgl_lhr: new Date(),
        kelamin: "",
        stat_kawin: "",
        hub_kel: 1,
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
        user_id:'',
        valid: false,

      },

      rules: [(v) => !!v || "Form Tidak Boleh Kosong!"],
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
        console.log(res.data.data.id);
        this.form.user_id=res.data.data.id;
      })
    },
    getKeluarga(){
      try{
        axios.get("/api/latestkelinput")
        .then((res)=>{
          this.dataKel=res.data.data;
          this.form.kels_id=res.data.data[0].id;
          this.form.nama=this.dataKel.kk_nama;
          console.log(this.dataKel);
        })

      }
      catch(error){
        return error;
      }
    },

    post() {
      this.form.tgl_lhr = new Date(this.form.tgl_lhr)
        .toISOString()
        .split("T")[0];
      try {
        axios
          .post("/api/addPenduduk", this.form)
          .then((res) => {
            console.log(res);
            this.form.valid = res.data.valid;
            if (this.form.valid == false) {
              alert(res.data.massage);
            } else {
              alert(res.data.massage);
              succes=true;
              this.$router.push('/dashboard/keluarga');
            }
          });
      } catch (error) {
        error, router.push("/login");
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
<style lang=""></style>
