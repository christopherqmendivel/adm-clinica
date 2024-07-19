<template>
  <form @submit.prevent="submitForm" class="p-3">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre:</label>
      <input type="text" id="nombre" v-model="formData.nombre" class="form-control" required> 
    </div>
    <div class="mb-3">
      <label for="apellido" class="form-label">Apellido:</label>
      <input type="text" id="apellido" v-model="formData.apellido" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="dni" class="form-label">DNI:</label>
      <input type="text" id="dni" v-model="formData.dni" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="correo" class="form-label">Correo Electrónico:</label>
      <input type="email" id="correo" v-model="formData.correo_electronico" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="telefono" class="form-label">Teléfono:</label>
      <input type="tel" id="telefono" v-model="formData.telefono" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-create me-2">Crear</button>
    <button type="button" @click="closeModal" class="btn btn-secondary">Cancelar</button>
  </form>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    clinicaId: {
      type: [String, Number],
      required: true
    }
  },
  data() {
    return {
      formData: {
        nombre: '',
        apellido: '',
        dni: '',
        correo_electronico: '',
        telefono: ''
      }
    };
  },
  methods: {
    async submitForm() {
      try {
        // Agregar clinicaId a los datos del formulario
        const response = await axios.post(`http://localhost:8000/api/clinicas/${this.clinicaId}/empleados`, {
          ...this.formData,
          clinica_id: this.clinicaId
        });
        this.$emit('empleadoCreado', response.data);
        this.resetForm();
        this.$emit('closeModal');
      } catch (error) {
        console.error('Error al crear el empleado:', error);
      }
    },
    resetForm() {
      this.formData = {
        nombre: '',
        apellido: '',
        dni: '',
        correo_electronico: '',
        telefono: ''
      };
    }
  }
};
</script>

<style scoped>
  .btn-create {
    background-color: var(--green);
    color: white;
    transition: 0.5s ease-in-out;

  }
  
  .btn-create:hover {
    background-color: var(--greenHover);
    color: white;
  }
</style>