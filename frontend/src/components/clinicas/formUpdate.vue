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

    <button type="submit" class="btn btn-update  me-2">Actualizar</button>
    <button type="button" @click="closeModal" class="btn btn-secondary">Cancelar</button>
  </form>
</template>

<script>
import { defineComponent, ref } from 'vue';
import axios from 'axios';

export default defineComponent({
  name: "ClinicaForm",
  props: {
    clinica: Object // Propiedad que recibe la clínica a actualizar
  },
  setup(props, { emit }) {
    const formData = ref({
      nombre: props.clinica ? props.clinica.nombre : '',
      correo_electronico: props.clinica ? props.clinica.correo_electronico : '',
      telefono: props.clinica ? props.clinica.telefono : ''
    });

    const submitForm = async () => {
      try {
        const response = await axios.put(`http://localhost:8000/api/clinicas/${props.clinica.id}`, formData.value);
        //console.log('Clínica actualizada:', response.data);
        emit("clinicaActualizada", response.data); 
        closeModal();
      } catch (error) {
        console.error('Error al actualizar la clínica:', error);
      }
    };

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
  transition: 0.3 ease-in-out;
}

.btn-update:hover {
  background-color: var(--greenHover);
  color: white;
}
</style>
