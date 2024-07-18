<template>
  <div>
    <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Correo Electrónico</th>
          <th>Teléfono</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="empleado in empleados" :key="empleado.id">
          <td>{{ empleado.nombre }}</td>
          <td>{{ empleado.correo_electronico }}</td>
          <td>{{ empleado.telefono }}</td>
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
    clinicaId(newVal, oldVal) {
      if (newVal !== oldVal) {
        this.fetchEmpleados();
      }
    }
  },
  created() {
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
    },
    // Método para manejar el evento empleadoActualizado
    actualizarEmpleado(empleadoActualizado) {
      // Buscar el empleado en la lista y actualizarlo
      const index = this.empleados.findIndex(emp => emp.id === empleadoActualizado.id);
      if (index !== -1) {
        // Actualizar el empleado en la lista
        this.empleados.splice(index, 1, empleadoActualizado);
      }
    }
  },
  // Escuchar el evento empleadoActualizado de ClinicaUpdate.vue
  emits: ['empleadoActualizado'],
  // Manejar el evento empleadoActualizado
  setup(props, { onEmpleadoActualizado }) {
    onEmpleadoActualizado((empleadoActualizado) => {
      this.actualizarEmpleado(empleadoActualizado);
    });
  }
};
</script>


<style scoped>
/* Estilos específicos para el componente de empleados */
</style>
