<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg9 sm12>
        <div class="headline mb-1">Add log data</div>
        <v-card>
          <v-card-text>
            <v-form ref="StaffForm" v-model="valid" lazy-validation>
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
                  <v-select :items="subLogTypeList" label="Sub-log type" required></v-select>
                  <v-autocomplete label="Machine" placeholder="Search..."></v-autocomplete>
                  <v-textarea v-model="Details" label="Log details" required></v-textarea>
                  <DatePicker v-if="logType === 'case'" label="Expected repair date"/>
                  <TimePicker v-if="logType === 'case'" label="Expected repair time"/>
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
import TimePicker from "../components/TimePicker.vue";

export default {
  components: {
    DatePicker,
    TimePicker
  },

  data: () => ({
    valid: true,

    logTypeList: [
      { label: "Case report", value: "case" },
      { label: "Machine log", value: "mach" },
      { label: "Operation log", value: "main" }
    ],
    subLogTypeList: [
      "Error",
      "Warning",
      "Info",
      "Maintenance",
      "Repair",
      "Other"
    ],

    positionList: ["Manager", "Supervisor", "Technician", "Call center"],
    statusList: ["Idle", "On Site", "On job", "Vacation", "Sick"],

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
