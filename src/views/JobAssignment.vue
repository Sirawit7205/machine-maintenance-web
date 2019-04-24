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
              <p class="text-xs-center">If Not Existed</p>Add New Assignment:
              <v-btn block>Add Assignment</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex md3>
        <div class="headline mb-1">Job Assignment</div>
        <v-card>
          <v-card-text>
            <v-form ref="JobAssignmentForm" v-model="valid" lazy-validation>
              <v-layout row>
                <v-flex md10>
                  <v-text-field v-model="JobID" type="text" label="Job ID" required disabled></v-text-field>
                  <v-text-field v-model="MachineID" type="text" label="Machine ID" required></v-text-field>
                  <v-text-field v-model="Jobtype" type="text" label="Job Type" required></v-text-field>
                  <v-text-field v-model="AddStaff" type="text" label="Add Staff" required></v-text-field>
                  <v-textarea v-model="JobDetails" type="text" label="Job Details"></v-textarea>
                  <DatePicker label="Start Date"/>
                  <DatePicker label="Start Time"/>
                  <v-text-field v-model="Duration" type="number" label="Estimate Duration" required></v-text-field>
                  <v-select :items="PriorityList" label="Priority" required></v-select>
                  <v-select :items="SeverityList" label="Severity" required></v-select>
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