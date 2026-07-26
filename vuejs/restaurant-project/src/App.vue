<template>
  <div>
    <router-view></router-view>
</div>
</template>

<script>

export default {
  name: 'App'
}
</script>

<style>
.logo{
  width: 100px;
}
.register input ,.login input{
    width: 300px;
    height: 40px;
    padding-left: 20px;
    display: block;
    margin-bottom: 30px;
    margin-left: auto;
    margin-right: auto;
    border: 1px solid #222;
    border-radius: 7px;
    border: solid 1px skyblue;
}
.register button,.login button{
    width: 320px;
    height: 40px;
    border: 1px solid #222;
    border-radius: 7px;
    background-color: skyblue;
    cursor: pointer;
}

</style>