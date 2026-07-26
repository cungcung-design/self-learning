<template>
  <header>
    <nav
      class="container flex flex-col sm:flex-row items-center gap-4 text-white py-6"
    >
      <RouterLink :to="{ name: 'home' }">
        <div class="flex items-center gap-3">
          <i class="fa-solid fa-sun text-2xl"></i>
          <p class="text-2xl">The Local Weather</p>
        </div>
      </RouterLink>

      <div class="flex gap-3 flex-1 justify-end">
        <i
          class="fa-solid fa-circle-info text-xl hover:text-weather-secondary duration-500 cursor-pointer"
          role="button"
          tabindex="0"
          @click="isModalOpen = true"
        ></i>

        <i
          class="fa-solid fa-plus text-xl hover:text-weather-secondary duration-500 cursor-pointer"
          role="button"
          tabindex="0"
          @click="isModalOpen = true"
        ></i>
      </div>

      <BaseModal :open="isModalOpen" @close="isModalOpen = false" />
    </nav>
  </header>
</template>

<script setup>
import { ref } from "vue";
import { RouterLink } from "vue-router";
import BaseModal from "./BaseModal.vue";

const isModalOpen = ref(false);
</script>

<style></style>
