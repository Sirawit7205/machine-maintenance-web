<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg3 sm9>
        <div class="headline mb-1">Edit assignments</div>
        <v-card>
          <v-card-text>
            <v-form ref="StaffSrcAdd" v-model="valid" lazy-validation>
              Search For Existing Jobs:
              <v-autocomplete v-model="jobId" :items="existingJobs" placeholder="Search..."></v-autocomplete>
            </v-form>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex lg9 sm9>
        <div class="headline mb-1">Job details</div>
        <v-card>
          <v-card-text>
            <v-form ref="JobAssignmentForm" v-model="valid" lazy-validation>
              <v-layout row>
                <v-flex xs6>
                  <v-text-field
                    v-model="jobId"
                    :rules="jobIdRules"
                    type="text"
                    label="Job ID"
                    disabled
                  ></v-text-field>
                  <v-autocomplete
                    v-model="machineId"
                    :rules="machineIdRules"
                    :items="machineIdList"
                    label="Machine"
                    placeholder="Search..."
                  ></v-autocomplete>
                  <v-select
                    v-model="jobType"
                    :rules="jobTypeRules"
                    :items="jobTypeList"
                    label="Job Type"
                  ></v-select>
                  <v-autocomplete
                    v-model="staff"
                    :rules="staffRules"
                    :items="staffList"
                    label="Staffs"
                    placeholder="Search..."
                    multiple
                  ></v-autocomplete>
                  <v-textarea
                    v-model="details"
                    :rules="detailsRules"
                    type="text"
                    label="Job Details"
                  ></v-textarea>
                </v-flex>
                <v-flex xs6>
                  <DatePicker v-model="startDate" :rules="startDateRules" label="Start Date"/>
                  <br>
                  <TimePicker v-model="startTime" :rules="startTimeRules" label="Start Time"/>
                  <v-text-field v-model="estimateDuration" type="number" label="Estimate Duration"></v-text-field>
                  <v-select
                    v-model="priority"
                    :rules="priorityRules"
                    :items="priorityList"
                    label="Priority"
                  ></v-select>
                  <v-select
                    v-model="severity"
                    :rules="severityRules"
                    :items="priorityList"
                    label="Severity"
                  ></v-select>
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
import DatePicker from "../components/DatePicker.vue";
import TimePicker from "../components/TimePicker.vue";

export default {
  components: {
    DatePicker,
    TimePicker
  },

  data: () => ({
    valid: true,

    snackbarActivate: false,
    snackbarMode: null,
    snackbarMessage: null,

    jobId: null,
    existingJobs: ["JB1001", "JB1002"], //dummy
    jobIdRules: [v => !!v || "Please select a job"],

    machineId: null,
    machineIdList: ["A1", "A2"],
    machineIdRules: [v => !!v || "This field cannot be blank"],

    jobType: null,
    jobTypeList: ["Maintenance", "Repair"],
    jobTypeRules: [v => !!v || "This field cannot be blank"],

    staff: null,
    staffList: ["S1", "S2"],
    staffRules: [v => !!v || "This field cannot be blank"],

    details: null,
    detailsRules: [v => !!v || "This field cannot be blank"],

    startDate: null,
    startDateRules: [v => !!v || "This field cannot be blank"],

    startTime: null,
    startTimeRules: [v => !!v || "This field cannot be blank"],

    estimateDuration: null,

    priority: null,
    priorityList: [
      "Critical",
      "High",
      "Medium",
      "Low",
      "Very low",
      "Undefined"
    ],
    priorityRules: [v => !!v || "This field cannot be blank"],

    severity: null,
    severityRules: [v => !!v || "This field cannot be blank"]
  }),

  methods: {
    openSnackbar(mode, message) {
      this.snackbarMode = mode;
      this.snackbarMessage = message;
      this.snackbarActivate = true;
    },

    validate() {
      if (this.$refs.JobAssignmentForm.validate()) {
        this.openSnackbar("success", "Sucessfully save");
      } else {
        this.openSnackbar("error", "An error had occured, please try again.");
      }
    }
  }
};
</script>