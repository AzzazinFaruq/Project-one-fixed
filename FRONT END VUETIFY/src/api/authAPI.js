import axios from "axios";

const auth = axios.create({
  baseURL: `htttp://127.0.0.1:8000/api`,
  headers: {
    "X-Requested-with": "XMLHttpRequest",
    accept: "application/json",
  },
  withCredentials: true,
  withXSRFToken: true
});

export default auth;
