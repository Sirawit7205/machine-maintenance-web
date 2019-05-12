<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg3 sm9>
        <div class="headline mb-1">Add or edit contract</div>
        <v-card>
          <v-card-text>
            <v-form ref="ContractSrcAdd" v-model="valid" lazy-validation>
              Search for existing contract:
              <v-autocomplete
                v-model="contractId"
                :items="existingContract"
                placeholder="Search..."
              ></v-autocomplete>
              <p class="text-xs-center">----- OR -----</p>Add new contract:
              <br>
              <v-btn block @click="generateNewId">Add Contract</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg9 sm9>
        <div class="headline mb-1">Contract Info</div>
        <v-card>
          <v-card-text>
            <v-form ref="ContractForm" v-model="valid" lazy-validation>
              <v-layout row justify-space-around>
                <v-flex xs5>
                  <p class="text-xs-center">Customer Info</p>
                  <v-text-field
                    v-model="contractId"
                    :rules="contractIdRules"
                    type="text"
                    label="Contract ID"
                    disabled
                  ></v-text-field>
                  <v-autocomplete
                    v-model="customerId"
                    :items="existingCustomer"
                    label="Search for existing customer:"
                    placeholder="Search..."
                  ></v-autocomplete>
                  <p class="text-xs-center">Or add new customer data:</p>
                  <v-text-field
                    v-model="customerName"
                    :rules="customerNameRules"
                    type="text"
                    label="Customer Name"
                  ></v-text-field>
                  <v-textarea v-model="address" :rules="addressRules" label="Address"></v-textarea>
                  <v-text-field v-model="phone" :rules="phoneRules" type="number" label="Phone"></v-text-field>
                  <v-text-field v-model="email" :rules="emailRules" type="email" label="Email"></v-text-field>
                </v-flex>
                <v-flex xs5>
                  <p class="text-xs-center">Contract Info</p>
                  <v-autocomplete
                    v-model="machineInContract"
                    :rules="machineInContractRules"
                    :items="machineInContractList"
                    label="Machines in this contract"
                    placeholder="Search..."
                    multiple
                    chips
                  ></v-autocomplete>
                  <v-text-field
                    v-model="price"
                    :rules="priceRules"
                    type="number"
                    label="Contract Price"
                  ></v-text-field>
                  <DatePicker v-model="startDate" :rules="startDateRules" label="Start Date"/>
                  <br>
                  <DatePicker v-model="endDate" :rules="endDateRules" label="End Date"/>
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
import DatePicker from "../../components/DatePicker.vue";

export default {
  components: {
    DatePicker
  },
  data: () => ({
    valid: true,

    snackbarActivate: false,
    snackbarMode: null,
    snackbarMessage: null,

    contractId: null,
    uniqueId: "0001", //dummy
    existingContract: ["CN1001", "CN1002"], //dummy
    contractIdRules: [
      v => !!v || "Please select a contract or create a new entry"
    ],

    customerId: null,
    existingCustomer: ["CS1001", "CS1002"], //dummy

    customerName: null,
    customerNameRules: [
      v => !!v || "Please select a contract or create a new entry"
    ],

    address: null,
    addressRules: [v => !!v || "This field cannot be blank"],

    phone: null,
    phoneRules: [v => !!v || "This field cannot be blank"],

    email: null,
    emailRules: [
      v =>
        /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
        !v ||
        "Please enter a valid email address"
    ],

    machineInContract: null,
    machineInContractList: ["A1", "A2", "A3", "A4"], //dummy
    machineInContractRules: [v => !!v || "This field cannot be blank"],

    price: null,
    priceRules: [v => !!v || "This field cannot be blank"],

    startDate: null,
    startDateRules: [v => !!v || "This field cannot be blank"],

    endDate: null,
    endDateRules: [v => !!v || "This field cannot be blank"]
  }),

  methods: {
    generateNewId() {
      this.contractId = "CN" + this.uniqueId; //dummy
    },

    openSnackbar(mode, message) {
      this.snackbarMode = mode;
      this.snackbarMessage = message;
      this.snackbarActivate = true;
    },

    validate() {
      if (this.$refs.ContractForm.validate()) {
        this.openSnackbar("success", "Sucessfully save");
      } else {
        this.openSnackbar("error", "An error had occured, please try again.");
      }
    }
  }
};
</script>
