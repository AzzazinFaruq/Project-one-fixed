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
      },

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
    post(id) {
      try {
        const formData = {
          ...this.form,
          no_kk: Number(this.form.no_kk),
          kk_nik: Number(this.form.kk_nik),
          kk_nama: this.form.kk_nama,
          alamat: this.form.alamat,
          rt: this.form.rt,
          rw: this.form.rw,
          kode_pos: this.form.kode_pos,
          status: Number(this.form.status),
          user_id: Number(this.form.user_id)
        };

        axios.put(`/api/editkeluarga/${id}`, formData)
          .then((res) => {
            console.log(res);
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
                this.$router.push('/keluarga');
              });
            }
          })
          .catch((error) => {
            Swal.fire({
              title: 'Error!',
              text: 'Gagal memperbarui data',
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

