import Home from "./components/Home.vue";
import SignUp from "./components/SingUp.vue";
import Login from "./components/Login.vue";
import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    name: "Home",
    path: "/",
    component: Home,
  },
  {
    name: "SignUp",
    path: "/sign-up",
    component: SignUp,
  },
  {
    name: "Login",
    path: "/login",
    component: Login,
  },
];
const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
