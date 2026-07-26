<template>
  <div>
    <img class="logo" src="../assets/food_logo.png" alt="">
    <h1>Sign Up</h1>
  </div>
  <div class="register ">
  <input type="text " v-model="name" placeholder="
  Enter Your Name">
   <input type="text " v-model="email" placeholder="
  Enter Your Email">
   <input type="text " v-model="password" placeholder="
  Enter Your Password">
  <button v-on:click="signUp">Sign Up</button>
  <p>
    <router-link to="/login">Login</router-link>
  </p>
  </div>
</template>

<script>
import axios from 'axios';
  export default {
    
    name: 'SignUp',
    data() {
      return {
        name: '',
        email: '',
        password: '',
        
      }
    },
    methods: {
     async signUp() {
        let result =await axios.post("http://localhost:3000/users", {
          name: this.name,
          email: this.email,
          password: this.password
        });

        console.log(result);
        console.warn(result);
        if(result.status === 201){
          alert("Sign Up Successfully");
          localStorage.setItem("user-info", JSON.stringify(result.data));
          this.$router.push({name: 'Home'});
        }
      }
    },
    mounted() {
      let user = localStorage.getItem('user-info');
      if(user){
        this.$router.push({name: 'Home'});
      }
    }
  }
</script>

<style >
</style>