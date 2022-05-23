<template>
    <div>
        <v-app-bar color="primary" flat dark >
            <!--icono para el menu lateral en md y sm-->
            <v-app-bar-nav-icon active-class="no-active" class="hidden-lg-and-up"></v-app-bar-nav-icon>

            <!--Nombre de la tienda-->
            <v-toolbar-title class="white--text hidden-md-and-down">Lista de tareas</v-toolbar-title>

            <v-spacer class="hidden-md-and-down"></v-spacer>


            <!--botones de cuenta y carrito-->
            <v-spacer class="hidden-md-and-down"></v-spacer>

            <v-btn text active-class="no-active" class="hidden-md-and-down" to="/inicio">
                <v-icon left>mdi-calendar-check</v-icon>
                Mis tareas
            </v-btn>

            <v-btn text active-class="no-active" class="hidden-md-and-down" v-if="usuario.rol === 'Admin'" to="/admin">
                <v-icon left>mdi-shield-account</v-icon>
                Administrar
            </v-btn>
            <v-btn text active-class="no-active" class="hidden-md-and-down" @click="cerrar">
                <v-icon left>mdi-close-circle</v-icon>
                Cerrar Sesion
            </v-btn>
        </v-app-bar>
        
    </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";
import { api } from '../api'
export default {
    name: "Barra",
    components: {},
    data(){
        return{
        }
    },
    computed: {
        ...mapState(['usuario'])
    },
    methods: {
        async cerrar(){
            // const res = await api.post('/logout')
            // if(res.data.message == 'Sesion cerrada'){
                this.$router.push('/')
            // }
        }
    }
};
</script>