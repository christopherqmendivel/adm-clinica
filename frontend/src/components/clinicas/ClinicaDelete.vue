<template>
  <b-modal :visible="showModal" @hide="closeModal" :title="modalTitle" hide-footer>
    <div class="modal-body">
      <span class="close" @click="closeModal">&times;</span>
      <template v-if="clinica">
        <p>¿Estás seguro de que quieres eliminar la clínica <strong>"{{ clinica.nombre }}"</strong>?</p>
        <button @click="eliminarClinica" class="btn btn-danger">Eliminar</button>
        <button @click="closeModal" class="btn btn-secondary">Cancelar</button>
      </template>
    </div>
  </b-modal>
</template>

<script>
export default {
  props: {
    showModal: Boolean,
    clinica: Object,
  },
  computed: {
    modalTitle() {
      if (this.clinica && this.clinica.nombre) {
        return `Eliminar Clínica: ${this.clinica.nombre}`;
      }
      return 'Eliminar Clínica';
    },
  },
  data() {
    return {
      // Define una propiedad local para manejar la visibilidad del modal
      showModalLocal: false,
    };
  },
  watch: {
    // Observar cambios en la prop showModal para sincronizar con la propiedad local
    showModal(newVal) {
      this.showModalLocal = newVal;
    },
  },
  methods: {
    closeModal() {
      this.$emit('closeModal');
    },
    eliminarClinica() {
      const idClinica = this.clinica.id;
      // Emitir evento para indicar que se va a eliminar la clínica
      this.$emit('clinicaEliminada', idClinica);
      // Cerrar el modal localmente
      this.closeModal();
    },
  },
};
</script>

<style scoped>
.modal-body {
  padding: 20px;
}

.close {
  position: absolute;
  top: 15px;
  right: 20px;
  font-size: 1.5rem;
  cursor: pointer;
  display: none;
}

.btn {
  margin-right: 10px;
}
</style>
