<template>
  <div>
    <div class="top d-flex justify-content-between align-items-center">
      <h1>Clínicas</h1>

      <!-- Botón de Logout -->
      <button class="btn btn-logout text-white" @click="handleLogout">
        Cerrar Sesión
      </button>
    </div>

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
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { BModal } from 'bootstrap-vue-next';

import { useRouter } from 'vue-router';
import { logout } from '../services/authService.js';

import ClinicasList from '@/components/clinicas/ClinicasList.vue';
import FormCreate from '@/components/clinicas/FormCreate.vue';
import FormUpdate from '@/components/clinicas/FormUpdate.vue';






export default {
  name: 'ClinicasPage',
  components: {
    ClinicasList,
    FormCreate,
    FormUpdate,
    BModal,
  },
  setup() {
    const router = useRouter();
    const toast = useToast();

    const handleLogout = async () => {
      try {
        await logout(); 
        router.push('/');
      } catch (error) {
        toast.error('Error al cerrar sesión. Por favor, intenta de nuevo.');
        console.error('Error al cerrar sesión:', error);
      }
    };

    return { handleLogout };
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
      const index = this.clinicas.data.findIndex((clinica) => clinica.id === updatedClinica.id);
      if (index !== -1) {
        this.clinicas.data.splice(index, 1, updatedClinica);
      }
      this.selectedClinica = null;
      this.showUpdateModal = false;
    },
    handleClinicaCreada(newClinica) {
      this.clinicas.data.push(newClinica);
      this.showCreateModal = false;

      const toast = useToast();
      toast.success('Clínica creada exitosamente');
    },
    closeCreateModal() {
      this.showCreateModal = false;
    },
    closeUpdateModal() {
      this.showUpdateModal = false;
    },
  },
};
</script>

<style scoped>
.top {
  padding: 10px;
  background-color: var(--topBarBG);
  color: white;
}



.btn-logout {
  background-color: var(--green);
}

.btn-logout:hover {
  background-color: var(--greenHover);
}

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
