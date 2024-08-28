/**
 * main.js
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Plugins
import { registerPlugins } from "@/plugins";
import { createPinia } from "pinia";
import VueApexCharts from "vue3-apexcharts";
// Components
import App from "./App.vue";
// Composables
import { createApp } from "vue";
import axios from "axios";
import axiosRetry from 'axios-retry';


axiosRetry(axios, {
  retries: 3, // Jumlah maksimum percobaan ulang
  retryDelay: (retryCount) => {
    return retryCount * 1000; // Menunggu 1 detik di antara setiap percobaan
  },
  retryCondition: (error) => {
    // Mengatur kondisi retry hanya untuk status 429
    return error.response.status === 429;
  },
});

axios.interceptors.response.use(
  response => response,
  error => {
      if (error.response && error.response.status === 401) {
          localStorage.removeItem('auth');
      }
      return Promise.reject(error);
  }
);
axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
axios.defaults.headers.common['Authorization'] = ['bearer',`${localStorage.getItem('token')}`] ;
axios.defaults.headers.common['Content-Type'] = 'application/json';

const pinia = createPinia();
const app = createApp(App);

registerPlugins(app);
app.use(pinia);
app.use(VueApexCharts);
app.mount("#app");
