<template>
  <v-menu
    v-model="datePickerMenu"
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
        v-model="date"
        :label="label"
        hint="YYYY-MM-DD format"
        persistent-hint
        readonly
        v-on="on"
      ></v-text-field>
    </template>
    <v-date-picker v-model="date" no-title @input="emitDate"></v-date-picker>
  </v-menu>
</template>

<script>
export default {
  data: () => ({
    datePickerMenu: false,
    date: new Date().toISOString().substr(0, 10)
  }),

  props: {
    label: String
  },

  methods: {
    emitDate() {
      this.$emit("input", this.date);
      this.datePickerMenu = false;
    }
  }
};
</script>
