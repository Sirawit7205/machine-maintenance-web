<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg8 sm12>
        <div class="headline mb-1">Add log data</div>
        <v-card>
          <v-card-text>
            <v-form ref="AddLogForm" v-model="valid" lazy-validation>
              <v-layout row justify-space-around>
                <v-flex xs3>
                  <p>Log type:</p>
                  <v-radio-group v-model="logType">
                    <v-radio
                      v-for="mainType in logTypeList"
                      :key="mainType.label"
                      :label="mainType.label"
                      :value="mainType.value"
                    ></v-radio>
                  </v-radio-group>
                </v-flex>
                <v-flex xs8>
                  <p>Log details:</p>
                  <v-select
                    v-model="subLogType"
                    :rules="subLogTypeRules"
                    :items="subLogTypeList"
                    label="Sub-log type"
                  ></v-select>
                  <v-select
                    v-if="logType === 'mach'"
                    v-model="problemType"
                    :rules="problemTypeRules"
                    :items="problemTypeList"
                    label="Problem type"
                  ></v-select>
                  <v-autocomplete
                    v-if="logType != 'main'"
                    v-model="machine"
                    :rules="machineRules"
                    :items="machineList"
                    item-text="machineId"
                    item-value="machineId"
                    label="Machine"
                    placeholder="Search..."
                  ></v-autocomplete>
                  <v-autocomplete
                    v-if="logType === 'main'"
                    v-model="job"
                    :rules="jobRules"
                    :items="jobList"
                    item-text="jobId"
                    item-value="jobId"
                    label="Job"
                    placeholder="Search..."
                  ></v-autocomplete>
                  <v-textarea v-model="details" :rules="detailsRules" label="Log details"></v-textarea>
                  <DatePicker
                    v-if="logType === 'case'"
                    v-model="startDate"
                    :rules="startDateRules"
                    label="Expected repair date"
                  />
                  <TimePicker
                    v-if="logType === 'case'"
                    v-model="startTime"
                    :rules="startTimeRules"
                    label="Expected repair time"
                  />
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
import axios from "axios";
import DatePicker from "../../components/DatePicker.vue";
import TimePicker from "../../components/TimePicker.vue";

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

    actionType: 0,

    allCount: [],

    logType: "case",
    logTypeList: [
      { label: "Case report", value: "case" },
      { label: "Machine log", value: "mach" },
      { label: "Operation log", value: "main" }
    ],

    subLogType: null,
    subLogTypeList: [
      "Error",
      "Warning",
      "Info",
      "Maintenance",
      "Repair",
      "Other"
    ],
    subLogTypeRules: [v => !!v || "This field cannot be blank"],

    problemType: null,
    problemTypeList: [
      "Sensor",
      "Control",
      "Electrical",
      "Mechanical",
      "Computer",
      "Other"
    ],
    problemTypeRules: [v => !!v || "This field cannot be blank"],

    machine: null,
    machineList: [],
    machineRules: [v => !!v || "This field cannot be blank"],

    job: null,
    jobList: [],
    jobRules: [v => !!v || "This field cannot be blank"],

    details: null,
    detailsRules: [v => !!v || "This field cannot be blank"],

    startDate: null,
    startDateRules: [v => !!v || "This field cannot be blank"],

    startTime: null,
    startTimeRules: [v => !!v || "This field cannot be blank"]
  }),

  methods: {
    openSnackbar(mode, message) {
      this.snackbarMode = mode;
      this.snackbarMessage = message;
      this.snackbarActivate = true;
    },

    commitChanges() {
      return axios
        .post("//localhost:80/MachineMaintenance/public/api/log/submit", {
          newJobId: this.allCount[0].jobCount,
          machLogId: this.allCount[0].mLogCount,
          opLogId: this.allCount[0].oLogCount,
          actionType: this.actionType,
          logType: this.logType,
          subLogType: this.subLogType,
          details: this.details,
          startDate: this.startDate,
          startTime: this.startTime,
          machineId: this.machine,
          jobId: this.job,
          problemType: this.problemType
        })
        .then(response => response.data)
        .catch(error => console.log(error));
    },

    validate() {
      if (this.$refs.AddLogForm.validate()) {
        this.commitChanges().then(response => {
          if(response == 1)
            this.openSnackbar("success", "Insert/Update success");
          else
            this.openSnackbar("error", "Insert/Update error");
        });
      } else {
        this.openSnackbar("error", "Error, please check your input.");
      }
    },

    async refreshData() {
      let machineList = await axios
      .get("//localhost:80/MachineMaintenance/public/api/machine/getCurrentIds", {})
      .then(response => { 
        this.machineList = response.data;
      });

      let jobList = await axios
      .get("//localhost:80/MachineMaintenance/public/api/job/getCurrentIds", {})
      .then(response => { 
        this.jobList = response.data;
      });

      let allCount = await axios
      .get("//localhost:80/MachineMaintenance/public/api/log/count", {})
      .then(response => {
        this.allCount = response.data;
        this.allCount[0].jobCount = "JB" + this.allCount[0].jobCount;
        this.allCount[0].mLogCount = "LM" + this.allCount[0].mLogCount;
        this.allCount[0].oLogCount = "LO" + this.allCount[0].oLogCount;
      });
    }
    
  },

  created: async function() {
    this.refreshData();
  }
};
</script>
