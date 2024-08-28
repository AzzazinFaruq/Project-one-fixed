<template>
  <v-container>
    <h1>{{ level }} Dashboard</h1>
    <v-divider class="my-2"></v-divider>
    <div class="my-2">
      <v-alert
    v-model="loginPoUp"
    color="success"
    variant="tonal"
    closable
    title="Login Berhasil"
    >
    Selamat Datang di dashboard {{ level }} {{ data.name }}
    </v-alert>
    </div>
    <div class="mt-5">
    <v-row class="m-2" justify="center">
     <card
      icon="mdi-human-male-female-child"
      title="Keluarga"
      description="Total Keluarga"
      :count="datacardjumlah.keluarga"
      card="brown-lighten-1"
      color="brown-lighten-2"
      route="/dashboard/keluarga"

      />
      <card
      icon="mdi-account"
      title="Penduduk"
      description="Total Penduduk"
      :count="datacardjumlah.penduduk"
      card="light-blue-darken-2"
      color="light-blue-darken-1 text-white"
      route="/dashboard/penduduk"
      />
      <card
      icon="mdi-account-check"
      title="Aktif"
      description="Penduduk Total"
      :count="datacardstatus.aktif"
      card="green-lighten-1"
      color="green-lighten-2 text-white"
      route="/dashboard/penduduk"
      />
      <card
      icon="mdi-account-cancel"
      title="Inaktif"
      description="Penduduk Total"
      :count="datacardstatus.inaktif"
      color="red-accent-2"
      card="red-lighten-1 text-white"
      route="/dashboard/penduduk"
      />
    </v-row>
    </div>
    <div class="mt-5 ">
        <v-row justify="center" class="ma-1 " elevation="5">
          <marrychart/>
          <genderchart/>
      </v-row>
    </div>
    <div class="mt-5" >
      <v-row justify="center">
        <totalchart/>
      </v-row>
    </div>
    <div class="mt-10">
      <v-card class="pa-2" elevation="10">
      <h3 class="ma-2">DATA TERBARU</h3>
      <v-divider></v-divider>
    <v-tabs
      v-model="tab"
      variant="outlined"
      bg-color="deep-green-accent-4"
    >
      <v-tab value="one">DATA KELUARGA</v-tab>
      <v-tab value="two">DATA PENDUDUK</v-tab>
    </v-tabs>

    <v-card-text>
      <v-tabs-window v-model="tab">
        <v-tabs-window-item value="one">
        <dtTable
        :dthead="headkel"
        :dtbody="dtkel"
        />
        </v-tabs-window-item>
        <v-tabs-window-item value="two">
        <dtTable
        :dthead="headpen"
        :dtbody="dtpen"
        />
        </v-tabs-window-item>
      </v-tabs-window>
    </v-card-text>
  </v-card>
    </div>

  </v-container>
</template>

<script>
import genderchart from '@/components/chart/genderchart.vue';
import marrychart from '@/components/chart/marrychart.vue';
import totalchart from '@/components/chart/totalchart.vue';
import axios from 'axios'
import card from '@/components/card.vue';
import dtTable from '@/components/dtTable.vue';
import { success } from '../login.vue';
import { test } from '@/stores/restrict';
const use = test();

export default {
  setup(){
    use.setup();
  },
  components:{
  },
  data() {
    return {
      loginPoUp:false,
      notif:success,
      headkel:[
        {id:0, name:'NOMOR KK'},
        {id:1, name:'NOMOR NIK'},
        {id:2, name:'NAMA'},
        {id:3, name:'STATUS'},
        {id:4, name:'USER'}
      ],
      headpen:[
        {id:0, name:'NOMOR KK / KEPALA KELUARGA'},
        {id:1, name:'NOMOR NIK'},
        {id:2, name:'NAMA'},
        {id:3, name:'STATUS'},
        {id:4, name:'USER'}
      ],

      datacardjumlah:[],
      datacardstatus:[],
      tab: 'one',
      data: [],
      level:"",
      dtkel:[],
      dtpen:[]
    };
  },
  mounted() {
    this.fetchData();
    this.popup();
  },
  methods: {
    popup(){
      if (localStorage.getItem('loginAlert')==='true') {
        this.loginPoUp=true;
        localStorage.removeItem('loginAlert');
      }
    },
    async fetchData() {
        this.status();
        this.kellast();
        this.penlast();
        this.dataForCard();
    },
    dataForCard(){
      axios.get('/api/allData')
      .then((res)=>{
        this.datacardjumlah = res.data.jumlah;
        this.datacardstatus = res.data.Status;

      })
    },
    status() {
      // try {
        axios.get("/api/user").then((res) => {
          this.data = res.data.data;
          const data = res.data.data.level
          if (data == 'admin' || data == 'superAdmin') {
            this.level = 'Admin';
          }
          else{
            this.level = '';
          }
        });
    },
    kellast(){
      axios.get('/api/latestkel')
      .then((res)=>{
        this.dtkel = res.data;
      })
    },
    penlast(){
      axios.get('/api/latestpen')
      .then((res)=>{
        this.dtpen = res.data;
      })
    }
  },
  created() {

  },
};

</script>

<style>

</style>
