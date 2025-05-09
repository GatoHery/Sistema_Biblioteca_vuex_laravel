<template>
  <div class="about">
    <h1>This is an about page</h1>
    <div class="card-container" v-if="items && items.length > 0">
      <div class="card" v-for="item in items" :key="item.nombre">
        <h2>{{ item.nombre }}</h2>
        <p>Cantidad: {{ item.cantidad }}</p>
        <p>Especialidad: {{ item.especialidad }}</p>
        <p>Bibliografía: {{ item.bibliografia }}</p>
        <p>Categoría: {{ item.FK_categoria }}</p>
        <p>Proveedor: {{ item.FK_proveedor }}</p>
        <p>Autor: {{ item.FK_autor }}</p>
      </div>
    </div>
    <p v-else>Cargando datos...</p>
  </div>
</template>

<script>
import axios from "axios";
import { ref, onMounted } from "vue";
export default {
  setup() {
    const ruta = "http://127.0.0.1:8000";
    const items = ref([]);

    const fetchItems = async () => {
      console.log("Fetching items..."); // Log when the function is called
      try {
        const response = await axios.get(`${ruta}/api/libro`);
        console.log("Full API Response:", response); // Log the full API response for debugging
        console.log("Response Data:", response.data); // Log the `data` property of the response

        if (Array.isArray(response.data)) {
          items.value = response.data; // Assign items if the response structure is correct
          console.log("Items loaded:", items.value); // Log the loaded items
        } else if (response.data && Array.isArray(response.data.data)) {
          items.value = response.data.data; // Handle nested `data` property
          console.warn("Fallback: Using response.data.data as items.");
        } else {
          console.error("Unexpected API response structure:", response.data);
          alert(
            "Error: La estructura de la respuesta de la API no es la esperada. Verifique el formato de la respuesta."
          );
        }
      } catch (error) {
        console.error("Error fetching items:", error); // Log the error
        if (error.response) {
          console.error("API Error Response:", error.response); // Log API error response
          if (error.response.status === 404) {
            alert(
              "Error: 404 - No se encontró el recurso. Verifique que la ruta de la API sea correcta: " +
                `${ruta}/api/libro`
            );
          } else {
            alert(
              `Error: ${error.response.status} - ${error.response.statusText}. Verifique el enlace de la API.`
            );
          }
        } else {
          alert(
            "Error: No se pudieron cargar los datos. Verifique la conexión al servidor."
          );
        }
      }
    };

    const createLibro = async () => {
      try {
        const newLibro = {
          nombre: "Libro de ejemplo",
          cantidad: 10,
          // ...other fields...
        };
        const response = await axios.post(`${ruta}/api/libro`, newLibro);
        console.log("Libro created:", response.data);
      } catch (error) {
        console.error("Error creating libro:", error);
      }
    };

    onMounted(() => {
      console.log("Component mounted. Fetching items..."); // Log when the component is mounted
      fetchItems();
    });

    return {
      items,
    };
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
