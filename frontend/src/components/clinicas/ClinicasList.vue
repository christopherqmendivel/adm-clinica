<template>
  <div>
    <h2>Listado de Clínicas</h2>
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
            <!-- Btn actualizar -->
            <button type="button" @click="selectClinica(clinica)" title="Actualizar" class="btn button">
              <i class="fa-regular fa-pen-to-square btn-update text-success"></i>
            </button>

            <!-- Btn Eliminar -->
            <button type="button" @click="showDeleteModal(clinica)" title="Eliminar" class="btn button">
              <i class="fa-regular fa-trash-can text-danger"></i> 
            </button>

            <!-- Btn Ver Empleados de la Clinica -->
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

    <!-- Paginación -->
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: !localClinicas.prev_page_url }">
          <button class="page-link" @click="goToPage(localClinicas.current_page - 1)" :disabled="!localClinicas.prev_page_url">Anterior</button>
        </li>
        <li v-for="page in localClinicas.last_page" :key="page" class="page-item" :class="{ active: localClinicas.current_page === page }">
          <button class="page-link" @click="goToPage(page)">{{ page }}</button>
        </li>
        <li class="page-item" :class="{ disabled: !localClinicas.next_page_url }">
          <button class="page-link" @click="goToPage(localClinicas.current_page + 1)" :disabled="!localClinicas.next_page_url">Siguiente</button>
        </li>
      </ul>
    </nav>

    <!-- Modal de confirmación de eliminación -->
    <b-modal v-model="showModal" title="Confirmar Eliminación" hide-footer>
      <p>
        ¿Estás seguro de eliminar la clínica <strong>"{{ selectedClinica?.nombre }}"</strong>?
      </p>
      <div class="buttons d-flex gap-3">
        <b-button variant="danger" @click="deleteClinica">Eliminar</b-button>
        <b-button variant="secondary" @click="closeModal">Cancelar</b-button>
      </div>
    </b-modal>
  </div>
</template>

<script>
import axios from 'axios';
import { BModal, BButton } from 'bootstrap-vue-next';

export default {
  name: "ClinicasList",
  components: {
    BModal,
    BButton,
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
      showModal: false,
    };
  },
  methods: {
    async fetchClinicas(page = 1) {
      const url = `http://localhost:8000/api/clinicas?page=${page}`;
      try {
        const response = await axios.get(url);
        this.localClinicas = response.data;
      } catch (error) {
        console.error("Error al cargar las clínicas:", error);
      }
    },
    goToPage(pageOrUrl) {
      if (typeof pageOrUrl === 'string') {
        this.fetchClinicasFromUrl(pageOrUrl);
      } else {
        this.fetchClinicas(pageOrUrl);
      }
    },
    async fetchClinicasFromUrl(url) {
      try {
        const response = await axios.get(url);
        this.localClinicas = response.data;
      } catch (error) {
        console.error("Error al cargar las clínicas:", error);
      }
    },
    selectClinica(clinica) {
      this.$emit("selectClinica", clinica);
    },
    showDeleteModal(clinica) {
      this.selectedClinica = clinica;
      this.showModal = true;
    },
    async deleteClinica() {
      try {
        await axios.delete(`http://localhost:8000/api/clinicas/${this.selectedClinica.id}`);
        this.$emit("clinicaEliminada", this.selectedClinica.id);
        this.fetchClinicas(this.localClinicas.current_page);
        this.closeModal();
      } catch (error) {
        console.error("Error deleting clinica:", error);
        this.closeModal();
      }
    },
    closeModal() {
      this.showModal = false;
    },
  },
  mounted() {
    this.fetchClinicas();
  },
};
</script>

<style scoped>
.buttons-crud .button {
  font-size: 1.1rem;
}

.page-item.active .page-link {
  background-color: var(--green); 
  border-color: var(--green); 
  color: var(--white);

}
</style>
