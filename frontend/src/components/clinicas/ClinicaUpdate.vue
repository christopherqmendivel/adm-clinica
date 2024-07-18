<template>
  <ClinicaForm
    v-if="clinica"
    :clinica="clinica"
    @clinicaActualizada="handleClinicaActualizada"
    @closeModal="closeModal"
  />
</template>

<script>
import { defineComponent } from 'vue';
import ClinicaForm from './ClinicaForm.vue';

export default defineComponent({
  name: "ClinicaUpdate",
  components: {
    ClinicaForm,
  },
  props: {
    clinica: Object, // Propiedad que recibe la clínica a actualizar
  },
  methods: {
    handleClinicaActualizada(updatedClinica) {
      this.$emit("clinicaActualizada", updatedClinica); // Emitir evento con la clínica actualizada
    },
    closeModal() {
      this.$emit('closeModal'); // Emitir evento para cerrar modal en el componente padre
    },
  },
});
</script>

<style scoped>
/* Estilos específicos para el componente */
</style>
