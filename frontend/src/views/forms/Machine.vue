<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg3 sm9>
        <div class="headline mb-1">Add or edit machine</div>
        <v-card>
          <v-card-text>
            <v-form ref="MachineSrcAdd" v-model="valid" lazy-validation>
              Search for existing machine:
              <v-autocomplete v-model="machineId" :items="existingMachine" item-text="machineId" item-value="machineId" placeholder="Search..." @change="setUpdate"></v-autocomplete>
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
                    item-text="modelNumber"
                    item-value="modelCode"
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
                  <add-machine-model v-model="lastAddedModel"/>
                </v-flex>
              </v-layout>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-btn @click="deleteData">Delete</v-btn>
            <v-spacer/>
            <v-btn @click="validate">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
    <v-snackbar
      v-model="snackbarActivate"
      :bottom="true"
      :right="true"
      :color="snackbarMode"
      :timeout="3000"
    >
      {{snackbarMessage}}
      <v-btn flat @click="snackbarActivate = false">Close</v-btn>
    </v-snackbar>
  </v-container>
</template>

<script>
import AddMachineModel from "../../components/AddMachineModel.vue";
import axios from "axios";
export default {
  components: {
    AddMachineModel
  },

  data: () => ({
    valid: true,

    actionType: 0,
    lastAddedModel: null,

    snackbarActivate: false,
    snackbarMode: null,
    snackbarMessage: null,

    machineId: null,
    uniqueId: "",
    existingMachine: [],
    machineIdRules: [
      v => !!v || "Please select a machine or create a new entry"
    ],

    modelNumber: "",
    existingModel: [],
    modelNumberRules: [v => !!v || "This field cannot be blank"],

    serialNumber: null,
    serialNumberRules: [v => !!v || "This field cannot be blank"],

    serviceType: null,
    serviceTypeList: ["On site", "Carry in", "Other"],
    serviceTypeRules: [v => !!v || "This field cannot be blank"],

    notes: null,

    status: null,
    statusList: ["Normal", "Down", "Repair pending", "Repairing"],
    statusRules: [v => !!v || "This field cannot be blank"]
  }),

  methods: {
    generateNewId() {
      this.resetAllFields();
      this.machineId = "MC" + this.uniqueId;
      this.actionType = 0;
      this.getAllModels();
    },

    async refreshData() {
      let currentList = await axios
        .get(
          "//localhost:80/MachineMaintenance/public/api/machine/getCurrentIds",
          {}
        )
        .then(response => {
          this.existingMachine = response.data;
        });

      let machineCount = await axios
        .get("//localhost:80/MachineMaintenance/public/api/machine/count", {})
        .then(response => {
          this.uniqueId = response.data;
        });
    },
    async getCurrentData() {
      let allData = await axios.get(
        "//localhost:80/MachineMaintenance/public/api/machine/all/" +
          this.machineId,
        {}
      );
        (this.modelNumber = allData.data[0].currentModel[0].modelCode),
        (this.serialNumber = allData.data[0].serialNumber),
        (this.serviceType = allData.data[0].serviceType),
        (this.notes = allData.data[0].notes),
        (this.status = allData.data[0].status),
        (this.existingModel = allData.data[0].allModel)
    },

    async getAllModels() {
      let allData = await axios.get(
        "//localhost:80/MachineMaintenance/public/api/machine/getAllModels",
        {}
      );
        (this.existingModel = allData.data)
    },      

    commitChanges() {
      return axios.post(
        "//localhost:80/MachineMaintenance/public/api/machine/submit",
        {
          actionType: this.actionType,
          machineId: this.machineId,
          modelCode: this.modelNumber,
          serialNumber: this.serialNumber,
          serviceType: this.serviceType,
          notes: this.notes,
          status: this.status
        })
        .then(response => response.data)
        .catch(error => console.log(error));
    },
    resetAllFields() {
      (this.machineId = null),
        (this.modelNumber = null),
        (this.serialNumber = null),
        (this.serviceType = null),
        (this.notes = null),
        (this.status = null);
    },

    setUpdate() {
      this.actionType = 1;
      this.getCurrentData();
    },

    deleteData() {
      this.actionType = 2;
      this.commitChanges().then(response => {
        if (response == true)
          this.openSnackbar("success", "Delete successfully");
        else this.openSnackbar("error", "Delete error");
      });

      //clear deleted data from the form
      this.refreshData();
      this.resetAllFields();
    },

    openSnackbar(mode, message) {
      this.snackbarMode = mode;
      this.snackbarMessage = message;
      this.snackbarActivate = true;
    },

    validate() {
      if (this.$refs.MachineForm.validate()) {
        this.commitChanges().then(response => {
          if(response == 1)
            this.openSnackbar("success", "Insert/Update success");
          else
            this.openSnackbar("error", "Insert/Update error");
        });
      } else {
        this.openSnackbar("error", "Error, please check your input.");
      }
    }
  },

  watch: {
    lastAddedModel: function(newVal, oldVal) {
      this.getAllModels();
    }
  },

  created: async function() {
    this.refreshData();
  }
};
</script>
