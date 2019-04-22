<template>
  <div id="home">
    <HelloWorld />
    <v-btn to="/login">Login</v-btn>
    <v-btn to="/staff">Add/Edit staff</v-btn>
  </div>
</template>

<script>
import HelloWorld from '../components/HelloWorld'

export default {
  components: {
    HelloWorld
  }
}
</script>
