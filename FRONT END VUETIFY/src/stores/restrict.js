import { defineStore } from "pinia";

export const useUserStore = defineStore('user', {
  state: () => ({
    role: 'user', // Default role, bisa diganti sesuai kebutuhan
  }),
  actions: {
    setRole(newRole) {
      this.role = newRole;
    },
    isRole(role) {
      return this.role === role;
    },
    isNotRole(role) {
      return this.role !== role;
    },
  },
});
