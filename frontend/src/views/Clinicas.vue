<template>
  <div>
    <h1>Clínicas</h1>

    <!-- Listado de Clínicas -->
    <ClinicasList
      :clinicas="clinicas.data"
      @selectClinica="handleSelectClinica"
      @clinicaActualizada="handleClinicaActualizada"
    />

    <!-- Modal de Actualización de Clínica -->
    <b-modal v-model="showUpdateModal" title="Editar Clínica" hide-footer>
      <ClinicaUpdate
        :clinica="selectedClinica"
        @clinicaActualizada="handleClinicaActualizada"
      />
    </b-modal>
  </div>
</template>

<script>
import axios from 'axios';
import ClinicasList from "@/components/clinicas/ClinicasList.vue";
import ClinicaUpdate from '@/components/clinicas/ClinicaUpdate.vue';
import { BModal } from 'bootstrap-vue-next';

export default {
  name: 'ClinicasPage',
  components: {
    ClinicasList,
    ClinicaUpdate,
    BModal,
  },
  data() {
    return {
      clinicas: {
        data: [],
      },
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
        this.clinicas = response.data;
      } catch (error) {
        console.error('Error fetching clinicas:', error);
      }
    },
    handleSelectClinica(clinica) {
      this.selectedClinica = clinica;
      this.showUpdateModal = true;
    },
    async handleClinicaActualizada(updatedClinica) {
      const index = this.clinicas.data.findIndex(clinica => clinica.id === updatedClinica.id);
      if (index !== -1) {
        this.clinicas.data.splice(index, 1, updatedClinica);
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
