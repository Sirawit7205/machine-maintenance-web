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
                item-text="contractId"
                item-value="contractId"
                placeholder="Search..."
                @change="updateCont"
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
                    item-text="customerName"
                    item-value="customerId"
                    label="Search for existing customer:"
                    placeholder="Search..."
                    @change="updateCust"
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
                    item-text="machineID"
                    item-value="machineID"
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
                  <DatePicker v-model="startDate" :setDate="startDate" :rules="startDateRules" label="Start Date"/>
                  <br>
                  <DatePicker v-model="endDate" :setDate="endDate" :rules="endDateRules" label="End Date"/>
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

    contActionType: 0,
    custActionType: 0,

    snackbarActivate: false,
    snackbarMode: null,
    snackbarMessage: null,

    contractId: null,
    uniqueContId: "0001",
    existingContract: [], 
    contractIdRules: [
      v => !!v || "Please select a contract or create a new entry"
    ],

    customerId: null,
    uniqueCustId: "0001",
    existingCustomer: [],

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
    machineInContractList: [],
    machineInContractRules: [v => !!v || "This field cannot be blank"],

    price: null,
    priceRules: [v => !!v || "This field cannot be blank"],

    startDate: "2019-01-01",
    startDateRules: [v => !!v || "This field cannot be blank"],

    endDate: null,
    endDateRules: [v => !!v || "This field cannot be blank"],

    transInId: null
  }),

  methods: {
    generateNewId() {
      this.contActionType = 0;
      this.contractId = "CN" + this.uniqueContId;
      this.getCurrentCont();
    },
    
    async refreshData() {
      let currentList = await axios
      .get("//localhost:80/MachineMaintenance/public/api/contract/getCurrentIds", {})
      .then(response => { 
        this.existingContract = response.data;
      });

      let contractCount = await axios
      .get("//localhost:80/MachineMaintenance/public/api/contract/count", {})
      .then(response => {
        this.uniqueContId = response.data;
      });

      let currentCustList = await axios
      .get("//localhost:80/MachineMaintenance/public/api/customer/getCurrentIds", {})
      .then(response => { 
        this.existingCustomer = response.data;
      });

      let customerCount = await axios
      .get("//localhost:80/MachineMaintenance/public/api/existsCustomer/count", {})
      .then(response => {
        this.uniqueCustId = response.data;
      });

      let transInCount = await axios
      .get("//localhost:80/MachineMaintenance/public/api/existsCustomer/count", {})
      .then(response => {
        this.transInId = "TI" + response.data;
      });
    },

    async getCurrentCont() {
      let allData = await axios.get(
        "//localhost:80/MachineMaintenance/public/api/contract/all/" +
          this.contractId,
        {}
      );

      (this.customerId = allData.data[0].customerID),
      (this.price = allData.data[0].price),
      (this.startDate = allData.data[0].startDate),
      (this.endDate = allData.data[0].endDate),
      (this.machineInContractList = allData.data[0].allMachineList),
      (this.machineInContract = allData.data[0].machineList)

      if(this.contActionType == 1) this.updateCust();
    },

    async getCurrentCust() {
      let allData = await axios.get(
        "//localhost:80/MachineMaintenance/public/api/customer/all/" +
          this.customerId,
        {}
      );

      (this.customerName = allData.data[0].customerName),
      (this.address = allData.data[0].address),
      (this.phone = allData.data[0].phone),
      (this.email = allData.data[0].email);
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

    updateCont() {
      this.contActionType = 1;
      this.getCurrentCont();
    },

    updateCust() {
      this.custActionType = 1;
      this.getCurrentCust();
    },

    commitChanges() {
      return axios
        .post("//localhost:80/MachineMaintenance/public/api/contract/submit", {
          contActionType: this.contActionType,
          custActionType: this.custActionType,
          contractId: this.contractId,
          customerId: this.customerId,
          customerName: this.customerName,
          address: this.address,
          phone: this.phone,
          email: this.email,
          price: this.price,
          startDate: this.startDate,
          endDate: this.endDate,
          transId: this.transInId,
          transType: "Contracts",
          details: "Income from contact",
          amount: this.price,
          staffId: this.$root.authInfo.userId,
          machineId: this.machineInContract
        })
        .then(response => response.data)
        .catch(error => console.log(error));
    },

    deleteData() {
      this.contActionType = 2;
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
      if (this.$refs.ContractForm.validate()) {
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
  created: async function() {
    this.refreshData();
  }
};
</script>
