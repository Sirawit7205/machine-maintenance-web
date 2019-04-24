<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-center fill-height wrap>
      <v-flex lg3 sm9>
        <div class="headline mb-1">Parts Order And Usage</div>
        <v-card>
          <v-card-text>
            <v-form ref="MachineForm" v-model="valid" lazy-validation>
              <v-layout row>
                <v-flex xs3>
                  <p>Type:</p>
                  <v-radio-group v-model="PartType">
                    <v-radio
                      v-for="mainType in PartTypeList"
                      :key="mainType.label"
                      :label="mainType.label"
                      :value="mainType.value"
                    ></v-radio>
                  </v-radio-group>
                </v-flex>
                <v-flex xs9>
                  <v-text-field v-model="PartsID" type="text" label="PartsID" required></v-text-field>
                  <v-text-field v-model="PartName" type="text" label="Part Name" required></v-text-field>
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
