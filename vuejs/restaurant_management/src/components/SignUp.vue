<template>
  <div class="auth-container">
    <form class="auth-form" @submit.prevent="signup">
      <img alt="Vue logo" class="logo" src="../assets/logo.png" />
      <h1 class="title">Sign Up</h1>

      <input type="text" placeholder="Enter your name" v-model="name" required />
      <input type="email" placeholder="Enter your email" v-model="email" required />
      <input type="password" placeholder="Enter your password" v-model="password" required />
      
      <button type="submit" class="submit-btn">Create Account</button>
      
      <p class="redirect">
        Already have an account? <router-link to="/login">Login</router-link>
      </p>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "SignUp",
  data() {
    return {
      name: "",
      email: "",
      password: "",
    };
  },
  methods: {
    async signup() {
      try {
        let result = await axios.post("http://localhost:3000/users", {
          name: this.name,
          email: this.email,
          password: this.password,
        });

        console.warn(result);

        if (result.status === 200 || result.status === 201) {
          (localStorage.setItem("user", JSON.stringify(result.data)),
            this.$router.push({ name: "Home" }));
        } else {
          alert("Registration failed. Please try again.");
        }
      } catch (error) {
        console.error("API Error:", error);
        alert("An error occurred while connecting to the server.");
      }
    },
  },
  mounted() {
    const user = localStorage.getItem("user");
    if (user) {
      this.$router.push({ name: "Home" });
    }
  },
};
</script>

<style scoped>
@import '../assets/auth.css';
</style>
