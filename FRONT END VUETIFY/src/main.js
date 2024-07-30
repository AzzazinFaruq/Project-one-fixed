/**
 * main.js
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Plugins
import { registerPlugins } from "@/plugins";
import { createPinia } from "pinia";


// Components
import App from "./App.vue";

// Composables
import { createApp } from "vue";
import axios from "axios";

axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

const pinia = createPinia();
const app = createApp(App);

registerPlugins(app);

app.use(pinia);
app.mount("#app");
