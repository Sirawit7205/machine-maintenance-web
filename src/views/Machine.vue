<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg3 sm9>
        <div class="headline mb-1">Add or edit machine</div>
        <v-card>
          <v-card-text>
            <v-form ref="MachineSrcAdd" v-model="valid" lazy-validation>
              Search for existing machine:
              <v-autocomplete placeholder="Search..."></v-autocomplete>
              <p class="text-xs-center">----- OR -----</p>Add new machine:
              <br>
              <v-btn block>Add Machine</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Machine Info</div>
        <v-card>
          <v-card-text>
            <v-form ref="MachineForm" v-model="valid" lazy-validation>
              <v-layout row>
                <v-flex xs6>
                  <v-text-field
                    v-model="MachineID"
                    type="text"
                    label="Machine ID"
                    required
                    disabled
                  ></v-text-field>
                  <v-autocomplete label="Model Number" placeholder="Search..."></v-autocomplete>
                  <v-text-field v-model="SerialNumber" type="text" label="Serial Number" required></v-text-field>
                  <v-select :items="serviceTypeList" label="ServiceType" required></v-select>
                  <v-textarea v-model="Notes" label="Notes"></v-textarea>
                  <v-select :items="statusList" label="Status" required></v-select>
                </v-flex>
                <v-flex xs6>
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
    username: "",
    usernameRules: [
      v => !!v || "Username cannot be blank",
      v => (v && v.length <= 20) || "Maximum length is 20 characters"
    ],

    password: "",
    passwordRules: [
      v => !!v || "Password cannot be blank",
      v => (v && v.length <= 20) || "Maximum length is 20 characters"
    ],

    serviceTypeList: ["On site", "Send in", "Other"],
    statusList: ["Normal", "Down", "Repair pending", "Repairing"]
  }),

  methods: {
    validate() {
      if (this.$refs.loginForm.validate()) {
        alert("OK! Logged in as " + this.username);
      } else {
        alert("Error!");
      }
    }
  }
};
</script>
