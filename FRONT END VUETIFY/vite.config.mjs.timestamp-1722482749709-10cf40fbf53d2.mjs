// vite.config.mjs
import Components from "file:///D:/laragon/www/Project-one-fixed/FRONT%20END%20VUETIFY/node_modules/unplugin-vue-components/dist/vite.js";
import Vue from "file:///D:/laragon/www/Project-one-fixed/FRONT%20END%20VUETIFY/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import Vuetify, { transformAssetUrls } from "file:///D:/laragon/www/Project-one-fixed/FRONT%20END%20VUETIFY/node_modules/vite-plugin-vuetify/dist/index.mjs";
import ViteFonts from "file:///D:/laragon/www/Project-one-fixed/FRONT%20END%20VUETIFY/node_modules/unplugin-fonts/dist/vite.mjs";
import VueRouter from "file:///D:/laragon/www/Project-one-fixed/FRONT%20END%20VUETIFY/node_modules/unplugin-vue-router/dist/vite.mjs";
import { defineConfig } from "file:///D:/laragon/www/Project-one-fixed/FRONT%20END%20VUETIFY/node_modules/vite/dist/node/index.js";
import { fileURLToPath, URL } from "node:url";
var __vite_injected_original_import_meta_url = "file:///D:/laragon/www/Project-one-fixed/FRONT%20END%20VUETIFY/vite.config.mjs";
var vite_config_default = defineConfig({
  plugins: [
    VueRouter(),
    Vue({
      template: { transformAssetUrls }
    }),
    // https://github.com/vuetifyjs/vuetify-loader/tree/master/packages/vite-plugin#readme
    Vuetify({
      autoImport: true,
      styles: {
        configFile: "src/styles/settings.scss"
      }
    }),
    Components(),
    ViteFonts({
      google: {
        families: [
          {
            name: "Roboto",
            styles: "wght@100;300;400;500;700;900"
          }
        ]
      }
    })
  ],
  define: { "process.env": {} },
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", __vite_injected_original_import_meta_url))
    },
    extensions: [".js", ".json", ".jsx", ".mjs", ".ts", ".tsx", ".vue"]
  },
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcubWpzIl0sCiAgInNvdXJjZXNDb250ZW50IjogWyJjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZGlybmFtZSA9IFwiRDpcXFxcbGFyYWdvblxcXFx3d3dcXFxcUHJvamVjdC1vbmUtZml4ZWRcXFxcRlJPTlQgRU5EIFZVRVRJRllcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkQ6XFxcXGxhcmFnb25cXFxcd3d3XFxcXFByb2plY3Qtb25lLWZpeGVkXFxcXEZST05UIEVORCBWVUVUSUZZXFxcXHZpdGUuY29uZmlnLm1qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vRDovbGFyYWdvbi93d3cvUHJvamVjdC1vbmUtZml4ZWQvRlJPTlQlMjBFTkQlMjBWVUVUSUZZL3ZpdGUuY29uZmlnLm1qc1wiOy8vIFBsdWdpbnNcclxuaW1wb3J0IENvbXBvbmVudHMgZnJvbSBcInVucGx1Z2luLXZ1ZS1jb21wb25lbnRzL3ZpdGVcIjtcclxuaW1wb3J0IFZ1ZSBmcm9tIFwiQHZpdGVqcy9wbHVnaW4tdnVlXCI7XHJcbmltcG9ydCBWdWV0aWZ5LCB7IHRyYW5zZm9ybUFzc2V0VXJscyB9IGZyb20gXCJ2aXRlLXBsdWdpbi12dWV0aWZ5XCI7XHJcbmltcG9ydCBWaXRlRm9udHMgZnJvbSBcInVucGx1Z2luLWZvbnRzL3ZpdGVcIjtcclxuaW1wb3J0IFZ1ZVJvdXRlciBmcm9tIFwidW5wbHVnaW4tdnVlLXJvdXRlci92aXRlXCI7XHJcblxyXG4vLyBVdGlsaXRpZXNcclxuaW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSBcInZpdGVcIjtcclxuaW1wb3J0IHsgZmlsZVVSTFRvUGF0aCwgVVJMIH0gZnJvbSBcIm5vZGU6dXJsXCI7XHJcblxyXG4vLyBodHRwczovL3ZpdGVqcy5kZXYvY29uZmlnL1xyXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xyXG4gIHBsdWdpbnM6IFtcclxuICAgIFZ1ZVJvdXRlcigpLFxyXG4gICAgVnVlKHtcclxuICAgICAgdGVtcGxhdGU6IHsgdHJhbnNmb3JtQXNzZXRVcmxzIH0sXHJcbiAgICB9KSxcclxuICAgIC8vIGh0dHBzOi8vZ2l0aHViLmNvbS92dWV0aWZ5anMvdnVldGlmeS1sb2FkZXIvdHJlZS9tYXN0ZXIvcGFja2FnZXMvdml0ZS1wbHVnaW4jcmVhZG1lXHJcbiAgICBWdWV0aWZ5KHtcclxuICAgICAgYXV0b0ltcG9ydDogdHJ1ZSxcclxuICAgICAgc3R5bGVzOiB7XHJcbiAgICAgICAgY29uZmlnRmlsZTogXCJzcmMvc3R5bGVzL3NldHRpbmdzLnNjc3NcIixcclxuICAgICAgfSxcclxuICAgIH0pLFxyXG4gICAgQ29tcG9uZW50cygpLFxyXG4gICAgVml0ZUZvbnRzKHtcclxuICAgICAgZ29vZ2xlOiB7XHJcbiAgICAgICAgZmFtaWxpZXM6IFtcclxuICAgICAgICAgIHtcclxuICAgICAgICAgICAgbmFtZTogXCJSb2JvdG9cIixcclxuICAgICAgICAgICAgc3R5bGVzOiBcIndnaHRAMTAwOzMwMDs0MDA7NTAwOzcwMDs5MDBcIixcclxuICAgICAgICAgIH0sXHJcbiAgICAgICAgXSxcclxuICAgICAgfSxcclxuICAgIH0pLFxyXG4gIF0sXHJcbiAgZGVmaW5lOiB7IFwicHJvY2Vzcy5lbnZcIjoge30gfSxcclxuICByZXNvbHZlOiB7XHJcbiAgICBhbGlhczoge1xyXG4gICAgICBcIkBcIjogZmlsZVVSTFRvUGF0aChuZXcgVVJMKFwiLi9zcmNcIiwgaW1wb3J0Lm1ldGEudXJsKSksXHJcbiAgICB9LFxyXG4gICAgZXh0ZW5zaW9uczogW1wiLmpzXCIsIFwiLmpzb25cIiwgXCIuanN4XCIsIFwiLm1qc1wiLCBcIi50c1wiLCBcIi50c3hcIiwgXCIudnVlXCJdLFxyXG4gIH0sXHJcbiAgc2VydmVyOiB7XHJcbiAgICBwb3J0OiAzMDAwLFxyXG4gICAgcHJveHk6IFwiaHR0cDovL2xvY2FsaG9zdDo4MDAwXCIsXHJcbiAgfSxcclxuICBkZXZTZXJ2ZXI6IHtcclxuICAgIHByb3h5OiBcImh0dHA6Ly9sb2NhbGhvc3Q6ODAwMFwiLFxyXG4gIH0sXHJcbn0pO1xyXG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQ0EsT0FBTyxnQkFBZ0I7QUFDdkIsT0FBTyxTQUFTO0FBQ2hCLE9BQU8sV0FBVywwQkFBMEI7QUFDNUMsT0FBTyxlQUFlO0FBQ3RCLE9BQU8sZUFBZTtBQUd0QixTQUFTLG9CQUFvQjtBQUM3QixTQUFTLGVBQWUsV0FBVztBQVRtTCxJQUFNLDJDQUEyQztBQVl2USxJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUMxQixTQUFTO0FBQUEsSUFDUCxVQUFVO0FBQUEsSUFDVixJQUFJO0FBQUEsTUFDRixVQUFVLEVBQUUsbUJBQW1CO0FBQUEsSUFDakMsQ0FBQztBQUFBO0FBQUEsSUFFRCxRQUFRO0FBQUEsTUFDTixZQUFZO0FBQUEsTUFDWixRQUFRO0FBQUEsUUFDTixZQUFZO0FBQUEsTUFDZDtBQUFBLElBQ0YsQ0FBQztBQUFBLElBQ0QsV0FBVztBQUFBLElBQ1gsVUFBVTtBQUFBLE1BQ1IsUUFBUTtBQUFBLFFBQ04sVUFBVTtBQUFBLFVBQ1I7QUFBQSxZQUNFLE1BQU07QUFBQSxZQUNOLFFBQVE7QUFBQSxVQUNWO0FBQUEsUUFDRjtBQUFBLE1BQ0Y7QUFBQSxJQUNGLENBQUM7QUFBQSxFQUNIO0FBQUEsRUFDQSxRQUFRLEVBQUUsZUFBZSxDQUFDLEVBQUU7QUFBQSxFQUM1QixTQUFTO0FBQUEsSUFDUCxPQUFPO0FBQUEsTUFDTCxLQUFLLGNBQWMsSUFBSSxJQUFJLFNBQVMsd0NBQWUsQ0FBQztBQUFBLElBQ3REO0FBQUEsSUFDQSxZQUFZLENBQUMsT0FBTyxTQUFTLFFBQVEsUUFBUSxPQUFPLFFBQVEsTUFBTTtBQUFBLEVBQ3BFO0FBQUEsRUFDQSxRQUFRO0FBQUEsSUFDTixNQUFNO0FBQUEsSUFDTixPQUFPO0FBQUEsRUFDVDtBQUFBLEVBQ0EsV0FBVztBQUFBLElBQ1QsT0FBTztBQUFBLEVBQ1Q7QUFDRixDQUFDOyIsCiAgIm5hbWVzIjogW10KfQo=
