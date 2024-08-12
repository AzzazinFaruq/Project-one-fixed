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
axios.defaults.headers.common['Authorization'] = `bearer ${localStorage.getItem('token')}`;
axios.defaults.headers.common['Content-Type'] = 'application/json';

const pinia = createPinia();
const app = createApp(App);

registerPlugins(app);
app.use(pinia);
app.use(VueApexCharts);
app.mount("#app");
