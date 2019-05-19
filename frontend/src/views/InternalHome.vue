<template>
  <v-container grid-list-md fill-height>
    <v-layout align-start justify-start fill-height wrap>
      <v-flex>
        <h1>Welcome back, {{name}}!</h1>
        <h2>Select menu on the left to get started.</h2>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    name: ""
  }),

  created: async function() {
  let staffName = await axios.get("//localhost:80/MachineMaintenance/public/api/staff/getName/"+this.$root.authInfo.userId, {
  });
  let custrName = await axios.get("//localhost:80/MachineMaintenance/public/api/customer/getName/"+this.$root.authInfo.userId, {
  });

  if(!staffName.data && custrName.data)
    this.name = custrName.data;
  else if(staffName.data && !custrName.data)
    this.name = staffName.data;
  else
    this.name = null;
  }
};
</script>
