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
import DatePicker from "../../components/DatePicker.vue";
import axios from "axios";

export default {
  components: {
    DatePicker
  },
  data: () => ({
    valid: true,

    actionType: 0,

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
    async refreshData() {
      let currentList = await axios.get(
        "//localhost:80/Machine/public/api/contract/getCurrentIds",
        {}
      );
    },

    async getCurrentData() {
      let allData = await axios.get(
        "//localhost:80/MachineMaintenance/public/api/contract/all/" +
          this.contractId,
        {}
      );

      (this.contractId = allData.data[0].contractId),
        (this.customerId = allData.data[0].customerId),
        (this.customerName = allData.data[0].customerName),
        (this.address = allData.data[0].address),
        (this.phone = allData.data[0].phone),
        (this.email = allData.data[0].email),
        (this.machineInContract = allData.data[0].machineInContract),
        (this.price = allData.data[0].price),
        (this.startDate = allData.data[0].startDate),
        (this.endDate = allData.data[0].endDate);
    },

    resetAllFields() {
      (this.contractId = null),
        (this.customerId = null),
        (this.customerName = null),
        (this.address = null),
        (this.phone = null),
        (this.email = null),
        (this.machineInContract = null),
        (this.price = null),
        (this.startDate = null),
        (this.endDate = null);
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

    commitChanges() {
      return axios
        .post("//localhost:80/MachineMaintenance/public/api/contract/submit", {
          actionType: this.actionType,
          contractId: this.contractId,
          customerId: this.customerId,
          customerName: this.customerName,
          address: this.address,
          phone: this.phone,
          email: this.email,
          machineInContract: this.machineInContract,
          price: this.price,
          startData: this.startDate,
          endDate: this.endDate
        })
        .then(response => response.data)
        .catch(error => console.log(error));
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
  },
  created: async function() {
    this.refreshData();
  }
};
</script>
