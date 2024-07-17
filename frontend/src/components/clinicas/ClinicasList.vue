<template>
  <div>
    <h2>Listado de Clínicas</h2>
    <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Correo Electrónico</th>
          <th>Teléfono</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="clinica in clinicas" :key="clinica.id">
          <td>{{ clinica.nombre }}</td>
          <td>{{ clinica.correo_electronico }}</td>
          <td>{{ clinica.telefono }}</td>
          <td>
            <button @click="selectClinica(clinica)" title="Actualizar">
              <i class="fa-regular fa-pen-to-square"></i>
            </button>
            <button @click="showDeleteModal(clinica)" title="Eliminar">
              <i class="fa-regular fa-trash-can"></i> 
            </button>
            <router-link
              :to="{ name: 'EmpleadosPorClinica', params: { id: clinica.id } }"
            >
              <i class="fa-regular fa-eye"></i> 
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal de confirmación de eliminación -->
    <b-modal v-model="showModal" title="Confirmar Eliminación" hide-footer>
      <p>
        ¿Estás seguro de eliminar la clínica <strong>"{{ selectedClinica?.nombre }}"</strong>?
      </p>
      <b-button variant="danger" @click="deleteClinica">Eliminar</b-button>
      <b-button variant="secondary" @click="closeModal">Cancelar</b-button>
    </b-modal>
  </div>
</template>

<script>
import axios from "axios";
import { BModal, BButton } from "bootstrap-vue-next";

export default {
  name: "ClinicasList",
  components: {
    BModal,
    BButton,
  },
  props: {
    clinicas: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      selectedClinica: null,
      showModal: false,
    };
  },
  methods: {
    selectClinica(clinica) {
      this.$emit("selectClinica", clinica);
    },
    showDeleteModal(clinica) {
      this.selectedClinica = clinica;
      this.showModal = true;
    },
    deleteClinica() {
      axios
        .delete(`http://127.0.0.1:8000/api/clinicas/${this.selectedClinica.id}`)
        .then(() => {
          this.$emit("clinicaEliminada", this.selectedClinica.id);
          this.closeModal();
        })
        .catch((error) => {
          console.error("Error deleting clinica:", error);
          this.closeModal();
        });
    },
    closeModal() {
      this.showModal = false;
    },
  },
};
</script>

<style scoped>
/* Estilos específicos para el componente ClinicasList.vue */
</style>
