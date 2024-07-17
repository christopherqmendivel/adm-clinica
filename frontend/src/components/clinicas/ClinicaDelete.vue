<template>
  <b-modal v-model="showModal" title="Confirmar Eliminación" hide-footer>
    <p>
      ¿Estás seguro de eliminar la clínica <strong>"{{ clinica.nombre }}"</strong>?
    </p>
    <div class="buttons d-flex gap-3">
      <b-button variant="danger" @click="deleteClinica">Eliminar</b-button>
      <b-button variant="secondary" @click="closeModal">Cancelar</b-button>
    </div>
  </b-modal>
</template>

<script>
import axios from 'axios';
import { BModal, BButton } from 'bootstrap-vue-next';

export default {
  name: "ClinicaDelete",
  components: {
    BModal,
    BButton,
  },
  props: {
    clinica: Object
  },
  data() {
    return {
      showModal: true
    };
  },
  methods: {
    async deleteClinica() {
      try {
        await axios.delete(`http://localhost:8000/api/clinicas/${this.clinica.id}`);
        this.$emit("clinicaEliminada");
        this.closeModal();
      } catch (error) {
        console.error("Error eliminando clínica:", error);
      }
    },
    closeModal() {
      this.showModal = false;
      this.$emit('closeModal');
    },
  },
};
</script>

<style scoped>
.buttons .b-button {
  margin-right: 10px;
}
</style>
