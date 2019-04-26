<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg3 sm9>
        <div class="headline mb-1">Add or edit staff</div>
        <v-card>
          <v-card-text>
            <v-form ref="StaffSrcAdd" v-model="valid" lazy-validation>
              Search for existing staff:
              <v-autocomplete v-model="staffId" :items="existingStaff" placeholder="Search..."></v-autocomplete>
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
export default {
  data: () => ({
    valid: true,
    success: false,
    error: false,

    staffId: null,
    uniqueId: "0001", //dummy
    existingStaff: ["ST1001", "ST1002"], //dummy
    staffIdRules: [v => !!v || "Please select a machine or create a new entry"],

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
    vacationLeftRules: [v => !!v || "This field cannot be blank"]
  }),

  methods: {
    generateNewId() {
      this.staffId = "ST" + this.uniqueId; //dummy
    },

    validate() {
      if (this.$refs.StaffForm.validate()) {
        this.success = true;
      } else {
        this.error = true;
      }
    }
  }
};
</script>
