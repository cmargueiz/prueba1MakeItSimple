<template>
  <v-card outlined>
    <v-list-item three-line>
      <v-list-item-content>
        <v-list-item-title class="text-h5 mb-1">{{ usuario.idUsuario }}</v-list-item-title>
        <v-list-item-subtitle>{{ usuario.rol }}</v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>
    <v-card-actions>
      <v-btn rounded color="primary" @click="$emit('seleccionado' , usuario.idUsuario)">Seleccionar</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  name: "Tarea",
  data() {
    return {};
  },
  props: ["usuario"],
};
</script>
