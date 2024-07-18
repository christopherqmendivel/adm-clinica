<template>
    <form @submit.prevent="submitForm" class="p-3">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" id="nombre" v-model="formData.nombre" class="form-control" required>
      </div>
  
      <div class="mb-3">
        <label for="correo" class="form-label">Correo Electrónico:</label>
        <input type="email" id="correo" v-model="formData.correo_electronico" class="form-control" required>
      </div>
  
      <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="tel" id="telefono" v-model="formData.telefono" class="form-control" required>
      </div>
  
      <button type="submit" class="btn btn-update me-2">Crear</button>
      <button type="button" @click="closeModal" class="btn btn-secondary">Cancelar</button>
    </form>
  </template>
  
  <script>
  import { defineComponent, ref } from 'vue';
  import axios from 'axios';
  
  export default defineComponent({
    name: "FormCreate",
    setup(props, { emit }) {
      // Datos del formulario
      const formData = ref({
        nombre: '',
        correo_electronico: '',
        telefono: ''
      });
  
      // Función para enviar el formulario
      const submitForm = async () => {
        try {
          // Enviar los datos al backend
          const response = await axios.post('http://localhost:8000/api/clinicas', formData.value);
          
          // Emitir evento para notificar que la clínica ha sido creada
          emit("clinicaCreada", response.data);
          
          // Limpiar los datos del formulario
          formData.value = {
            nombre: '',
            correo_electronico: '',
            telefono: ''
          };
  
          // Cerrar el modal
          closeModal();
        } catch (error) {
          console.error('Error al crear la clínica:', error);
        }
      };
  
      // Función para cerrar el modal
      const closeModal = () => {
        emit('closeModal');
      };
  
      return {
        formData,
        submitForm,
        closeModal
      };
    },
  });
  </script>
  
  <style scoped>
  .btn-update {
    background-color: var(--green);
    color: white;
    transition: 0.5s ease-in-out;

  }
  
  .btn-update:hover {
    background-color: var(--greenHover);
    color: white;
  }
  </style>
  