<template>
  <div>
    <h2>Editar Clínica</h2>
    <form @submit.prevent="updateClinica">
      <label>Nombre:</label>
      <input type="text" v-model="editedClinica.nombre" required>
      <br>
      <label>Correo Electrónico:</label>
      <input type="email" v-model="editedClinica.correo_electronico" required>
      <br>
      <label>Teléfono:</label>
      <input type="tel" v-model="editedClinica.telefono" required>
      <br>
      <button type="submit">Guardar Cambios</button>
    </form>
    <div v-if="errors.length">
      <h3>Errores:</h3>
      <ul>
        <li v-for="error in errors" :key="error">{{ error }}</li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
  name: 'ClinicaUpdate',
  props: ['clinica'],
  data() {
    return {
      editedClinica: {
        id: this.clinica.id,
        nombre: this.clinica.nombre,
        correo_electronico: this.clinica.correo_electronico,
        telefono: this.clinica.telefono,
      },
      errors: [],
      toast: useToast()
    };
  },
  watch: {
    clinica(newClinica) {
      this.editedClinica = {
        id: newClinica.id,
        nombre: newClinica.nombre,
        correo_electronico: newClinica.correo_electronico,
        telefono: newClinica.telefono,
      };
    }
  },
  methods: {
    updateClinica() {
      this.errors = [];
      axios.put(`http://127.0.0.1:8000/api/clinicas/${this.editedClinica.id}`, this.editedClinica)
        .then(response => {
          this.toast.success('Clínica actualizada correctamente');
          this.$emit('clinicaActualizada', response.data);
        })
        .catch(error => {
          if (error.response && error.response.data.errors) {
            this.errors = Object.values(error.response.data.errors).flat();
          }
          this.toast.error('Error al actualizar la clínica');
          console.error('Error al actualizar clínica:', error.response.data);
        });
    }
  }
};
</script>

<style scoped>
</style>
