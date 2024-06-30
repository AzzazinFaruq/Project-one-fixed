<template>
  <v-container class="">
    <v-row cols="12" justify-center>
      <v-col sm="3"></v-col>
      <v-col sm="6">
        <v-sheet color="grey">
          <v-form @submit.prevent="login">
            <v-text-field type="text" error-count="" placeholder="Insert Your Email" label="" append-icon=""
              v-model="form.email" outlined color></v-text-field>
            <v-text-field type="password" error-count="" placeholder="Insert Your Password" label="" append-icon=""
              v-model="form.password" outlined color></v-text-field>
            <v-btn type="submit" elevation="2" color="green" align-center>Login</v-btn>
          </v-form>

        </v-sheet>
      </v-col>
      <v-col sm="3"></v-col>
    </v-row>
  </v-container>
</template>
<script setup>
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";
const router = useRouter();
const form = ref({
  email: "",
  password: "",
});
const getToken = async () => {
  await axios.get("/sanctum/csrf-cookie");
};
const login = async () => {
  await getToken();
  await axios.post("/auth/login", {
    email: form.value.email,
    password: form.value.password,
  });
  router.push("/");
};
</script>
