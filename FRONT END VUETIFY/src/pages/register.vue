<template>
  <v-container fluid class="">
    <v-row justify="center">
      <v-col>
        <v-card class="mt-5" elevation="2" max-width="500" location="center">
          <v-card-title>
            <h3 class="">Register</h3>
          </v-card-title>
          <v-form class="ma-4" @submit.prevent="register">
            <label class="font-weight-medium" for="">Name</label>
            <v-text-field
              class="mt-1"
              type="text"
              error-count=""
              placeholder="Insert Your Name"
              label=""
              append-icon=""
              variant="outlined"
              v-model="form.name"
              required
              color
            ></v-text-field>
            <label class="font-weight-medium" for="">Email</label>
            <v-text-field
              class="mt-1"
              type="text"
              error-count=""
              placeholder="Insert Your Email"
              label=""
              append-icon=""
              variant="outlined"
              v-model="form.email"
              required
              color
            ></v-text-field>
            <label class="font-weight-medium" for="">Password</label>
            <v-text-field
              class="mt-1"
              type="password"
              error-count=""
              placeholder="Insert Your Password"
              label=""
              append-icon=""
              variant="outlined"
              v-model="form.password"
              required
              color
            ></v-text-field>
            <label class="font-weight-medium" for="">Confirm Password</label>
            <v-text-field
              class="mt-1"
              type="password"
              error-count=""
              placeholder="Confirm Your Password"
              label=""
              append-icon=""
              variant="outlined"
              v-model="form.confirm_password"
              required
              color
            ></v-text-field>

            <v-btn
              location="center"
              class="mt-4"
              type="submit"
              elevation="2"
              color="green"
              align-center
              >Register</v-btn
            >
          </v-form>
        </v-card></v-col
      >
    </v-row>
  </v-container>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      form: {
        name: "",
        email: "",
        password: "",
        confirm_password: "",
      },
    };
  },
  methods: {
    register() {
      try {
        axios
          .post("/api/register", this.form)
          .then((res) => {
            console.log(res.data);
            this.$router.push("/login");
          });
      } catch (error) {
        error;
      }
    },
  },
};
</script>
