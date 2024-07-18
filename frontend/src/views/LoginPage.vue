<template>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4" style="max-width: 400px; width: 100%;">
      <h3 class="card-title text-center mb-4">Iniciar Sesión</h3>
      <form @submit.prevent="handleLogin">
        <div class="mb-3">
          <label for="email" class="form-label text-white">Correo Electrónico:</label>
          <input
            type="email"
            v-model="form.email"
            id="email"
            class="form-control"
            placeholder="Ingresa tu correo electrónico"
            required
          />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label text-white">Contraseña:</label>
          <input
            type="password"
            v-model="form.password"
            id="password"
            class="form-control"
            placeholder="Ingresa tu contraseña"
            required
          />
        </div>
        <button type="submit" class="btn btn-login w-100">Iniciar Sesión</button>
      </form>
    </div>
  </div>
</template>

<script>
import { login } from '../services/authService';
import { useToast } from 'vue-toastification';

export default {
  name: 'LoginPage',
  data() {
    return {
      form: {
        email: '',
        password: ''
      }
    };
  },
  methods: {
    async handleLogin() {
      const toast = useToast(); 
      try {
        // Intenta hacer login
        await login(this.form.email, this.form.password);

        // Redirige a la página de clínicas si el login es exitoso
        this.$router.push('/clinicas');

      } catch (error) {
        let message = 'Usuario o contraseña incorrecto.';

        if (error.response && error.response.data && error.response.data.message) {
          message = error.response.data.message;
        } else if (error.response && error.response.status === 401) {
          message = 'Correo electrónico o contraseña incorrectos.';
        }

        // Muestra el mensaje de error con toast
        toast.error(message);
        console.error('Error de autenticación:', error);
      }
    }
  }
};
</script>

<style scoped>
.card {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  background-color: var(--loginBG);
}
.card-title {
  color: var(--green);
}
.btn-login {
  background-color: var(--green);
  color: white;
  transition: 0.3s ease-in-out;
}

.btn-login:hover {
  background-color: var(--greenHover);
  color: white;
}
</style>
