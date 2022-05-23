<template>
  <v-card outlined>
    <v-list-item three-line>
      <v-list-item-content>
        
        <v-list-item-title class="text-h5 mb-1"> <b>Titulo:</b> {{ tarea.title }}</v-list-item-title>
        <v-list-item-subtitle><b>Descripcion:</b> {{ tarea.description }}</v-list-item-subtitle>
        <v-list-item-subtitle>
          <br>
          <center><b>Nivel de Prioridad:</b> {{nivelPrioridad}}</center>
        <v-progress-linear
        rounded
        background-color="success"
        color="error"
        :value="tarea.priority*(100/3)"
    ></v-progress-linear>
        </v-list-item-subtitle>
        
      </v-list-item-content>
    </v-list-item>

    <v-card-actions v-if="mostrar">
      <v-btn rounded color="warning" @click="$emit('modificar' , tarea)"> Editar{{tarea.idTarea}} </v-btn>
      <v-btn rounded color="error" @click="$emit('eliminar' , tarea)"> Eliminar </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { api } from '@/api';
export default {
  name: "Tarea",
  data() {
    return {
      valorPrioridad : 0,
      nivelPrioridad: ''
    };

  },
  props: ["tarea","idTarea", "mostrar"],
  methods:{
    obtenerPrioridad(){
      const valor = Number(this.tarea.priority);
      const porcentaje =   100/3;
      this.valorPrioridad = valor*porcentaje
      if (this.tarea.priority==1) {
        this.nivelPrioridad = 'Bajo'
      }else if (this.tarea.priority==2) {
        this.nivelPrioridad = 'Medio'
      }else{
        this.nivelPrioridad = 'Alto'
        console.log(valor)
      }

    }
  },
  mounted(){
    this.obtenerPrioridad();
  }
};
</script>
