<template>
  <div>
    <h1>Clínicas</h1>
    <h2>Listado de clínicas</h2>
    
    <!-- Botón para Crear Nueva Clínica -->
    <button
      type="button"
      @click="showCreateModal = true"
      class="btn btn-create mb-3"
    >
      Crear Nueva Clínica
    </button>

    <!-- Modal de Creación de Clínica -->
    <b-modal v-model="showCreateModal" title="Crear Nueva Clínica" hide-footer>
      <FormCreate
        @clinicaCreada="handleClinicaCreada"
        @closeModal="closeCreateModal"
      />
    </b-modal>

    <!-- Modal de Actualización de Clínica -->
    <b-modal v-model="showUpdateModal" title="Editar Clínica" hide-footer>
      <FormUpdate
        :clinica="selectedClinica"
        @clinicaActualizada="handleClinicaActualizada"
        @closeModal="closeUpdateModal"
      />
    </b-modal>

    <!-- Listado de Clínicas -->
    <ClinicasList
      :clinicas="clinicas.data"
      @selectClinica="handleSelectClinica"
    />
  </div>
</template>

<script>
import axios from "axios";
import ClinicasList from "@/components/clinicas/ClinicasList.vue";
import FormCreate from "@/components/clinicas/FormCreate.vue";
import FormUpdate from "@/components/clinicas/FormUpdate.vue";
import { BModal } from "bootstrap-vue-next";
import { useToast } from 'vue-toastification'; 

export default {
  name: 'ClinicasPage',
  components: {
    ClinicasList,
    FormCreate,
    FormUpdate,
    BModal,
  },
  data() {
    return {
      clinicas: {
        data: [],
      },
      selectedClinica: null,
      showCreateModal: false,
      showUpdateModal: false,
    };
  },
  created() {
    this.fetchClinicas();
  },
  methods: {
    async fetchClinicas(page = 1) {
      try {
        const response = await axios.get(`http://localhost:8000/api/clinicas?page=${page}`);
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
    handleClinicaCreada(newClinica) {
      // Agregar la nueva clínica a la lista y cerrar el modal
      this.clinicas.data.push(newClinica);
      this.showCreateModal = false;

      // Mostrar notificación
      const toast = useToast();
      toast.success('Clínica creada exitosamente');
    },
    closeCreateModal() {
      this.showCreateModal = false;
    },
    closeUpdateModal() {
      this.showUpdateModal = false;
    }
  },
};
</script>

<style scoped>
.btn-create {
  background-color: var(--green);
  color: white;
  transition: 0.3s ease-in-out;
}

.btn-create:hover {
  background-color: var(--greenHover);
  color: white;
}
</style>
