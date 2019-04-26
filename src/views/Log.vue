<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg9 sm12>
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
                <v-flex xs9>
                  <p>Log details:</p>
                  <v-select
                    v-model="subLogType"
                    :rules="subLogTypeRules"
                    :items="subLogTypeList"
                    label="Sub-log type"
                  ></v-select>
                  <v-autocomplete
                    v-model="machine"
                    :rules="machineRules"
                    :items="machineList"
                    label="Machine"
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
import DatePicker from "../components/DatePicker.vue";
import TimePicker from "../components/TimePicker.vue";

export default {
  components: {
    DatePicker,
    TimePicker
  },

  data: () => ({
    valid: true,
    success: false,
    error: false,

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

    machine: null,
    machineList: ["A1", "A2"],
    machineRules: [v => !!v || "This field cannot be blank"],

    details: null,
    detailsRules: [v => !!v || "This field cannot be blank"],

    startDate: null,
    startDateRules: [v => !!v || "This field cannot be blank"],

    startTime: null,
    startTimeRules: [v => !!v || "This field cannot be blank"]
  }),

  methods: {
    validate() {
      if (this.$refs.AddLogForm.validate()) {
        this.success = true;
      } else {
        this.error = true;
      }
    }
  }
};
</script>
