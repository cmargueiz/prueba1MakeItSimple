<template>
  <div>
      <barra/>
    <v-container>
      <v-row>
        <!-- inputs -->
        <v-col cols="3">
          <v-text-field v-model="task.title" label="Titulo" outlined></v-text-field>
          <v-textarea
            v-model="task.description"
            label="Descripcion"
            outlined
          ></v-textarea>
                    <v-select
            :items="items"
            label="Prioridad"
            v-model="prioridad"
            outlined
            @change="cambiarPrioridad"
          ></v-select>
          <v-btn color="primary" @click="agregar()"> {{ boton }} </v-btn>
        </v-col>

        <!--tareas-->
        <v-col cols="9">
          <div v-for="(tarea, index) in tareas" :key="index">
            
            <Tarea
              :tarea="tarea"
              :idTarea="index"
              :mostrar="true"
              @eliminar="eliminarTarea"
              @modificar="tareaModificar"
            ></Tarea>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import Barra from '@/components/Barra.vue';
import Tarea from "../components/Tarea.vue";
import { api } from '@/api';


export default {
  name: "Inicio",
  data() {
    return {
      task:{
        title:'',
        description:'',
        priority:0,
        user_id:0
      },
      prioridad:'',
      items: ["Alta", "Media", "Baja"],
      boton: "Anadir tarea",
      tareaSeleccionada: "",
      tareas: [],
    };
  },
  components: {
    Tarea,
    Barra,
  },
  methods: {
    agregar() {
      //validar que no se agreguen tarea vacias
      if (
        this.task.title === "" ||
        this.task.title === ""
      ){
        return;
      }

      if (this.boton !== "Modificar") {
        this.guardarTarea();
      } else {
        this.modificarTarea();
      }

      this.task.title='';
      this.task.description='';

    },
    tareaModificar(idTarea) {
      this.task = idTarea
      this.boton = 'Modificar'
    },
    cambiarPrioridad(){
      
            if (this.prioridad=="Baja") {
        this.task.priority = 1;
      }else if (this.prioridad=="Media") {
        this.task.priority = 2;
      }else{
        this.task.priority = 3;
      }
      console.log(this.task)

    }
    ,
    async guardarTarea(){
      const user_id = this.$store.state.user.id
      this.task.user_id= user_id;

      await api.post('task',this.task).then(res=>{
        console.log("Tarea agregada")
        this.consultartareas();
       
      })
    }
    ,
    async consultartareas(){
       const user_id = this.$store.state.user.id
    await api.get(`task/${user_id}`).then(res=>{
      // console.log(res.data)
      this.tareas = res.data
    })
    },
    async modificarTarea(){
      const idTarea = this.task.id
      const res = await api.put(`/task/${idTarea}`,this.task)
      if(res.data.message == 'Tarea Modificada'){
        console.log(res.data.message);
        this.boton = 'Anadir tarea'
      }
        this.consultartareas();


    } ,
    async eliminarTarea(task){
      const idTarea = task.id
      // await api.get("/sanctum/csrf-cookie");
      const result = await api.delete(`/task/${idTarea}`)
      if(result.data.message=='Tarea Eliminada'){
        this.consultartareas();
      }
    }
  },
  computed: {},
    mounted() {
      this.consultartareas();
  },
};
</script>
