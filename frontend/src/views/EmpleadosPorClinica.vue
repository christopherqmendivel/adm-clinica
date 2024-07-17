<template>
  <div>
    <h1 v-if="clinica">Clinica: {{ clinica.nombre }}</h1>
    <ul v-if="empleados.length > 0">
      <li v-for="empleado in empleados" :key="empleado.id">
        {{ empleado.nombre }} - {{ empleado.apellido }} - {{ empleado.correo_electronico }} - {{ empleado.telefono }}
      </li>
    </ul>
    <p v-else>No hay empleados registrados.</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'EmpleadosPorClinica',
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      clinica: null,
      empleados: []
    };
  },
  created() {
    this.fetchClinica();
  },
  methods: {
    fetchClinica() {
      axios.get(`http://127.0.0.1:8000/api/clinicas/${this.id}`)
        .then(response => {
          // Asignar la respuesta al objeto clinica
          this.clinica = response.data;
          // Llamar a fetchEmpleados después de obtener la clínica
          this.fetchEmpleados();
        })
        .catch(error => {
          console.error('Error fetching clinica:', error);
        });
    },
    fetchEmpleados() {
      axios.get(`http://127.0.0.1:8000/api/clinicas/${this.id}/empleados`)
        .then(response => {
          // Asignar la respuesta al array empleados
          this.empleados = response.data;
        })
        .catch(error => {
          console.error('Error fetching empleados:', error);
        });
    }
  }
};
</script>
