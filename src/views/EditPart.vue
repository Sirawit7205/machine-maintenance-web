<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg3>
        <div class="headline mb-1">Add or Edit Part</div>
        <v-card>
          <v-card-text>
            <v-form ref="StaffSrcAdd" v-model="valid" lazy-validation>
              Search For Existing Part:
              <v-autocomplete placeholder="Search..."></v-autocomplete>
              <p class="text-xs-center">If Not Existed</p>Add New Part:
              <br>
              <v-btn block>Add Part</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex xs4>
        <div class="headline mb-1">Add or edit Parts</div>
        <v-card>
          <v-card-text>
            <v-form ref="JobAssignmentForm" v-model="valid" lazy-validation>
              <v-layout row>
                <v-flex md10>
                  <v-text-field v-model="PartsID" type="text" label="Parts ID" required></v-text-field>
                  <v-text-field v-model="PartsName" type="text" label="Parts Name" required></v-text-field>
                  <v-text-field
                    v-model="PricePerUnit"
                    type="number"
                    label="Price Per Unit"
                    required
                  ></v-text-field>
                  <v-textarea v-model="UseInModel" type="text" label="Use In Model" required></v-textarea>
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