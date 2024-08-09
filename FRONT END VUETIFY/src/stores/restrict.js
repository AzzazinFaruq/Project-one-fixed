import { defineStore } from "pinia";
import { computed } from "vue";
import { useRouter } from "vue-router";
export const test = defineStore({
  id: "setup",
  actions: {
    setup(){
      const isAdmin = computed(() => localStorage.getItem('auth') === 'true');
      const route = useRouter();
      if (!isAdmin.value) {
        route.push('/login')
      }
    }
  },
});
