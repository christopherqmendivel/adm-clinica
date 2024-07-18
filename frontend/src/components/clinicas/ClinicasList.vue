<template>
  <div>
    <h2>Listado de Clínicas</h2>
    <table class="table table-dark table-hover table-striped">
      <!-- Encabezados de la tabla -->
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Correo Electrónico</th>
          <th>Teléfono</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <!-- Cuerpo de la tabla -->
      <tbody>
        <tr v-for="clinica in localClinicas.data" :key="clinica.id">
          <td>{{ clinica.nombre }}</td>
          <td>{{ clinica.correo_electronico }}</td>
          <td>{{ clinica.telefono }}</td>
          <td class="d-flex buttons-crud">
            <!-- Botón para actualizar -->
            <button
              type="button"
              @click="showUpdateModalHandler(clinica)"
              title="Actualizar"
              class="btn button"
            >
              <i class="fa-regular fa-pen-to-square btn-update text-success"></i>
            </button>

            <!-- Botón para eliminar -->
            <button
              type="button"
              @click="showDeleteModalHandler(clinica)"
              title="Eliminar"
              class="btn button"
            >
              <i class="fa-regular fa-trash-can text-danger"></i>
            </button>

            <!-- Enlace para ver empleados de la clínica -->
            <router-link
              :to="{ name: 'EmpleadosPorClinica', params: { id: clinica.id } }"
              class="btn text-primary button"
              title="Ver Empleados"
            >
              <i class="fa-regular fa-eye"></i>
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal para eliminar clínica -->
    <b-modal v-model="showDeleteModal" title="Eliminar Clínica" hide-footer @hide="closeModalDelete">
      <ClinicaDelete
        :showModal="true"
        :clinica="selectedClinica"
        @closeModal="closeModalDelete"
        @clinicaEliminada="eliminarClinica"
      />
    </b-modal>

    <!-- Modal para actualizar clínica -->
    <b-modal v-model="showUpdateModal" title="Actualizar Clínica" hide-footer @hide="closeModalUpdate">
      <ClinicaUpdate
        :clinica="selectedClinica"
        @clinicaActualizada="handleClinicaActualizada"
        @closeModal="closeModalUpdate"
      />
    </b-modal>

    <!-- Paginación -->
    <!-- ... Código de paginación ... -->
  </div>
</template>

<script>
import axios from 'axios';
import ClinicaDelete from '@/components/clinicas/ClinicaDelete.vue';
import ClinicaUpdate from '@/components/clinicas/ClinicaUpdate.vue';
import { BModal } from 'bootstrap-vue-next';

export default {
  name: 'ClinicasList',
  components: {
    ClinicaDelete,
    ClinicaUpdate,
    BModal,
  },
  data() {
    return {
      localClinicas: {
        data: [],
        current_page: 1,
        last_page: 1,
        next_page_url: null,
        prev_page_url: null,
      },
      selectedClinica: null,
      showUpdateModal: false,
      showDeleteModal: false, // Inicializado en false para no mostrar el modal de eliminación por defecto
    };
  },
  methods: {
    async fetchClinicas(page = 1) {
      const url = `http://localhost:8000/api/clinicas?page=${page}`;
      try {
        const response = await axios.get(url);
        this.localClinicas = response.data;
      } catch (error) {
        console.error('Error al cargar las clínicas:', error);
      }
    },

    async eliminarClinica(idClinica) {
      try {
        // Hacer la petición DELETE para eliminar la clínica
        await axios.delete(`http://localhost:8000/api/clinicas/${idClinica}`);
        
        // Actualizar la lista de clínicas después de la eliminación
        this.localClinicas.data = this.localClinicas.data.filter(clinica => clinica.id !== idClinica);
        
        // Cerrar el modal de eliminación
        this.closeModalDelete();
      } catch (error) {
        console.error('Error al eliminar la clínica:', error);
      }
    },

    async handleClinicaActualizada(updatedClinica) {
      const index = this.localClinicas.data.findIndex(clinica => clinica.id === updatedClinica.id);
      if (index !== -1) {
        this.localClinicas.data.splice(index, 1, updatedClinica);
      }
      this.closeModalUpdate(); // Cerrar modal de actualización
    },

    showUpdateModalHandler(clinica) {
      this.selectedClinica = clinica;
      this.showUpdateModal = true; // Mostrar modal de actualización
    },

    showDeleteModalHandler(clinica) {
      this.selectedClinica = clinica;
      this.showDeleteModal = true; // Mostrar modal de eliminación
    },

    closeModalUpdate() {
      this.showUpdateModal = false; // Cerrar modal de actualización
    },

    closeModalDelete() {
      this.showDeleteModal = false; // Cerrar modal de eliminación
    },
  },

  mounted() {
    this.fetchClinicas();
  },
};
</script>

<style scoped>
/* Estilos específicos para el componente */
</style>
