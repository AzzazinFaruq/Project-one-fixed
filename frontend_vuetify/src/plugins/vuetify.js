/**
 * plugins/vuetify.js
 *
 * Framework documentation: https://vuetifyjs.com`
 */

// Styles
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";
import { VDateInput } from "vuetify/labs/VDateInput";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { VNumberInput } from 'vuetify/labs/VNumberInput'

// Composables
import { createVuetify } from "vuetify";

// https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
export default createVuetify({
  components,
  directives,
  theme: {
    defaultTheme: 'myCustomTheme',
    themes: {
      myCustomTheme: {
        dark: false,
        colors: {
          background: '#F9F2EE',
          primary: '#795548',
        },
        variables: {
          'font-family': 'Helvetica, Arial, sans-serif',
        },
      },
    },
  },
  components: {
    VDateInput,
    VNumberInput,
  },
});
