<template>
  <div>
    <v-main>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Registro form</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field
                    prepend-icon="mdi-account"
                    label="Name"
                    type="text"
                    v-model="form.name"
                  ></v-text-field>
                  <v-text-field
                    prepend-icon="mdi-account"
                    label="email"
                    type="text"
                    v-model="form.email"
                  ></v-text-field>
                  <v-text-field
                    prepend-icon="mdi-lock"
                    label="Password"
                    type="password"
                    v-model="form.password"
                  >
                  </v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="register">Crear usuario</v-btn>
                <v-btn color="red" @click="cancelar">Cancelar</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-main>
    <v-snackbar v-model="snackbar">
      {{ text }}

      <template v-slot:action="{ attrs }">
        <v-btn color="pink" text v-bind="attrs" >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
import {api} from "../api"
//import HelloWorld from '../components/HelloWorld'
import { mapMutations, mapActions } from "vuex";
import axios from 'axios';

export default {
  name: "Login",
  data() {
    return {
      form: {
        name:'',
        email: "",
        password: "",
      },
      snackbar: false,
      snackbarText: "",
      text: "",
      crear:"",
    };
  },
  methods: {
    ...mapMutations,
    async register() {
        // console.log(response)
      // await api.get("/sanctum/csrf-cookie");
        await api.post("register",this.form).then((res) => {
        console.log('Usuario logueado')
        // this.$router.push('inicio')
        }).catch(res=>{
          console.log(res)
        });
      
        const user= await api.get('/user')
        console.log(user.data)
        this.$store.commit('SET_USER',user.data)
        // console.log(this.$store.state.user.id)
      if(user){
        this.$router.push('/inicio')
      }
    },
    cancelar(){
      this.$router.push('/')
    }
  },
};
</script>
