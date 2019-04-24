<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg3 sm9>
        <div class="headline mb-1">Add or edit assignments</div>
        <v-card>
          <v-card-text>
            <v-form ref="StaffSrcAdd" v-model="valid" lazy-validation>
              Search For Existing Assignments:
              <v-autocomplete placeholder="Search..."></v-autocomplete>
              <p class="text-xs-center">----- OR -----</p>Add New Assignment:
              <v-btn block>Add Assignment</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg6 sm9>
        <div class="headline mb-1">Job Assignment</div>
        <v-card>
          <v-card-text>
            <v-form ref="JobAssignmentForm" v-model="valid" lazy-validation>
              <v-layout row>
                <v-flex xs6>
                  <v-text-field v-model="JobID" type="text" label="Job ID" required disabled></v-text-field>
                  <v-autocomplete label="Machine" placeholder="Search..."></v-autocomplete>
                  <v-select :items="jobTypeList" label="Job Type" required></v-select>
                  <v-autocomplete label="Staffs" placeholder="Search..."></v-autocomplete>
                  <v-textarea v-model="JobDetails" type="text" label="Job Details"></v-textarea>
                </v-flex>
                <v-flex xs6>
                  <DatePicker label="Start Date"/>
                  <br>
                  <DatePicker label="Start Time"/>
                  <v-text-field v-model="Duration" type="number" label="Estimate Duration" required></v-text-field>
                  <v-select :items="priorityList" label="Priority" required></v-select>
                  <v-select :items="priorityList" label="Severity" required></v-select>
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
import DatePicker from "../components/DatePicker.vue";

export default {
  components: {
    DatePicker
  },

  data: () => ({
    valid: true,

    jobTypeList: ["Maintenance", "Repair"],
    priorityList: [
      "Critical",
      "High",
      "Medium",
      "Low",
      "Very low",
      "Undefined"
    ],

    logType: "case"
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