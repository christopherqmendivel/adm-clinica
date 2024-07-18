<template>
  <form @submit.prevent="submitForm">
    <label>Nombre:</label>
    <input type="text" v-model="formData.nombre" required>

    <label>Correo Electrónico:</label>
    <input type="email" v-model="formData.correo_electronico" required>

    <label>Teléfono:</label>
    <input type="tel" v-model="formData.telefono" required>

    <button type="submit">Actualizar</button>
    <button type="button" @click="closeModal">Cancelar</button>
  </form>
</template>

<script>
import { defineComponent, ref } from 'vue';

export default defineComponent({
  name: "ClinicaForm",
  props: {
    clinica: Object
  },
  setup(props, { emit }) {
    const formData = ref({ nombre: '', correo_electronico: '', telefono: '' });

    // Si props.clinica tiene un valor, copiamos sus propiedades a formData
    if (props.clinica) {
      formData.value = { ...props.clinica };
    }

    const submitForm = () => {
      emit('clinicaActualizada', formData.value);
      closeModal();
    };

    const closeModal = () => {
      emit('closeModal'); // Emitir evento para cerrar el modal
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
/* Estilos específicos para el formulario */
</style>
