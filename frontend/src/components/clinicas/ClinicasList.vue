<template>
  <div>
    <table class="table table-dark table-hover table-striped">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Correo Electrónico</th>
          <th>Teléfono</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="clinica in localClinicas.data" :key="clinica.id">
          <td>{{ clinica.nombre }}</td>
          <td>{{ clinica.correo_electronico }}</td>
          <td>{{ clinica.telefono }}</td>
          <td class="d-flex buttons-crud">

            <!-- Botón Actualizar -->
            <button
              type="button"
              @click="showUpdateModalHandler(clinica)"
              title="Actualizar"
              class="btn button"
            >
              <i class="fa-regular fa-pen-to-square btn-update text-success"></i>
            </button>

            <router-link
              :to="{ name: 'EmpleadosPorClinica', params: { id: clinica.id } }"
              class="btn text-primary button"
              title="Ver Empleados"
            >
              <i class="fa-regular fa-eye"></i>
            </router-link>

             <!-- Botón Eliminar -->
            <button
              type="button"
              @click="showDeleteModalHandler(clinica)"
              title="Eliminar"
              class="btn button"
            >
              <i class="fa-regular fa-trash-can text-danger"></i>
            </button>
           
          </td>
        </tr>
      </tbody>
    </table>

    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: !localClinicas.prev_page_url }">
          <button
            class="page-link"
            @click="goToPage(localClinicas.current_page - 1)"
            :disabled="!localClinicas.prev_page_url"
          >
            Anterior
          </button>
        </li>
        <li v-for="page in localClinicas.last_page" :key="page" class="page-item" :class="{ active: localClinicas.current_page === page }">
          <button class="page-link" @click="goToPage(page)">{{ page }}</button>
        </li>
        <li class="page-item" :class="{ disabled: !localClinicas.next_page_url }">
          <button
            class="page-link"
            @click="goToPage(localClinicas.current_page + 1)"
            :disabled="!localClinicas.next_page_url"
          >
            Siguiente
          </button>
        </li>
      </ul>
    </nav>

    <b-modal v-model="showUpdateModal" title="Actualizar Clínica" hide-footer @hide="closeModalUpdate">
      <FormUpdate
        v-if="selectedClinica"
        :clinica="selectedClinica"
        @clinicaActualizada="handleClinicaActualizada"
        @closeModal="closeModalUpdate"
      />
    </b-modal>

    <b-modal v-model="showDeleteModal" title="Eliminar Clínica" hide-footer @hide="closeModalDelete">
      <ClinicaDelete
        :showModal="true"
        :clinica="selectedClinica"
        @closeModal="closeModalDelete"
        @clinicaEliminada="eliminarClinica"
      />
    </b-modal>
  </div>
</template>

<script>
import axios from 'axios';
import FormUpdate from '@/components/clinicas/FormUpdate.vue';
import ClinicaDelete from '@/components/clinicas/ClinicaDelete.vue';
import { BModal } from 'bootstrap-vue-next';
import { useToast } from 'vue-toastification'; 
import 'vue-toastification/dist/index.css'; 

export default {
  name: 'ClinicasList',
  components: {
    FormUpdate,
    ClinicaDelete,
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
      showDeleteModal: false,
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
        await axios.delete(`http://localhost:8000/api/clinicas/${idClinica}`);
        this.localClinicas.data = this.localClinicas.data.filter(clinica => clinica.id !== idClinica);
        this.closeModalDelete();
      } catch (error) {
        console.error('Error al eliminar la clínica:', error);
      }
    },

    async handleClinicaActualizada(updatedClinica) {
      const index = this.localClinicas.data.findIndex(clinica => clinica.id === updatedClinica.id);
      if (index !== -1) {
        if (this.localClinicas.data[index].nombre !== updatedClinica.nombre ||
            this.localClinicas.data[index].correo_electronico !== updatedClinica.correo_electronico ||
            this.localClinicas.data[index].telefono !== updatedClinica.telefono) {
          this.localClinicas.data.splice(index, 1, updatedClinica);
          this.showSuccessToast('Clínica actualizada correctamente'); 
        }
      }
      this.closeModalUpdate();
    },

    showUpdateModalHandler(clinica) {
      this.selectedClinica = { ...clinica };
      this.showUpdateModal = true; 
    },

    showDeleteModalHandler(clinica) {
      this.selectedClinica = clinica;
      this.showDeleteModal = true;
    },

    closeModalUpdate() {
      this.selectedClinica = null;
      this.showUpdateModal = false;
    },

    closeModalDelete() {
      this.showDeleteModal = false;
    },

    goToPage(page) {
      if (page < 1 || page > this.localClinicas.last_page) return;
      this.fetchClinicas(page);
    },

    showSuccessToast(message) {
      const toast = useToast();
      toast.success(message, {
        position: 'top-right',
        timeout: 3000,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        hideProgressBar: false,
        showCloseButton: true,
      });
    },
  },

  mounted() {
    this.fetchClinicas();
  },
};
</script>

<style scoped>
.page-item.active button.page-link {
  background-color: var(--green);
  border-color: var(--green);
}
</style>
