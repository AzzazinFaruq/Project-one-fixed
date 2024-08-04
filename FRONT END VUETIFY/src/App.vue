<template>
  <v-app>
    <navbar v-if="!isLoginPage && !reg  && !index && !forbid"  :key="$route.fullPath"/>
    <v-main>
      <v-container fluid>
        <router-view/>
      </v-container>
    </v-main>

    <v-footer app> </v-footer>
  </v-app>
</template>

<script>
import navbar from "./components/navbar.vue";
import axios from "axios";
import { computed } from 'vue';
import { useRoute } from 'vue-router';
export default {
  components: {
    navbar,
  },
  data(){
    return{
      status:false
    }
  },
  setup(){
    const route = useRoute();
    const isLoginPage = computed(() => route.path === '/login');
    const reg = computed(() => route.path === '/register');
    const index = computed(() => route.path === '/');
    const forbid= computed(() => route.path === '/forbidden');

return { isLoginPage,reg,index,forbid};
  }

};
</script>
