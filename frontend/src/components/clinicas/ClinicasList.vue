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
        <tr v-for="clinica in clinicas" :key="clinica.id">
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
import axios from "axios";
import { BModal, BButton } from 'bootstrap-vue-next'; 

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
  .buttons-crud .button {
      font-size: 1.1rem;
  }
</style>
