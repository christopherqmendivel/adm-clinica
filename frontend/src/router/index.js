import { createRouter, createWebHistory } from 'vue-router';
import LayoutPage from '../components/Layout.vue';
import ClinicasPage from '../views/Clinicas.vue';
import EmpleadosPorClinica from '../views/EmpleadosPorClinica.vue';
import Empleados from '../views/Empleados.vue';
import Login from '../views/LoginPage.vue';
import { isLoggedIn } from '../services/authService';

const routes = [
  {
    path: '/',
    component: Login,
    meta: { requiresAuth: false }
  },
  {
    path: '/clinicas',
    component: LayoutPage,
    meta: { requiresAuth: true },
    children: [
      { path: '', component: ClinicasPage },
      { path: '/clinicas/:id/empleados', name: 'EmpleadosPorClinica', component: EmpleadosPorClinica, props: true },
      { path: '/empleados', component: Empleados }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  const requiresAuth = to.meta.requiresAuth;
  const loggedIn = isLoggedIn();

  if (requiresAuth && !loggedIn) {
    next('/'); // Redirigir a la página de login si no está autenticado
  } else if (to.path === '/' && loggedIn) {
    next('/clinicas'); // Redirigir a la página de clínicas si ya está autenticado
  } else {
    next();
  }
});

export default router;
