<template>
  <div>
    <h1>Clínicas</h1>

    <!-- Listado de Clínicas -->
    <ClinicasList
      :clinicas="clinicas"
      @selectClinica="handleSelectClinica"
    />

    <!-- Modal de Actualización de Clínica -->
    <b-modal v-model="showUpdateModal" title="Editar Clínica" hide-footer>
      <FormUpdate
        :clinica="selectedClinica"
        @clinicaActualizada="handleClinicaActualizada"
      />
    </b-modal>
  </div>
</template>

<script>
import axios from 'axios';
import ClinicasList from "@/components/clinicas/ClinicasList.vue";
import FormUpdate from '@/components/clinicas/formUpdate.vue'; 
import { BModal } from 'bootstrap-vue-next';

export default {
  name: 'ClinicasPage',
  components: {
    ClinicasList,
    FormUpdate,
    BModal,
  },
  data() {
    return {
      clinicas: [],
      selectedClinica: null,
      showUpdateModal: false,
    };
  },
  created() {
    this.fetchClinicas();
  },
  methods: {
    async fetchClinicas(page = 1) {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/clinicas?page=${page}`);
        this.clinicas = response.data.data; // Asegúrate de ajustar esto según la estructura de tu respuesta
      } catch (error) {
        console.error('Error fetching clinicas:', error);
      }
    },
    handleSelectClinica(clinica) {
      this.selectedClinica = clinica;
      this.showUpdateModal = true;
    },
    async handleClinicaActualizada(updatedClinica) {
      const index = this.clinicas.findIndex(clinica => clinica.id === updatedClinica.id);
      if (index !== -1) {
        this.clinicas.splice(index, 1, updatedClinica);
      }
      this.selectedClinica = null;
      this.showUpdateModal = false;
    },
  },
};
</script>

<style scoped>
/* Estilos específicos */
</style>
