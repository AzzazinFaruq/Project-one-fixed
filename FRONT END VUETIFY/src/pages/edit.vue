<template>
  <v-container fluid>
    <v-alert
      v-model="notif"
      density='compact'
      type="success"
      variant="tonal"
      title="Sukses"
      closable
    >
    Sukses Edit Password User
    </v-alert>
    <v-card class="mt-3">
    <v-card-title primary-title>
      Edit Profile
    </v-card-title>
    <v-card-text>
      <v-form>
        <label for="">Nama</label>
        <v-text-field
        clearable
          variant="outlined"
          v-model="dtuser.name"
          required
        ></v-text-field>
        <label for="">Email</label>
        <v-text-field
          clearable
          variant="outlined"
          v-model="dtuser.email"
          required

        ></v-text-field>
        <v-row>
          <v-col ><v-btn color="green" variant="outlined" @click="dialpass()">Ganti Password</v-btn></v-col>
          <v-col  class="d-flex justify-end align-end" ><v-btn  class="fixed-bottom-right" color="success" @click="ubah(dtuser.id)">Ubah</v-btn></v-col>
        </v-row>
      </v-form>
        <v-dialog
          v-model="dialog"
          max-width="500px"
          transition="dialog-transition"
        >
        <v-card>
          <v-card-title primary-title>
            Edit Password
          </v-card-title>
          <v-card-text>
            <v-form>
        <label for="">New Password</label>
        <v-text-field
          variant="outlined"
          v-model="password"
          required
        ></v-text-field>
        <label for="">Confirm Password</label>
        <v-text-field
          :rules="rule"
          variant="outlined"
          v-model="dtuser.password"
          required
        ></v-text-field>
        <v-btn color="success" @click="passup(dtuser.id)">Ganti Password</v-btn>
        </v-form>
          </v-card-text>
        </v-card>
        </v-dialog>
    </v-card-text>
  </v-card>
  </v-container>
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
    notif:false,
    dialog:false,
    password:'',
    dtuser:{
      id:'',
      name:'',
      email:'',
      password:''
    },
    rule: [(v) => v === this.password || 'Passwords must match'],
  }
},
mounted(){
this.get();
},
methods: {
  get(){
    try{
      axios.get('/api/user')
      .then((res)=>{
        console.log(res.data.data)
       this.dtuser = res.data.data
      })
    }
    catch{

    }
  },
  ubah(id){
    try {
      axios.put(`/api/update/${id}`,this.dtuser)
    } catch (error) {

    }
  },
  dialpass(){
    this.dialog=true
  },
  passup(id){
    try {
      axios.put(`/api/update/${id}`,this.dtuser)
      .then((res)=>{
        this.dialog=false;
        this.notif=true;
      })
    } catch (error) {

    }
  }
},
}
</script>
