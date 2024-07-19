<template>
  <div>
    <h1 class="mb-3">Listado de empleados en general</h1>

    <table v-if="paginatedEmpleados.length > 0" class="table table-dark table-hover table-striped">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>DNI</th>
          <th>Correo Electrónico</th>
          <th>Teléfono</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="empleado in paginatedEmpleados" :key="empleado.id">
          <td>{{ empleado.nombre }}</td>
          <td>{{ empleado.apellido }}</td>
          <td>{{ empleado.dni }}</td>
          <td>{{ empleado.correo_electronico }}</td>
          <td>{{ empleado.telefono }}</td>
        </tr>
      </tbody>
    </table>
    <p v-else class="text-center">No hay empleados registrados.</p>

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
    <nav aria-label="Page navigation example" class="mt-4">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: empleados.current_page === 1 }">
          <button
            class="page-link"
            @click="prevPage"
            :disabled="empleados.current_page === 1"
          >
            Anterior
          </button>
        </li>

        <!-- Mostrar números de página -->
        <li
          v-for="page in pagesToShow"
          :key="page"
          class="page-item"
          :class="{ active: empleados.current_page === page }"
        >
          <button class="page-link" @click="goToPage(page)">{{ page }}</button>
        </li>

        <li class="page-item" :class="{ disabled: empleados.current_page === empleados.last_page }">
          <button
            class="page-link"
            @click="nextPage"
            :disabled="empleados.current_page === empleados.last_page"
          >
            Siguiente
          </button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AppEmpleados',
  data() {
    return {
      empleados: { data: [], current_page: 1, last_page: 1 },
      perPage: 10,
      mostrarModalCrearEmpleado: false,
      clinica: null // Si tienes información de la clínica, inclúyela aquí
    };
  },
  computed: {
    paginatedEmpleados() {
      return this.empleados.data;
    },
    pagesToShow() {
      const totalPages = this.empleados.last_page;
      const currentPage = this.empleados.current_page;
      let startPage = Math.max(currentPage - 5, 1);
      let endPage = Math.min(startPage + 9, totalPages);

      // Ajusta el rango de páginas para mostrar siempre 10 páginas si hay suficiente espacio
      if (endPage - startPage < 9) {
        startPage = Math.max(endPage - 9, 1);
      }

      return Array.from({ length: endPage - startPage + 1 }, (_, i) => startPage + i);
    }
  },
  created() {
    this.fetchEmpleados();
  },
  methods: {
    fetchEmpleados(page = 1) {
      axios.get('http://127.0.0.1:8000/api/empleados', {
        params: {
          page: page,
          per_page: this.perPage
        }
      })
      .then(response => {
        this.empleados = response.data;
      })
      .catch(error => {
        console.error('Error fetching empleados:', error);
      });
    },
    nextPage() {
      if (this.empleados.current_page < this.empleados.last_page) {
        this.fetchEmpleados(this.empleados.current_page + 1);
      }
    },
    prevPage() {
      if (this.empleados.current_page > 1) {
        this.fetchEmpleados(this.empleados.current_page - 1);
      }
    },
    goToPage(page) {
      if (page >= 1 && page <= this.empleados.last_page) {
        this.fetchEmpleados(page);
      }
    },
    mostrarFormularioCrearEmpleado() {
      this.mostrarModalCrearEmpleado = true;
    },
    cerrarFormularioCrearEmpleado() {
      this.mostrarModalCrearEmpleado = false;
    },
    empleadoCreado() {
      this.fetchEmpleados(this.empleados.current_page); // Actualiza la página actual después de agregar un empleado
      this.cerrarFormularioCrearEmpleado();
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
