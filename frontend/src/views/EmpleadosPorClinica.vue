<template>
  <div>
    <h1 v-if="clinica">Clínica: {{ clinica.nombre }}</h1>
    <button @click="mostrarFormularioCrearEmpleado" class="btn btn-create mb-3">
      Crear Empleado
    </button>
    <table
      v-if="empleados.data.length > 0"
      class="table table-dark table-hover table-striped"
    >
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Correo Electrónico</th>
          <th>Teléfono</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="empleado in empleados.data" :key="empleado.id">
          <td>{{ empleado.nombre }}</td>
          <td>{{ empleado.apellido }}</td>
          <td>{{ empleado.correo_electronico }}</td>
          <td>{{ empleado.telefono }}</td>
        </tr>
      </tbody>
    </table>
    <p v-else>No hay empleados registrados.</p>

    <!-- Formulario modal para crear un nuevo empleado -->
    <b-modal
      v-model="mostrarModalCrearEmpleado"
      title="Crear Nuevo Empleado"
      hide-footer
    >
      <FormCreateEmployee
        :clinicaId="id"
        @closeModal="cerrarFormularioCrearEmpleado"
        @empleadoCreado="empleadoCreado"
      />
    </b-modal>

    <!-- Navegación de paginación -->
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: !empleados.prev_page_url }">
          <button
            class="page-link"
            @click="goToPage(empleados.current_page - 1)"
            :disabled="!empleados.prev_page_url"
          >
            Anterior
          </button>
        </li>
        <li
          v-for="page in pagesArray"
          :key="page"
          class="page-item"
          :class="{ active: empleados.current_page === page }"
        >
          <button class="page-link" @click="goToPage(page)">{{ page }}</button>
        </li>
        <li class="page-item" :class="{ disabled: !empleados.next_page_url }">
          <button
            class="page-link"
            @click="goToPage(empleados.current_page + 1)"
            :disabled="!empleados.next_page_url"
          >
            Siguiente
          </button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
import axios from "axios";
import FormCreateEmployee from "@/components/empleados/FormCreateEmployee.vue";
import { BModal } from "bootstrap-vue-next";

export default {
  name: "EmpleadosPorClinica",
  components: {
    FormCreateEmployee,
    BModal,
  },
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      clinica: null,
      empleados: {
        data: [],
        current_page: 1,
        last_page: 1,
        next_page_url: null,
        prev_page_url: null,
      },
      mostrarModalCrearEmpleado: false,
    };
  },
  created() {
    this.fetchClinica();
  },
  methods: {
    fetchClinica() {
      axios
        .get(`http://127.0.0.1:8000/api/clinicas/${this.id}`)
        .then((response) => {
          this.clinica = response.data;
          this.fetchEmpleados();
        })
        .catch((error) => {
          console.error("Error fetching clinica:", error);
        });
    },
    fetchEmpleados(page = 1) {
      axios
        .get(
          `http://127.0.0.1:8000/api/clinicas/${this.id}/empleados?page=${page}`
        )
        .then((response) => {
          this.empleados = response.data;
        })
        .catch((error) => {
          console.error("Error fetching empleados:", error);
        });
    },
    mostrarFormularioCrearEmpleado() {
      this.mostrarModalCrearEmpleado = true;
    },
    cerrarFormularioCrearEmpleado() {
      this.mostrarModalCrearEmpleado = false;
    },
    empleadoCreado(nuevoEmpleado) {
      this.empleados.data.push(nuevoEmpleado);
      this.cerrarFormularioCrearEmpleado();
    },
    goToPage(page) {
      if (page >= 1 && page <= this.empleados.last_page) {
        this.fetchEmpleados(page);
      }
    },
  },
  computed: {
    pagesArray() {
      const pages = [];
      for (let i = 1; i <= this.empleados.last_page; i++) {
        pages.push(i);
      }
      return pages;
    }
  }
};
</script>

<style scoped>
.btn-create {
  background-color: var(--green);
  color: white;
  transition: 0.5s ease-in-out;
}

.btn-create:hover {
  background-color: var(--greenHover);
  color: white;
}

.pagination .page-item.active .page-link {
  background-color: var(--green);
  border-color: var(--green);
}
</style>
