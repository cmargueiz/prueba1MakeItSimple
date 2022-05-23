import Vue from 'vue'
import Vuex from 'vuex'

import autentication from "./modules/autentication.js"
Vue.use(Vuex)

export default new Vuex.Store({
  namespaced: true,
  state: {
    usuario: {
      user: {},
      isLogged: false,
      registerFail: null,
    },
    user:{}
  },
  getters: {
  },
  mutations: {
    SET_USER(state, user) {
      state.user = user;
      state.isLogged = Boolean(user); //true si hay usuario, false si no hay
    },
  },
  actions: {
    async getCurrentUser({ commit }, user) {
      try {
        await api.get("/sanctum/csrf-cookie");
        var user = await api.get("/user");
        commit("SET_USER", user.data);
      } catch (e) {
        commit("SET_USER", null);
      }
    },
    //action para hacer login, despues de hacer login guarda el usuario actual en el state usando una mutacion
    async login({ commit }, credentials) {
      //para ejecutar una accion dentro de una accion se usa dispatch on destructuracionb
      await api.get("/sanctum/csrf-cookie");
      var user = {};
      user = await api.post("/login", credentials);
      commit("SET_USER", user.data.user);
    },
    //action para cerrar sesion  y limpiar el objeto del usuario actual
    async logout({ commit }) {
      //para ejecutar una accion dentro de una accion se usa dispatch on destructuracion
      try {
        await api.get("/sanctum/csrf-cookie");
        await api.post("/logout");
        commit("SET_USER", null);
        if (route.currentRoute.meta.requiresAuth) {
          route.push("/");
        }
      } catch (error) {
        console.error(error);
      }
    },
    //action para registrar nuevo usuario


  },
  modules: {
  }
})
