<template>
  <v-app>
    <Barra v-if="usuario.logueado"></Barra>
    <br><br><br>
    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
import { mapState } from "vuex";
import Barra from "./components/Barra.vue"

export default {
  name: 'App',

  data() {
    return {
    }
  },
  computed: {
    ...mapState(['usuario'])
  },
  components: {
    Barra
  },
  mounted() {
    if(!this.usuario.logueado){
      this.$router.push('/');
    }
  }
};
</script>
