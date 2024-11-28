<template lang="">
  <v-container class="">
    <v-stepper
    alt-labels
    hide-actions
    v-model="step"
    :items="['Input Data Keluarga', 'Input Data Kepala Keluarga']"
    >
    <template v-slot:item.1>
      <v-form class="ma-2" @submit.prevent="post">
        <label for="">NOMER KK</label>
        <v-text-field
          clearable
          :rules="rules"
          variant="outlined"
          v-model="form.no_kk"
          required
        ></v-text-field>
        <label for="">NIK</label>
        <v-text-field
          clearable
          :rules="rules"
          variant="outlined"
          v-model="form.kk_nik"
          required
        ></v-text-field>
        <label for="">NAMA</label>
        <v-text-field
          clearable
          :rules="rules"
          variant="outlined"
          v-model="form.kk_nama"
          required
        ></v-text-field>
        <label for="">alamat</label>
        <v-text-field
          clearable
          :rules="rules"
          variant="outlined"
          v-model="form.alamat"
          required
        ></v-text-field>
        <label for="">RT</label>
        <v-text-field
          clearable
          :rules="rules"
          variant="outlined"
          v-model="form.rt"
          required
        ></v-text-field>
        <label for="">RW</label>
        <v-text-field
          clearable
          :rules="rules"
          variant="outlined"
          v-model="form.rw"
          required
        ></v-text-field>
        <label for="">KODE POS</label>
        <v-text-field
          clearable
          :rules="rules"
          variant="outlined"
          v-model="form.kode_pos"
          required
        ></v-text-field>
        <label for="">STATUS</label>
       <v-select
          clearable
          :rules="rules"
          variant="outlined"
          :items="stat"
          item-title="name"
          item-value="id"
          required
          v-model="form.status"
       ></v-select>
        <v-btn
          class="mt-4"
          location="center"
          type="submit"
          elevation="2"
          color="green"
          :rules="rules"
          >Submit</v-btn>
      </v-form>
    </template>

   <template v-slot:item.2>
    <formPenduduk/>
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
      step:1,
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
      },

      rules: [(v) => !!v || "Form Tidak Boleh Kosong!"],
    };
  },
  mounted() {
    this.getUser()
  },

  methods: {
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
    post() {
      try {
        axios
          .post("/api/addKeluarga", this.form)
          .then((res) => {
            console.log(res);
            this.form.valid = res.data.valid;
            if (this.form.valid == false) {
              alert(res.data.massage);
            } else {
              alert(res.data.massage);
              this.step=2;
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
