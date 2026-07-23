<template>
  <div class="auth-container">
    <form class="auth-form" @submit.prevent="login">
      <img alt="Vue logo" class="logo" src="../assets/logo.png" />
      <h1 class="title">Login</h1>

      <input type="email" v-model="email" placeholder="Enter Email" required />
      <input
        type="password"
        v-model="password"
        placeholder="Enter Password"
        required
      />

      <button type="submit" class="submit-btn">Login</button>

      <p class="redirect">
        Don't have an account? <router-link to="/sign_up">Sign Up</router-link>
      </p>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Login",
  setup() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    async login() {
      try {
        const result = await axios.get(
          `http://localhost:3000/users?email=${this.email}&password=${this.password}`,
        );

        if (result.data.length > 0) {
          localStorage.setItem("user", JSON.stringify(result.data[0]));
          this.$router.push({ name: "Home" });
        } else {
          alert("Invalid email or password. Please try again.");
        }
      } catch (error) {
        console.error("API Error:", error);
        alert("An error occurred while connecting to the server.");
      }
    },
  },
};
</script>
<style scoped>
@import "../assets/auth.css";
</style>
