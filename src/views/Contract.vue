<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg3 sm9>
        <div class="headline mb-1">
          Add or edit contract
        </div>
        <v-card>
          <v-card-text>
            <v-form ref="ContractSrcAdd" v-model="valid" lazy-validation>
              Search for existing contract:
              <v-autocomplete placeholder="Search..."></v-autocomplete>
              <p class="text-xs-center">----- OR -----</p>
              Add new contract: <br />
              <v-btn block>Add Contract</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">
          Contract Info
        </div>
        <v-card>
          <v-card-text>
            <v-form ref="ContractForm" v-model="valid" lazy-validation>
              <v-layout row justify-space-around>
                <v-flex xs5>
                  <p class="text-xs-center">Customer Info</p>
                  <v-text-field
                    v-model="ContractID"
                    type="text"
                    label="Contract ID"
                    required
                    disabled
                  ></v-text-field>
                  <v-autocomplete
                    v-model="CustomerID"
                    label="Search for existing customer:"
                    placeholder="Search..."
                    required
                  ></v-autocomplete>
                  <p class="text-xs-center">Or add new customer data:</p>
                  <v-text-field
                    v-model="CustomerName"
                    type="text"
                    label="Customer Name"
                    required
                  ></v-text-field>
                  <v-textarea
                    v-model="Address"
                    label="Address"
                    required
                  ></v-textarea>
                  <v-text-field
                    v-model="Phone"
                    type="number"
                    label="Phone"
                    required
                  ></v-text-field>
                  <v-text-field
                    v-model="Email"
                    type="email"
                    label="Email"
                  ></v-text-field>
                </v-flex>
                <v-flex xs5>
                  <p class="text-xs-center">Contract Info</p>
                  <v-autocomplete
                    label="Machines in this contract"
                    placeholder="Search..."
                  ></v-autocomplete>
                  <v-text-field
                    v-model="Price"
                    type="number"
                    label="Contract Price"
                    required
                  ></v-text-field>
                  <DatePicker label="Start Date" />
                  <br />
                  <DatePicker label="End Date" />
                </v-flex>
              </v-layout>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn @click="validate">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import DatePicker from "../components/DatePicker.vue";

export default {
  components: {
    DatePicker
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
    ]
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
