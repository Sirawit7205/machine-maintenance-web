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
                  v-model="machineType"
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
import axios from "axios";

export default {
  data: () => ({
    menu: false,
    valid: true,

    actionType: 0,

    modelCode: null,
    modelNumber: null,
    modelNumberRules: [v => !!v || "This field cannot be blank"],

    machineType: null,
    typeList: ["Pump", "Boiler", "Other"],
    typeRules: [v => !!v || "This field cannot be blank"]
  }),

  methods: {
    validate() {
      if (this.$refs.AddMachineModelForm.validate()) {
        this.commitChanges().then(response => {
          if(response == 1) {
            this.$emit("input", this.modelCode);
            this.menu = false;
          }

        });
      }
    },

    async refreshData() {
      let count = await axios
        .get("//localhost:80/MachineMaintenance/public/api/machineModel/count", {})
        .then(response => {
          this.modelCode = "MD" + response.data;
        });
    },

    commitChanges() {
      return axios.post(
        "//localhost:80/MachineMaintenance/public/api/machineModel/submit",
        {
          actionType: this.actionType,
          modelCode: this.modelCode,
          modelNumber: this.modelNumber,
          machineType: this.machineType
        })
        .then(response => response.data)
        .catch(error => console.log(error));
    },
  },

  created: async function() {
    this.refreshData();
  }
};
</script>
