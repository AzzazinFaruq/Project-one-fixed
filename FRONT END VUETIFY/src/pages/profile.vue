<template>
<div class="pa-5">
  <v-tabs
      v-model="tab"
      align-tabs="left"
      color="#F76C5E"
    >
      <v-tab :value="one">Edit Profil</v-tab>
      <v-tab :value="two">Keamanan</v-tab>
    </v-tabs>

    <v-card class="mt-5 pa-10" elevation="0">
      <v-tabs-window v-model="tab">
        <v-tabs-window-item value="one">
          <v-dialog v-model="dialogVisible" max-width="500px">
            <template v-slot:activator="{ props }">
              <div class="d-flex justify-center" v-bind="props" style="cursor: pointer;">
                <div class="rounded-circle" style="width: 150px; height: 150px;">
                  <v-img v-if="!userdata.profile_picture" src="../assets/avatar.png" width="150" height="150"></v-img>
                  <v-img :src="foto" width="150" height="150"></v-img>
                </div>
              </div>
            </template>

            <v-card>
              <v-card-title class="text-h6 pa-4">
                Update Foto Profil
              </v-card-title>

              <v-card-text>
                <v-row class="pa-4">
                  <v-col cols="12" class="text-center">
                    <v-img
                      v-if="previewImage"
                      :src="previewImage"
                      max-width="200"
                      class="mx-auto mb-4"
                    ></v-img>

                    <v-file-input
                      v-model="selectedFile"
                      accept="image/*"
                      label="Pilih Foto"
                      prepend-icon="mdi-camera"
                      @change="previewFiles"
                      :rules="[
                        v => !v || v.size < 2000000 || 'Ukuran foto harus kurang dari 2 MB!',
                        v => !v || v.type.startsWith('image/') || 'File harus berupa gambar!'
                      ]"
                    ></v-file-input>
                  </v-col>
                </v-row>
              </v-card-text>

              <v-card-actions class="pa-4">
                <v-spacer></v-spacer>
                <v-btn
                  color="error"
                  variant="text"
                  @click="dialogVisible = false"
                >
                  Batal
                </v-btn>
                <v-btn
                  color="success"
                  variant="text"
                  @click="uploadPhoto"
                  :loading="isUploading"
                >
                  Upload
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <div class="mt-5">
            <label class="">Nama</label>
            <v-text-field
              class="mt-2"
              v-model="userdata.name"
              variant="outlined"
              density="comfortable"
            ></v-text-field>
            <label class="">Email</label>
            <v-text-field
              class="mt-2"
              v-model="userdata.email"
              variant="outlined"
              density="comfortable"
            ></v-text-field>
          </div>
          <div class="d-flex justify-end">
            <v-btn color="#01A65D" prepend-icon="mdi-content-save" class="text-white">Simpan</v-btn>
          </div>
        </v-tabs-window-item>
        <v-tabs-window-item value="two">
          Two
        </v-tabs-window-item>
      </v-tabs-window>
    </v-card>
</div>
</template>
<script>
import axios from 'axios';
import { test } from '@/stores/restrict';
const use = test();
export default {
setup(){
  use.setup();
},
data(){
  return{
    tab:1,
    foto:"",
    userdata:[],
    logout:false,
    dialogVisible: false,
    selectedFile: null,
    previewImage: null,
    isUploading: false,
  }
},
mounted(){
this.user();
},
methods:{
  user(){
    try{
      axios.get('/api/user')
      .then((res)=>{
        this.foto="http://localhost:8080/"+res.data.data.profile_picture;
        console.log(res.data.data)
        this.userdata = res.data.data
      })
    }
    catch{

    }
  },
  handlelogout() {
      try {
        axios.post("/api/logout").then((res) => {
          console.log("Logout response:", res.data);
          this.success = false;
          this.$router.push("/");
          localStorage.removeItem('auth')
        });
      } catch (error) {
        error;

      }
},
previewFiles(event) {
  if (this.selectedFile) {
    this.previewImage = URL.createObjectURL(this.selectedFile);
  } else {
    this.previewImage = null;
  }
},

async uploadPhoto() {
  if (!this.selectedFile) {
    Swal.fire({
      icon: 'error',
      title: 'Error!',
      text: 'Silakan pilih foto terlebih dahulu',
    });
    return;
  }

  this.isUploading = true;

  try {
    const formData = new FormData();
    formData.append('profile_picture', this.selectedFile);

    const response = await axios.post('/api/update-profile-picture', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });

    if (response.data.success) {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Foto profil berhasil diperbarui',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
      });

      // Refresh foto profil
      this.user();
      this.dialogVisible = false;
    } else {
      throw new Error(response.data.message);
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error!',
      text: error.message || 'Gagal mengupload foto',
    });
  } finally {
    this.isUploading = false;
    this.selectedFile = null;
    this.previewImage = null;
  }
},
}
}

</script>
<style scoped>
label{
  font-size: 16px;
  font-weight: 600;

}

.rounded-circle {
  overflow: hidden;
  transition: opacity 0.3s;
  cursor: pointer;
}

.rounded-circle:hover {
  opacity: 0.8;
}

.v-dialog {
  border-radius: 8px;
}
</style>
