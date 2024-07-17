<template>
  <div>
    <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Correo Electrónico</th>
          <th>Teléfono</th>
          <!-- Añade más columnas según sea necesario -->
        </tr>
      </thead>
      <tbody>
        <tr v-for="empleado in empleados" :key="empleado.id">
          <td>{{ empleado.nombre }}</td>
          <td>{{ empleado.correo_electronico }}</td>
          <td>{{ empleado.telefono }}</td>
          <!-- Añade más datos según sea necesario -->
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'EmpleadosList',
  props: ['clinicaId'],
  data() {
    return {
      empleados: []
    };
  },
  watch: {
    // Monitorea cambios en clinicaId y llama a fetchEmpleados cuando cambia
    clinicaId(newVal, oldVal) {
      if (newVal !== oldVal) {
        this.fetchEmpleados();
      }
    }
  },
  created() {
    // Llama a fetchEmpleados solo si clinicaId está definido inicialmente
    if (this.clinicaId) {
      this.fetchEmpleados();
    }
  },
  methods: {
    fetchEmpleados() {
      axios.get(`http://127.0.0.1:8000/api/clinicas/${this.clinicaId}/empleados`)
        .then(response => {
          this.empleados = response.data;
        })
        .catch(error => {
          console.error('Error fetching empleados:', error);
        });
    }
  }
};
</script>

<style scoped>
/* Estilos específicos para el componente de empleados */
</style>
