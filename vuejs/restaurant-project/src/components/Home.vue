<template>
  <div>
    <h1>Hello user, Welcome on Home Page</h1>
  </div>
</template>

<script>
export default {
  name: 'Home',
      mounted() {
      let user = localStorage.getItem('user-info');
      if(user){
        this.$router.push({name: 'SignUp'});
      }
    }

}
</script>