<template>
  <div>
    <h1>Clínicas</h1>

    <!-- Listado de Clínicas -->
    <ClinicasList :clinicas="clinicas"
                  @selectClinica="handleSelectClinica"
                  @clinicaEliminada="handleClinicaEliminada" />

    <!-- Modal de Actualización de Clínica -->
    <ClinicaUpdate
      v-if="selectedClinica && !showEmpleadosList"
      :clinica="selectedClinica"
      @clinicaActualizada="handleClinicaActualizada"
    />

  </div>
</template>

<script>
import axios from 'axios';
import ClinicasList from "@/components/clinicas/ClinicasList.vue";
import ClinicaUpdate from '@/components/clinicas/ClinicaUpdate.vue';

export default {
  name: 'ClinicasPage',
  components: {
    ClinicasList,
    ClinicaUpdate,
    // Otros componentes necesarios
  },
  data() {
    return {
      clinicas: [], 
      selectedClinica: null,
    };
  },
  created() {
    this.fetchClinicas();
  },
  methods: {
    fetchClinicas(page = 1) {
      axios.get(`http://127.0.0.1:8000/api/clinicas?page=${page}`)
        .then(response => {
          this.clinicas = response.data;
        })
        .catch(error => {
          console.error('Error fetching clinicas:', error);
        });
    },
    handleSelectClinica(clinica) {
      this.selectedClinica = clinica;
    },
    handleClinicaEliminada() {
      this.fetchClinicas();
      this.selectedClinica = null;
    },
    handleClinicaActualizada(updatedClinica) {
      const index = this.clinicas.data.findIndex(clinica => clinica.id === updatedClinica.id);
      if (index !== -1) {
        this.clinicas.data.splice(index, 1, updatedClinica);
      }
      this.selectedClinica = null;
    },
    // Otros métodos según sea necesario
  },
};
</script>

<style scoped>
/* Estilos específicos */
</style>
