<template>
  <div class="text-xs-center">
    <v-menu v-model="menu" :close-on-content-click="false" offset-y>
      <template v-slot:activator="{ on }">
        <v-btn block v-on="on">Add new machine model</v-btn>
      </template>

      <v-card>
        <v-list-tile-action>
          <v-form ref="AddMachineModelForm" v-model="valid" lazy-validation>
            <v-layout justify-center>
              <v-flex xs9>
                <v-text-field
                  v-model="modelNumber"
                  :rules="modelNumberRules"
                  type="text"
                  label="Model Number"
                  required
                ></v-text-field>
                <v-select
                  v-model="type"
                  :rules="typeRules"
                  :items="typeList"
                  label="Machine type"
                  required
                ></v-select>
              </v-flex>
            </v-layout>
          </v-form>
        </v-list-tile-action>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn flat @click="menu = false">Cancel</v-btn>
          <v-btn color="primary" flat @click="validate">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-menu>
  </div>
</template>

<script>
export default {
  data: () => ({
    menu: false,
    valid: true,

    modelNumber: null,
    modelNumberRules: [v => !!v || "This field cannot be blank"],

    type: null,
    typeList: ["Pump", "Boiler", "Other"],
    typeRules: [v => !!v || "This field cannot be blank"]
  }),

  methods: {
    validate() {
      if (this.$refs.AddMachineModelForm.validate()) {
        this.menu = false;
        //save to database
      }
    }
  }
};
</script>
