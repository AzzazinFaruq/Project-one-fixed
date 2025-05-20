<template>
 <div class="container-login">
    <v-card elevation="0" class="card-login">
      <div class="d-flex justify-center image-login">
        <v-img src="../assets/logo-pendataan-black.png" width="180px" height="100px"></v-img>
      </div>
      <div class="">
        <v-form>
          <label for="">Email</label>
          <v-text-field
            class="mt-3"
            rounded="lg"
            variant="outlined"
            placeholder="Masukkan Email"
            v-model="form.email"
            persistent-placeholder
            bg-color="#EFEBE9"
            color="#795548"
          ></v-text-field>
          <label for="">Username</label>
          <v-text-field
            class="mt-3"
            rounded="lg"
            variant="outlined"
            placeholder="Masukkan Username"
            v-model="form.name"
            persistent-placeholder
            bg-color="#EFEBE9"
            color="#795548"
          ></v-text-field>
          <label for="">Kata Sandi</label>
          <v-text-field
            class="mt-3"
            rounded="lg"
            variant="outlined"
            placeholder="Masukkan Kata Sandi"
            v-model="form.password"
            persistent-placeholder
            bg-color="#EFEBE9"
            color="#795548"
          ></v-text-field>
          <label for="">Konfirmasi Kata Sandi</label>
          <v-text-field
            class="mt-3"
            rounded="lg"
            variant="outlined"
            placeholder="Konfirmasi Kata Sandi"
            v-model="form.confirm_password"
            persistent-placeholder
            bg-color="#EFEBE9"
            color="#795548"
          ></v-text-field>
          <v-btn width="100%" color="#C37B58" @click="register">Daftar</v-btn>
        </v-form>
      </div>
      <div class="text-center mt-3">
        <p style="font-size: 14px; color: #595959;">Sudah Punya Akun? mari kita lanjutkan untuk <a href=""><b>Masuk</b></a></p>
      </div>
    </v-card>
  </div>
</template>
<script>
import axios from "axios";
import Swal from 'sweetalert2'

export default {
  data() {
    return {
      form: {
        name: "",
        email: "",
        password: "",
        confirm_password: "",
      },
    };
  },
  methods: {
    showErrorToast(message) {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: 'error',
        title: message,
        background: '#FFF0F0',
        color: '#DE3545'
      })
    },

    showSuccessToast(message) {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: 'success',
        title: message,
        background: '#F0FFF0',
        color: '#28A745'
      })
    },

    register() {
      // Validasi form
      if (!this.form.email || !this.form.password || !this.form.confirm_password) {
        this.showErrorToast('Semua field harus diisi')
        return
      }

      if (this.form.password !== this.form.confirm_password) {
        this.showErrorToast('Konfirmasi password tidak sesuai')
        return
      }

      try {
        axios.post("/api/register", this.form)
          .then((res) => {
            if (res.data.success) {
              this.showSuccessToast('Registrasi berhasil!')
              setTimeout(() => {
                this.$router.push("/login")
              }, 1000)
            } else {
              this.showErrorToast(res.data.message || 'Registrasi gagal')
            }
          })
          .catch((error) => {
            this.showErrorToast(error.response?.data?.message || 'Terjadi kesalahan pada sistem')
          });
      } catch (error) {
        this.showErrorToast('Terjadi kesalahan pada sistem')
      }
    },
  },
};
</script>
<style lang="scss" scoped>

.v-btn{
  text-transform: none !important;
  line-height: 1.5 !important;
}

a{
  text-decoration: none;
  color: black;
}

label{
  font-weight: 600;
  font-size: 16px;
}

.container-login {
  width: 600px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    @media screen and (max-width:600px) {
    width: 95%;
    }
    .card-login{
    padding: 64px;
    @media screen and (max-width:600px) {
      padding: 32px;
    }
    .image-login{
      margin-bottom: 32px;
    }
  }
}
.v-container{
  padding: 0px !important;
}
.no-underline {
  text-decoration: none !important;
  color: grey;
}
.no-underline:hover {
  color: black; /* Ganti dengan warna yang diinginkan */
}

/* Untuk border normal */
:deep(.v-field.v-field--outlined .v-field__outline) {
  border-width: 2px !important; /* sesuaikan ketebalan yang diinginkan */
}

/* Untuk border saat hover */
:deep(.v-field.v-field--outlined:hover .v-field__outline) {
  border-width: 2px !important;
}

/* Untuk border saat focus */
:deep(.v-field--focused .v-field__outline) {
  border-width: 2px !important;
}

/* Untuk border bottom */
:deep(.v-field.v-field--outlined .v-field__outline-bottom) {
  border-bottom-width: 2px !important;
}

/* Kustomisasi toast */
.swal2-toast {
  padding: 10px !important;
  margin: 15px !important;
  width: auto !important;
  max-width: 300px !important;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1) !important;
}

.swal2-toast .swal2-title {
  font-size: 14px !important;
  margin: 0 10px !important;
}

.swal2-toast .swal2-icon {
  margin: 0 !important;
  font-size: 12px !important;
}

/* Style untuk success toast */
.swal2-toast.swal2-icon-success {
  background-color: #F0FFF0 !important;
}

.swal2-toast.swal2-icon-success .swal2-title {
  color: #28A745 !important;
}

.swal2-toast.swal2-icon-success .swal2-icon {
  color: #28A745 !important;
}
</style>
