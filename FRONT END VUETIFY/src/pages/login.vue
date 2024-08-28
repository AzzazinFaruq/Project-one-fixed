<template>
  <v-container fluid class="">
    <v-row justify="center">
      <v-col>
        <v-card class="mt-10" elevation="2" max-width="500" location="center">
          <v-card-title>
            <h3 class="">LOGIN</h3>
          </v-card-title>
          <v-form @submit.prevent="login" class="ma-4">
            <v-text-field
              type="text"
              error-count=""
              placeholder="Insert Your Email"
              label=""
              append-icon=""
              v-model="form.email"
              variant="outlined"
              color
            ></v-text-field>
            <v-text-field
              type="password"
              error-count=""
              placeholder="Insert Your Password"
              label=""
              append-icon=""
              v-model="form.password"
              variant="outlined"
              color
            ></v-text-field>
            <!-- <v-row class="mb-4">
              <v-col>
                <p class="font-weight-light text-center">
                  <a class="no-underline" href="/register">Sign Up</a>
                </p>
              </v-col>
            </v-row> -->
            <v-btn
              location="center"
              class="mt-4"
              type="submit"
              elevation="2"
              color="green"
              align-center
              >Login</v-btn
            >
          </v-form>
        </v-card></v-col
      >
    </v-row>
  </v-container>
</template>
<script>
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
export var success=false;
export default {
  setup() {
    const router = useRouter();
    return {
      router,
    };
  },
  data() {
    return {
      role:"",
      success:false,
      form: {
        email: "",
        password: "",
      },
    };
  },
  mounted(){
    this.check();
  },
  methods: {
    check(){
      axios.get('/api/user')
      .then((res)=>{
        this.success=res.data.success;
        switch (this.success) {
            case true:
              alert('ANDA SUDAH LOGIN!!')
              this.$router.push('/dashboard')
              break;
            case false:
              break;
          }
      })
    },
    getToken() {
      axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          console.log(response);
        });
    },
    login() {
      this.getToken();
      try {
        axios.post("/api/login", this.form).then((res) => {
          this.success = res.data.success;
          switch (this.success) {
            case true:
              localStorage.setItem('token', res.data.data.token);
              localStorage.setItem('auth', 'true');
              localStorage.setItem('loginAlert', 'true');
              success=true;
              this.$router.push('/dashboard')
              break;
            case false:
              alert(res.data.message)
              break;
          }

        });
      } catch (error) {
        alert(error);
      }

    },
  },
};
</script>
<style scooped>
.no-underline {
  text-decoration: none !important;
  color: grey;
}
.no-underline:hover {
  color: black; /* Ganti dengan warna yang diinginkan */
}
</style>
