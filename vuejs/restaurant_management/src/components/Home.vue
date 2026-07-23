<template>
  <div>
    <Header />
    <h1>Welcome to the Restaurant Management System</h1>
    <p>This is the home page. You can manage your restaurants here.</p>
  </div>  
</template>

<script>
import Header from "./Header.vue";

export default {
  name: "Home",
  components: { Header },
  mounted() {
    const user = localStorage.getItem("user");
    if (!user) {
      this.$router.push({ name: "SignUp" });
    }
  },
};
</script>
