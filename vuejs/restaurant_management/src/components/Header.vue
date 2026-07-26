<template>
  <header class="app-header">
    <h1 class="app-title">Restaurant Management</h1>      
    <nav class="nav">
      <router-link to="/">Home</router-link>
      <router-link to="/add">Add Restaurant</router-link>
      <router-link to="/update">Update Restaurant</router-link>
      <a href="#" v-on:click="logout">Logout</a>
    </nav>
  </header>
</template>

<script>
export default {
  name: "Header",
  methods: {
    logout() {
      localStorage.clear();
      this.$router.push({ name: "Login" });
    }
  }
};
</script>

<style scoped>
.app-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  background-color: #334155;
  color: white;
}

.nav a {
  color: white;
  text-decoration: none;
  margin-right: 15px;
  font-weight: 500;
}

.nav a:hover {
  text-color: #cbd5e1;
  text-decoration: underline;
}
</style>