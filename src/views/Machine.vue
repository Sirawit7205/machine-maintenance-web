<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg3 sm9>
        <div class="headline mb-1">Add or edit machine</div>
        <v-card>
          <v-card-text>
            <v-form ref="MachineSrcAdd" v-model="valid" lazy-validation>
              Search for existing machine:
              <v-autocomplete v-model="machineId" :items="existingMachine" placeholder="Search..."></v-autocomplete>
              <p class="text-xs-center">----- OR -----</p>Add new machine:
              <br>
              <v-btn block @click="generateNewId">Add Machine</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg9 sm9>
        <div class="headline mb-1">Machine Info</div>
        <v-card>
          <v-card-text>
            <v-form ref="MachineForm" v-model="valid" lazy-validation>
              <v-layout row>
                <v-flex xs8>
                  <v-text-field
                    v-model="machineId"
                    :rules="machineIdRules"
                    type="text"
                    label="Machine ID"
                    disabled
                  ></v-text-field>
                  <v-autocomplete
                    v-model="modelNumber"
                    :rules="modelNumberRules"
                    :items="existingModel"
                    label="Model Number"
                    placeholder="Search..."
                  ></v-autocomplete>
                  <v-text-field
                    v-model="serialNumber"
                    :rules="serialNumberRules"
                    type="text"
                    label="Serial Number"
                  ></v-text-field>
                  <v-select
                    v-model="serviceType"
                    :rules="serviceTypeRules"
                    :items="serviceTypeList"
                    label="Service Type"
                  ></v-select>
                  <v-textarea v-model="notes" label="Notes"></v-textarea>
                  <v-select
                    v-model="status"
                    :rules="statusRules"
                    :items="statusList"
                    label="Status"
                  ></v-select>
                </v-flex>
                <v-flex xs4>
                  <br>
                  <br>
                  <br>
                  <add-machine-model/>
                </v-flex>
              </v-layout>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer/>
            <v-btn @click="validate">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
    <v-layout align-end justify-end>
      <v-alert v-model="success" type="success" dismissible>Save success</v-alert>
      <v-alert
        v-model="error"
        type="error"
        dismissible
      >There's an error with your request, please try again</v-alert>
    </v-layout>
  </v-container>
</template>

<script>
import AddMachineModel from "../components/AddMachineModel.vue";

export default {
  components: {
    AddMachineModel
  },

  data: () => ({
    valid: true,
    success: false,
    error: false,

    machineId: null,
    uniqueId: "0001", //dummy
    existingMachine: ["MC1001", "MC1002"], //dummy
    machineIdRules: [
      v => !!v || "Please select a machine or create a new entry"
    ],

    modelNumber: null,
    existingModel: ["ABC1", "DEF2"], //dummy
    modelNumberRules: [v => !!v || "This field cannot be blank"],

    serialNumber: null,
    serialNumberRules: [v => !!v || "This field cannot be blank"],

    serviceType: null,
    serviceTypeList: ["On site", "Send in", "Other"],
    serviceTypeRules: [v => !!v || "This field cannot be blank"],

    notes: null,

    status: null,
    statusList: ["Normal", "Down", "Repair pending", "Repairing"],
    statusRules: [v => !!v || "This field cannot be blank"]
  }),

  methods: {
    generateNewId() {
      this.machineId = "MC" + this.uniqueId; //dummy
    },

    validate() {
      if (this.$refs.MachineForm.validate()) {
        this.success = true;
      } else {
        this.error = true;
      }
    }
  }
};
</script>
