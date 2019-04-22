<template>
  <v-app>
    <v-toolbar app>
      <img src="./assets/pelogo.png" alt="Logo" width="auto" height="90%" top="50%" bottom="50%"/>
      <v-toolbar-title class="headline">
        <span>Machine Maintenance Database v1.0</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn flat to="/">
        <span>Back to homepage</span>
      </v-btn>
    </v-toolbar>

    <v-content>
      <router-view />
    </v-content>

  </v-app>
</template>

<script>
import HelloWorld from './components/HelloWorld'

export default {
  name: 'App',
  components: {
    HelloWorld
  },
  data () {
    return {
    }
  }
}
</script>
