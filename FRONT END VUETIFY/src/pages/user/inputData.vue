<template>
  <v-container grid-list-xs>
    <v-stepper :items="['Step 1', 'Step 2', 'Step 3']">
  <template v-slot:item.1>
    <formKeluarga @click="yeah()"></formKeluarga>
  </template>

  <template v-slot:item.2>
    <v-card title="Step Two" flat>...</v-card>
  </template>

  <template v-slot:item.3>
    <v-card title="Step Three" flat>...</v-card>
  </template>
</v-stepper>
  </v-container>

  <!-- <v-card>
    <v-tabs
     v-model="tab"
      align-tabs="center"
      color="green-accent-4"
    >
      <v-tab value="one">Form Keluarga</v-tab>
      <v-tab :disabled="test" value="two">Form Penduduk</v-tab>
      <v-tab value="three">Cek Data Kembali</v-tab>
    </v-tabs>

    <v-card-text>
      <v-tabs-window v-model="tab">
        <v-tabs-window-item value="one">
          <formKeluarga></formKeluarga>
            <v-btn location="" color='green' @click="yeah()">>>>NEXT>>></v-btn>
        </v-tabs-window-item>
        <v-tabs-window-item value="two">
          <formPenduduk></formPenduduk>
            <v-btn location="center" color='' variant="outlined" @click="yeah()">>>>NEXT>>></v-btn>
        </v-tabs-window-item>
        <v-tabs-window-item value="three">
          Three
        </v-tabs-window-item>
      </v-tabs-window>
    </v-card-text>
  </v-card> -->
</template>
<script>
import formPenduduk from '@/components/formPenduduk.vue';
import formKeluarga from '@/components/formKeluarga.vue';
  export default {
    data: () => ({
      tab: null,
      test:true
    }),
    methods:{
      yeah(){
        console.log(this.test)
        this.test=false;
        console.log(this.test)
        this.tab=1;
      }
    }
  }
</script>

