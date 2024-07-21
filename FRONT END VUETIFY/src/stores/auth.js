import { defineStore } from "pinia";
import axios from 'axios';

export const useRole = defineStore("auth", {
  state: () => ({
    isAuthenticated: false,
    role:""
  }),
  actions: {
    check(){
  try{
    axios.get("http://localhost:8000/api/user")
    .then((res)=>{
      console.log(res.data);
      this.role=res.data.level

    })

  }
  catch(error){
    console.log("error : " + error)
  }
    },
    login() {
      this.isAuthenticated = true;
    },
    logout() {
      this.isAuthenticated = false;
    },
  },
});
