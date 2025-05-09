<template>
  <table>
    <thead>
      <tr>
        <th>Nombre</th>
        <th>cantidad</th>
        <th>especialidad</th>
        <th>bibliografia</th>
        <th>categoria</th>
        <th>Proveedor</th>
        <th>Autor</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(libro, i) in libros" :key="i">
        <th>{{ libro.nombre }}</th>
        <th>{{ libro.cantidad }}</th>
        <th>{{ libro.especialidad }}</th>
        <th>{{ libro.bibliografia }}</th>
        <th>{{ libro.FK_categoria }}</th>
        <th>{{ libro.FK_proveedor }}</th>
        <th>{{ libro.FK_autor }}</th>
        <th></th>
      </tr>
    </tbody>
  </table>
</template>

<script>
import axios from "axios";
const ruta = "http://127.0.0.1:8000";
export default {
  name: "AboutView",
  data() {
    return {
      libro: {}, // para almacenar la categoría a registrar
      libros: [], // para almacenar las categorías obtenidas del endpoint
      datos: {}, // para almacenar los datos de la categoría seleccionada
      dialogOne: false, // controlar el modal de vista
      dialogTwo: false, // controlar el modal de edición
      config: {
        headers: { Authorization: "Bearer " + this.$store.getters.getToken },
      },
    };
  },
  methods: {
    // Mostrar alerta
    getAlert(message) {
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: message,
        showConfirmButton: false,
        timer: 1500,
      });
    },
    // Petición para agregar categoría
    agregarLibro() {
      axios
        .post(ruta + "/api/libro", this.libro, this.config)
        .then((response) => {
          if (response.data.code === 200) {
            this.getAlert(response.data.data);
            this.libro = {};
            this.obtenerlibros(); // Recargar tabla
          }
        })
        .catch((error) => console.log("Ha ocurrido un error: " + error));
    },
    obtenerlibros() {
      console.log("obteniendo libros", this.libros);
      this.libros = [];
      axios
        .get(ruta + "/api/libro", this.config)
        .then((response) => {
          if (response.data.code === 200) {
            let res = response.data;
            this.libros = res.data;
          }
        })
        .catch((error) => console.log("Ha ocurrido un error: " + error));
    },
  },
};
</script>

<style>
.about {
  padding: 20px;
}
.card-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}
.card {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 16px;
  width: 200px;
  text-align: center;
}
</style>
