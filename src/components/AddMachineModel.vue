<template>
  <div class="text-xs-center">
    <v-menu v-model="menu" :close-on-content-click="false" offset-y>
      <template v-slot:activator="{ on }">
        <v-btn block v-on="on">Add new machine model</v-btn>
      </template>

      <v-card>
        <v-list-tile-action>
          <v-layout justify-center>
            <v-flex xs9>
              <v-text-field v-model="ModelNumber" type="text" label="Model Number" required></v-text-field>
              <v-select :items="typeList" label="Machine type" required></v-select>
            </v-flex>
          </v-layout>
        </v-list-tile-action>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn flat @click="menu = false">Cancel</v-btn>
          <v-btn color="primary" flat @click="menu = false">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-menu>
  </div>
</template>

<script>
export default {
  data: () => ({
    menu: false,

    typeList: ["Pump", "Boiler", "Other"]
  })
};
</script>
