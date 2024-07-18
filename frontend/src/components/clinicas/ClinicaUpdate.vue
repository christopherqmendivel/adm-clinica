  <template>
    <b-modal v-model="showModal" title="Actualizar Clínica" hide-footer>
      <ClinicaForm
        :clinica="clinica"
        @clinicaActualizada="handleClinicaActualizada"
        @closeModal="closeModal"
      />
    </b-modal>
  </template>
  

  <script>
  import { defineComponent } from 'vue'; // Importa defineComponent desde Vue 3
  import { BModal } from 'bootstrap-vue-next'; // Importa BModal de Bootstrap Vue
  import ClinicaForm from './ClinicaForm.vue'; // Componente que contiene el formulario

  export default defineComponent({
    name: "ClinicaUpdate",
    components: {
      BModal,
      ClinicaForm,
    },
    props: {
      clinica: Object // Propiedad que recibe la clínica a actualizar
    },
    data() {
      return {
        showModal: false // Estado local para controlar la visibilidad del modal
      };
    },
    methods: {
      handleClinicaActualizada(updatedClinica) {
        this.$emit("clinicaActualizada", updatedClinica); // Emite evento hacia ClinicasList.vue
        this.closeModal();
      },
      closeModal() {
        this.showModal = false; // Cierra el modal estableciendo showModal en false
        this.$emit('closeModal'); // Emite evento hacia ClinicasList.vue
      },
    },
  });
  </script>

  <style scoped>
  /* Estilos específicos para el componente */
  </style>
