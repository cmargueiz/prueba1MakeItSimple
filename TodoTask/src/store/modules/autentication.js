import { api } from "../../api";
import route from "../../router/index";

export default {
  namespaced: true,
  state: {
    user: null,
    isLogged: false,
    registerFail: null,
  },
  mutations: {
    //guardar el usuario que se ha autenticado en el state
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
    async register({ rootState, state }, form) {
      try {
        await api.get("/sanctum/csrf-cookie");
        var res = await api.post("/register", form);
        rootState.snackbarResponse.showSnackbarResponse = true;
        rootState.snackbarResponse.msgSnackbarResponse = res.data;
        rootState.snackbarResponse.iconSnackbarResponse.icon = "mdi-alert";
        rootState.snackbarResponse.iconSnackbarResponse.color = "amber--text";
        route.push("/");
        //commit("SET_USER", res.data.user);
      } catch (error) {
        console.error(error);
        state.registerFail = error.response.data.message;
      }
    },
    async verifyEmail({ rootState, ctx }, payload) {
      try {
        var res = await api.get("/email-verification", { params: payload });
        rootState.snackbarResponse.showSnackbarResponse = true;
        rootState.snackbarResponse.msgSnackbarResponse = res.data.message;
        rootState.snackbarResponse.iconSnackbarResponse.icon =
          "mdi-check-circle";
        rootState.snackbarResponse.iconSnackbarResponse.color =
          "green--text  text--accent-4";
      } catch (error) {
        console.log(error);
        rootState.snackbarResponse.msgSnackbarResponse =
          error.response.data.message;
        rootState.snackbarResponse.showSnackbarResponse = true;
        rootState.snackbarResponse.iconSnackbarResponse.icon = "mdi-alert";
        rootState.snackbarResponse.iconSnackbarResponse.color = "amber--text";
      } finally {
        route.push("/");
      }
    },
  },
  getters: {
    getUser(state) {
      return state.user;
    },
  },

  modules: {},
};
