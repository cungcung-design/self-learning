import { createRouter, createWebHistory } from "vue-router";

import App from "./App.vue";

// Minimal router to satisfy main.js import.
// Replace routes with your actual pages when you add them.
const routes = [
  {
    path: "/",
    name: "home",
    component: App,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
