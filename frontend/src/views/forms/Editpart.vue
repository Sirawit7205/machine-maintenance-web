<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg3 xs9>
        <div class="headline mb-1">Add or Edit Part</div>
        <v-card>
          <v-card-text>
            <v-form ref="EditPartSrcAdd" v-model="valid" lazy-validation>
              Search For Existing Part:
              <v-autocomplete v-model="partsId" :items="existingParts" placeholder="Search..."></v-autocomplete>
              <p class="text-xs-center">----- OR -----</p>Add New Part:
              <br>
              <v-btn block @click="generateNewId">Add Part</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg6 xs9>
        <div class="headline mb-1">Part Info</div>
        <v-card>
          <v-card-text>
            <v-form ref="EditPartForm" v-model="valid" lazy-validation>
              <v-layout row>
                <v-flex xs12>
                  <v-text-field
                    v-model="partsId"
                    :rules="partsIdRules"
                    type="text"
                    label="Parts ID"
                    disabled
                  ></v-text-field>
                  <v-text-field
                    v-model="partsName"
                    :rules="partsNameRules"
                    type="text"
                    label="Parts Name"
                  ></v-text-field>
                  <v-text-field
                    v-model="pricePerUnit"
                    :rules="pricePerUnitRules"
                    type="number"
                    label="Price Per Unit"
                  ></v-text-field>
                  <v-autocomplete
                    v-model="useInModel"
                    :rules="useInModelRules"
                    :items="useInModelList"
                    label="Use in model(s)"
                    placeholder="Search..."
                    multiple
                    chips
                  ></v-autocomplete>
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
export default {
  data: () => ({
    valid: true,

    snackbarActivate: false,
    snackbarMode: null,
    snackbarMessage: null,

    partsId: null,
    uniqueId: "0001", //dummy
    existingParts: ["PN1001", "PN1002"], //dummy
    partsIdRules: [v => !!v || "Please select a part or create a new entry"],

    partsName: null,
    partsNameRules: [v => !!v || "This field cannot be blank"],

    pricePerUnit: null,
    pricePerUnitRules: [v => !!v || "This field cannot be blank"],

    useInModel: null,
    useInModelList: ["A1", "A2", "A3", "A4"],
    useInModelRules: [v => !!v || "This field cannot be blank"]
  }),

  methods: {
    generateNewId() {
      this.partsId = "PN" + this.uniqueId; //dummy
    },

    openSnackbar(mode, message) {
      this.snackbarMode = mode;
      this.snackbarMessage = message;
      this.snackbarActivate = true;
    },

    validate() {
      if (this.$refs.EditPartForm.validate()) {
        this.openSnackbar("success", "Sucessfully save");
      } else {
        this.openSnackbar("error", "An error had occured, please try again.");
      }
    }
  }
};
</script>