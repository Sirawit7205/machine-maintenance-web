<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg9 sm12>
        <div class="headline mb-1">Parts Order and Usage</div>
        <v-card>
          <v-card-text>
            <v-form ref="MachineForm" v-model="valid" lazy-validation>
              <v-layout row>
                <v-flex xs3>
                  <p>Type:</p>
                  <v-radio-group v-model="partType">
                    <v-radio
                      v-for="mainType in partTypeList"
                      :key="mainType.label"
                      :label="mainType.label"
                      :value="mainType.value"
                    ></v-radio>
                  </v-radio-group>
                </v-flex>
                <v-flex xs9>
                  <v-autocomplete label="Parts ID" placeholder="Search..."></v-autocomplete>
                  <v-autocomplete label="Parts name" placeholder="Search..."></v-autocomplete>
                  <v-text-field v-model="Amount" type="number" label="Amount" required></v-text-field>
                  <v-textarea v-model="Details" type="text" label="Details" required></v-textarea>
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
export default {
  data: () => ({
    valid: true,

    partTypeList: [
      { label: "Parts in", value: "in" },
      { label: "Parts out", value: "out" }
    ],

    partType: "in"
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
