<template>
  <v-menu
    v-model="timePickerMenu"
    :close-on-content-click="false"
    :nudge-right="40"
    lazy
    transition="scale-transition"
    offset-y
    full-width
    max-width="290px"
    min-width="290px"
  >
    <template v-slot:activator="{ on }">
      <v-text-field
        v-model="time"
        :label="label"
        hint="HH:MM format"
        persistent-hint
        readonly
        v-on="on"
      ></v-text-field>
    </template>
    <v-time-picker v-model="time" format="24hr" full-width @change="emitTime"></v-time-picker>
  </v-menu>
</template>

<script>
export default {
  data: () => ({
    timePickerMenu: false,
    time: "00:00"
  }),
  props: {
    label: String,
    setTime: String
  },

  methods: {
    emitTime() {
      this.$emit("input", this.time);
      this.timePickerMenu = false;
    }
  },

  watch: {
    setTime: function(val, oldVal) {
      this.time = val;
    }
  }
};
</script>
