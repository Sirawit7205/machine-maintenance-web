<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg9 sm12>
        <div class="headline mb-1">Parts Order and Usage</div>
        <v-card>
          <v-card-text>
            <v-form ref="PartsInOutForm" v-model="valid" lazy-validation>
              <v-layout row>
                <v-flex xs3>
                  <p>Type:</p>
                  <v-radio-group v-model="partsType">
                    <v-radio
                      v-for="mainType in partsTypeList"
                      :key="mainType.label"
                      :label="mainType.label"
                      :value="mainType.value"
                    ></v-radio>
                  </v-radio-group>
                </v-flex>
                <v-flex xs9>
                  <v-autocomplete
                    v-model="partsId"
                    :rules="partsIdRules"
                    :items="existingPartsId"
                    label="Parts ID"
                    placeholder="Search..."
                  ></v-autocomplete>
                  <v-autocomplete
                    v-model="partsName"
                    :rules="partsNameRules"
                    :items="existingPartsName"
                    label="Parts name"
                    placeholder="Search..."
                  ></v-autocomplete>
                  <v-text-field v-model="amount" :rules="amountRules" type="number" label="Amount"></v-text-field>
                  <v-textarea v-model="details" type="text" label="Details"></v-textarea>
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

    partsType: "in",
    partsTypeList: [
      { label: "Parts in", value: "in" },
      { label: "Parts out", value: "out" }
    ],

    partsId: null,
    existingPartsId: ["PN1001", "PN1002"], //dummy
    partsIdRules: [v => !!v || "This field cannot be blank"],

    partsName: null,
    existingPartsName: ["PN1001", "PN1002"], //dummy
    partsNameRules: [v => !!v || "This field cannot be blank"],

    amount: null,
    amountRules: [v => !!v || "This field cannot be blank"],

    details: null
  }),

  methods: {
    openSnackbar(mode, message) {
      this.snackbarMode = mode;
      this.snackbarMessage = message;
      this.snackbarActivate = true;
    },

    validate() {
      if (this.$refs.PartsInOutForm.validate()) {
        this.openSnackbar("success", "Sucessfully save");
      } else {
        this.openSnackbar("error", "An error had occured, please try again.");
      }
    }
  }
};
</script>
