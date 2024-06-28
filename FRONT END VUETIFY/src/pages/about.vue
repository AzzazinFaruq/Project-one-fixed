<template>
  <v-container class="">
   <v-form @submit.prevent="login">
            <v-text-field
              ma-3
              pa-3
              type="text"
              placeholder="Inset Your Email"
              label="Email"
              append-icon=""
              v-model="form.email"
              outlined
              color
            ></v-text-field>
            <v-text-field
              ma-3
              pa-3
              type="password"
              placeholder="Inset Your Password"
              label="Password"
              append-icon=""
              v-model="form.password"
              outlined
              color
            ></v-text-field>
            <v-btn align="center" flat small color="green"
              >text</v-btn
            >
          </v-form>
  </v-container>
</template>
<script setup>
import HelloWorld from "@/components/HelloWorld.vue";
</script>
