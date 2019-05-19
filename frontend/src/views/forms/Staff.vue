<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg3 sm9>
        <div class="headline mb-1">Add or edit staff</div>
        <v-card>
          <v-card-text>
            <v-form ref="StaffSrcAdd" v-model="valid" lazy-validation>
              Search for existing staff:
              <v-autocomplete
                v-model="staffId"
                :items="existingStaff"
                item-text="staffName"
                item-value="staffId"
                placeholder="Search..."
                @change="setUpdate"
                ></v-autocomplete>
              <p class="text-xs-center">----- OR -----</p>Add new staff:
              <br>
              <v-btn block @click="generateNewId">Add Staff</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg9 sm9>
        <div class="headline mb-1">Staff Info</div>
        <v-card>
          <v-card-text>
            <v-form ref="StaffForm" v-model="valid" lazy-validation>
              <v-layout row>
                <v-flex xs6>
                  <v-text-field
                    v-model="staffId"
                    :rules="staffIdRules"
                    type="text"
                    label="Staff ID"
                    disabled
                  ></v-text-field>
                  <v-text-field
                    v-model="staffName"
                    :rules="staffNameRules"
                    type="text"
                    label="Name and Surname"
                  ></v-text-field>
                  <v-textarea v-model="address" :rules="addressRules" label="Address"></v-textarea>
                  <v-text-field v-model="phone" :rules="phoneRules" type="number" label="Phone"></v-text-field>
                  <v-text-field v-model="email" :rules="emailRules" type="email" label="Email"></v-text-field>
                  <v-text-field v-model="username" :rules="usernameRules" type="text" label="Username"></v-text-field>
                </v-flex>
                <v-flex xs6>
                  <v-select
                    v-model="position"
                    :rules="positionRules"
                    :items="positionList"
                    label="Position"
                  ></v-select>
                  <v-text-field v-model="salary" :rules="salaryRules" type="number" label="Salary"></v-text-field>
                  <v-select
                    v-model="status"
                    :rules="statusRules"
                    :items="statusList"
                    label="Status"
                  ></v-select>
                  <v-text-field
                    v-model="experience"
                    :rules="experienceRules"
                    type="number"
                    label="Experience Points"
                  ></v-text-field>
                  <v-text-field
                    v-model="vacationTotal"
                    :rules="vacationTotalRules"
                    type="number"
                    label="Vacation days total"
                  ></v-text-field>
                  <v-text-field
                    v-model="vacationLeft"
                    :rules="vacationLeftRules"
                    type="number"
                    label="Vacation days left"
                  ></v-text-field>
                  <v-text-field
                    v-model="password"
                    :rules="passwordRules"
                    type="password"
                    label="New password"
                  ></v-text-field>
                  <v-text-field
                    v-model="cfmPassword"
                    :rules="passwordRules"
                    type="password"
                    label="Confirm password"
                  ></v-text-field>
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
import axios from "axios";

export default {
  data: () => ({
    valid: true,

    //type 0: insert, type 1: update, type2: delete
    actionType: 0,

    snackbarActivate: false,
    snackbarMode: null,
    snackbarMessage: null,

    staffId: null,
    uniqueId: "",
    existingStaff: [],
    staffIdRules: [v => !!v || "Please select a staff or create a new entry"],

    staffName: null,
    staffNameRules: [v => !!v || "This field cannot be blank"],

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

    position: null,
    positionList: ["Manager", "Supervisor", "Technician", "Call center"],
    positionRules: [v => !!v || "This field cannot be blank"],

    salary: null,
    salaryRules: [v => !!v || "This field cannot be blank"],

    status: null,
    statusList: ["Idle", "On Site", "On job", "Vacation", "Sick"],
    statusRules: [v => !!v || "This field cannot be blank"],

    experience: null,
    experienceRules: [v => !!v || "This field cannot be blank"],

    vacationTotal: null,
    vacationTotalRules: [v => !!v || "This field cannot be blank"],

    vacationLeft: null,
    vacationLeftRules: [v => !!v || "This field cannot be blank"],

    username: "",
    usernameRules: [
      v => !!v || "Username cannot be blank",
      v => (v && v.length <= 20) || "Maximum length is 20 characters"
    ],

    password: "",
    cfmPassword: "",
    passwordRules: [
      v => (v && v.length >= 8 && v.length <= 20) || !v || "Password length must be 8-20 characters"
    ],
  }),

  methods: {
    generateNewId() {
      this.staffId = "ST" + this.uniqueId;
      this.actionType = 0;
      this.resetAllFields();
    },

    async getCurrentData() {
      let allData = await axios.get("//localhost:80/MachineMaintenance/public/api/staff/all/"+this.staffId, {
      });

      this.staffId = allData.data[0].staffId,
      this.username = allData.data[0].staffUsername,
      this.staffName = allData.data[0].staffName,
      this.address = allData.data[0].address,
      this.phone = allData.data[0].phone,
      this.email = allData.data[0].email,
      this.position = allData.data[0].position,
      this.salary = allData.data[0].salary,
      this.status = allData.data[0].status,
      this.experience = allData.data[0].experience,
      this.vacationTotal = allData.data[0].vacationTotal,
      this.vacationLeft = allData.data[0].vacationLeft
    },

    resetAllFields() {
      this.username = null,
      this.password = null,
      this.cfmPassword = null,
      this.staffName = null,
      this.address = null,
      this.phone = null,
      this.email = null,
      this.position = null,
      this.salary = null,
      this.status = null,
      this.experience = null,
      this.vacationTotal = null,
      this.vacationLeft = null
    },

    setUpdate() {
      this.actionType = 1;
      this.getCurrentData();
    },

    commitChanges() {
      return axios.post("//localhost:80/MachineMaintenance/public/api/staff/submit", {
        actionType: this.actionType,
        staffId: this.staffId,
        staffUsername: this.username,
        staffPassword: this.password,
        staffName: this.staffName,
        address: this.address,
        phone: this.phone,
        email: this.email,
        position: this.position,
        salary: this.salary,
        status: this.status,
        experience: this.experience,
        vacationTotal: this.vacationTotal,
        vacationLeft: this.vacationLeft
      }).then(response => response.data).catch(error => console.log(error));
    },

    deleteData() {
      this.actionType = 2;
      this.commitChanges().then(response => {
        if(response == 0)
          this.openSnackbar("success","Delete successfully");
        else
          this.openSnackbar("error","Delete error");
      });
      //send delete request
    },

    openSnackbar(mode, message) {
      this.snackbarMode = mode;
      this.snackbarMessage = message;
      this.snackbarActivate = true;
    },

    validate() {
      if (this.$refs.StaffForm.validate()) {
        if(this.password == this.cfmPassword) {
          this.commitChanges().then(response => {
            if(response == 0 && this.actionType == 0)
              this.openSnackbar("success","Update successfully");
            else if(response == 0 && this.actionType == 1)
              this.openSnackbar("success","Insert successfully");
            else
              this.openSnackbar("error","Insert/Update error");
          });
        } else {
          this.openSnackbar("error", "Error, password does not matched.");
        }
      } else {
        this.openSnackbar("error", "Error, please check your input.");
      }
    }
  },

  created: async function() {
  let currentList = await axios.get("//localhost:80/MachineMaintenance/public/api/staff/getCurrentIds", {
  }).then(response => { this.existingStaff = response.data });
  let staffCount = await axios.get("//localhost:80/MachineMaintenance/public/api/staff/count", {
  }).then(response => { this.uniqueId = response.data });
  }
};
</script>
