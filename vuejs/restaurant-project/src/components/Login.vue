<template>
  <div>
    <img class="logo" src=" ../assets/food_logo.png" alt="">
    <h1>Login</h1>
    <div class=" login ">
 
       <input type="text " placeholder="
      Enter Your Email">
       <input type="text " placeholder="
      Enter Your Password">
      <button>Login</button>
      <p>
        <router-link to="/sign-up">Sign Up</router-link>
      </p>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Login'
  }
</script>

<style scoped>

</style>