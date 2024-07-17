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

    <!-- Componente de eliminación de clínica -->
    <ClinicaDelete v-if="selectedClinica" :clinica="selectedClinica" @clinicaEliminada="handleClinicaEliminada" @closeModal="closeModal" />
  </div>
</template>

<script>
import axios from 'axios';
import ClinicaDelete from './ClinicaDelete.vue';

export default {
  name: "ClinicasList",
  components: {
    ClinicaDelete,
  },
  props: {
    clinicas: Array
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
  watch: {
    clinicas: {
      handler(newClinicas) {
        this.localClinicas.data = newClinicas.data || [];
        this.localClinicas.current_page = newClinicas.current_page || 1;
        this.localClinicas.last_page = newClinicas.last_page || 1;
        this.localClinicas.next_page_url = newClinicas.next_page_url || null;
        this.localClinicas.prev_page_url = newClinicas.prev_page_url || null;
      },
      immediate: true
    }
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
    handleClinicaEliminada() {
      this.$emit("clinicaEliminada");
      this.closeModal();
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
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
</style>
