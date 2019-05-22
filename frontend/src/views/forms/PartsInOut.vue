<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg8 sm12>
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
                <v-flex xs8>
                  <v-text-field
                    v-model="partsId"
                    :rules="partsIdRules"
                    type="text"
                    label="Parts ID"
                    disabled
                  ></v-text-field>
                  <v-autocomplete
                    v-model="partsId"
                    :rules="partsNameRules"
                    :items="existingPartsId"
                    item-text="partsName"
                    item-value="partsId"
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
import axios from "axios";

export default {
  data: () => ({
    valid: true,

    snackbarActivate: false,
    snackbarMode: null,
    snackbarMessage: null,

    uniqueId: "",
    partsType: "in",
    partsTypeList: [
      { label: "Parts in", value: "in" },
      { label: "Parts out", value: "out" }
    ],

    partsId: null,
    existingPartsId: [],
    partsIdRules: [v => !!v || "This field cannot be blank"],

    existingPartsName: [],
    partsNameRules: [v => !!v || "This field cannot be blank"],

    amount: null,
    amountRules: [v => !!v || "This field cannot be blank"],

    details: null,

    rowCounts: []
  }),

  methods: {
    async refreshData() {
      let currentList = await axios
        .get(
          "//localhost:80/MachineMaintenance/public/api/partsInOut/getCurrentId",
          {}
        )
        .then(response => {
          this.existingPartsId = response.data;
        });
      
      let countList = await axios
        .get(
          "//localhost:80/MachineMaintenance/public/api/partsInOut/count",
          {}
        )
        .then(response => {
          this.rowCounts = response.data;
          this.rowCounts[0].piCount = "PI" + this.rowCounts[0].piCount;
          this.rowCounts[0].poCount = "PO" + this.rowCounts[0].poCount;
          this.rowCounts[0].toCount = "TO" + this.rowCounts[0].toCount;
        });
    },

    resetAllFields() {
        (this.partsId = null),
        (this.amount = null),
        (this.details = null);
    },

    commitChanges() {
      return axios
        .post(
          "//localhost:80/MachineMaintenance/public/api/partsInOut/submit",
          {
            partsId: this.partsId,
            partsInId: this.rowCounts[0].piCount,
            partsOutId: this.rowCounts[0].poCount,
            transOutId: this.rowCounts[0].toCount,
            partsType: this.partsType,
            amount: this.amount,
            details: this.details,
            staffId: this.$root.authInfo.userId
          }
        )
        .then(response => response.data)
        .catch(error => console.log(error));
    },

    openSnackbar(mode, message) {
      this.snackbarMode = mode;
      this.snackbarMessage = message;
      this.snackbarActivate = true;
    },

    validate() {
      if (this.$refs.PartsInOutForm.validate()) {
        this.commitChanges().then(response => {
          if (response == 1) {
            this.openSnackbar("success", "Insert successfully");

            //update dropdown
            this.resetAllFields();
            this.refreshData();
          }
          else this.openSnackbar("error", "Insert error");
        });
      } else {
        this.openSnackbar("error", "Error, please check your input.");
      }
    }
  },

  created: async function() {
    this.refreshData();
  }
};
</script>
