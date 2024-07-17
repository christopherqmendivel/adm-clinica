// router/index.js

import { createRouter, createWebHistory } from 'vue-router';

import Home from "../views/Home.vue";
import ClinicasPage from "../views/Clinicas.vue";
import Empleados from "../views/Empleados.vue";
import EmpleadosPorClinica from "../views/EmpleadosPorClinica.vue";

const routes = [
  {
    path: "/",
    component: Home,
  },
  {
    path: "/clinicas",
    component: ClinicasPage,
  },
  {
    path: "/clinicas/:id/empleados",
    name: "EmpleadosPorClinica",
    component: EmpleadosPorClinica,
    props: true,
  },
  {
    path: "/empleados",
    component: Empleados,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
