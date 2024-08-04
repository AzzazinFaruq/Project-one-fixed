<template>
  <h1>403 FORBIDDEN ACCESS</h1>
  <p>you dont have permission to acces this page</p>
  <a href="/home">Back to Home</a>
</template>
<script>
import { computed } from 'vue';
import { useRouter } from 'vue-router';
export default{
  setup(){
    const isAdmin = computed(() => localStorage.getItem('auth') === 'true');
    const route = useRouter();
    if (!isAdmin.value) {
      route.push('/login')
    }
  }
}

</script>
