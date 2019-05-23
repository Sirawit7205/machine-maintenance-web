<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg3 sm9>
        <div class="headline mb-1">Edit assignments</div>
        <v-card>
          <v-card-text>
            <v-form ref="StaffSrcAdd" v-model="valid" lazy-validation>
              Search For Existing Jobs:
              <v-autocomplete v-model="jobId" :items="existingJobs" item-text="jobId" item-value="jobId" placeholder="Search..." @change="setUpdate"></v-autocomplete>
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
                  <v-text-field
                    v-model="machineId"
                    :rules="machineIdRules"
                    type="text"
                    label="Machine ID"
                    disabled
                  ></v-text-field>
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
                    item-text="staffName"
                    item-value="staffId"
                    label="Staffs"
                    placeholder="Search..."
                    chips
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
                  <v-layout row>
                    <v-flex xs6>
                      <DatePicker v-model="startDate" :setDate="startDate" :rules="startDateRules" label="Start Date"/>
                      <br>
                      <TimePicker v-model="startTime" :setTime="startTime" :rules="startTimeRules" label="Start Time"/>
                    </v-flex>
                    <v-flex xs6>
                      <DatePicker v-model="endDate" :setDate="endDate" :rules="startDateRules" label="End Date"/>
                      <br>
                      <TimePicker v-model="endTime" :setTime="endTime" :rules="startTimeRules" label="End Time"/>
                    </v-flex>
                  </v-layout>
                  <v-text-field v-model="estimateDuration" type="number" label="Estimate Duration"></v-text-field>
                  <v-select
                    v-model="priority"
                    :items="priorityList"
                    item-text="text"
                    item-value="level"
                    label="Priority"
                  ></v-select>
                  <v-select
                    v-model="severity"
                    :items="priorityList"
                    item-text="text"
                    item-value="level"
                    label="Severity"
                  ></v-select>
                  <v-select
                    v-model="jobStatus"
                    :rules="statusRules"
                    :items="statusList"
                    label="Job status"
                  ></v-select>
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
import TimePicker from "../../components/TimePicker.vue";
import axios from "axios";

export default {
  components: {
    DatePicker,
    TimePicker
  },

  data: () => ({
    valid: true,

    actionType: 1,

    snackbarActivate: false,
    snackbarMode: null,
    snackbarMessage: null,

    uniqueId: "",
    jobId: null,
    existingJobs: [],
    jobIdRules: [v => !!v || "Please select a job"],

    machineId: null,
    machineIdList: [],
    machineIdRules: [v => !!v || "This field cannot be blank"],

    jobType: null,
    jobTypeList: ["Maintenance", "Repair"],
    jobTypeRules: [v => !!v || "This field cannot be blank"],

    staff: null,
    staffList: [],
    staffRules: [v => !!v || "This field cannot be blank"],

    details: null,
    detailsRules: [v => !!v || "This field cannot be blank"],

    startDate: null,
    startDateRules: [v => !!v || "This field cannot be blank"],

    startTime: null,
    startTimeRules: [v => !!v || "This field cannot be blank"],
    
    endDate: null,

    endTime: null,

    estimateDuration: null,

    priority: 0,
    priorityList: [
      {level: "5", text: "Critical"},
      {level: "4", text: "High"},
      {level: "3", text: "Medium"},
      {level: "2", text: "Low"},
      {level: "1", text: "Very Low"},
      {level: "0", text: "Undefined"}
    ],

    severity: 0,

    jobStatus: null,
    statusList: ["Pending", "Assigned", "Working", "Finished"],
    statusRules: [v => !!v || "This field cannot be blank"],

    status: null
  }),

  methods: {
    openSnackbar(mode, message) {
      this.snackbarMode = mode;
      this.snackbarMessage = message;
      this.snackbarActivate = true;
    },

    async refreshData() {
      let currentList = await axios
        .get("//localhost:80/MachineMaintenance/public/api/job/getCurrentIds", {})
        .then(response => {
          this.existingJobs = response.data;
        });
    },

    async getCurrentData() {
      let allData = await axios.get(
        "//localhost:80/MachineMaintenance/public/api/job/all/" + this.jobId,
        {}
      );
        (this.machineId = allData.data[0].machineId),
        (this.jobType = allData.data[0].jobType),
        (this.staff = allData.data[0].staffList),
        (this.details = allData.data[0].details),
        (this.startDate = allData.data[0].date),
        (this.endDate = allData.data[0].endDate),
        (this.startTime = allData.data[0].startTime),
        (this.endTime = allData.data[0].endTime),
        (this.estimateDuration = allData.data[0].estimateDuration),
        (this.priority = allData.data[0].priority),
        (this.severity = allData.data[0].severity),
        (this.jobStatus = allData.data[0].jobStatus),
        (this.staffList = allData.data[0].allStaffList)
    },

    commitChanges() {
      if(this.jobStatus == "Finished")
        this.status = "Normal";
      else
        this.status = "Down";

      return axios
        .post("//localhost:80/MachineMaintenance/public/api/job/submit", {
          actionType: this.actionType,
          jobId: this.jobId,
          jobType: this.jobType,
          date: this.startDate,
          startTime: this.startTime,
          endDate: this.endDate,
          endTime: this.endTime,
          estimateDuration: this.estimateDuration,
          machineId: this.machineId,
          details: this.details,
          priority: this.priority,
          severity: this.severity,
          jobStatus: this.jobStatus,
          status: this.status,
          staff: this.staff
        })
        .then(response => response.data)
        .catch(error => console.log(error));
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

    resetAllFields() {
      (this.jobId = null),
        (this.machineId = null),
        (this.jobType = null),
        (this.staff = null),
        (this.details = null),
        (this.startDate = null),
        (this.endDate = null),
        (this.startTime = null),
        (this.endTime = null),
        (this.estimateDuration = null),
        (this.priority = null),
        (this.severity = null),
        (this.jobStatus = null),
        (this.staffList = null),
        (this.status = null);
    },
    validate() {
      if (this.$refs.JobAssignmentForm.validate()) {
        this.commitChanges().then(response => {
          if(response == 11)
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