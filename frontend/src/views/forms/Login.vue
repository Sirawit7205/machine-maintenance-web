<template>
  <v-container fill-height>
    <v-layout align-center justify-center fill-height>
      <v-flex lg4 sm9>
        <div class="headline mb-1">
          Login
        </div>
        <v-card>
          <v-card-text>
            <v-form ref="loginForm" v-model="valid" lazy-validation>
              <v-text-field
                v-model="username"
                type="text"
                :counter="20"
                :rules="usernameRules"
                label="Username"
                required
              ></v-text-field>
              <v-text-field
                v-model="password"
                type="password"
                :counter="20"
                :rules="passwordRules"
                label="Password"
                required
              ></v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn @click="validate" :loading="loading">Login</v-btn>
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

export default {
  data: () => ({
    valid: true,
    loading: false,

    snackbarMode: "",
    snackbarMessage: "",
    snackbarActivate: false,

    username: "",
    usernameRules: [
      v => !!v || "Username cannot be blank",
      v => (v && v.length <= 20) || "Maximum length is 20 characters"
    ],

    password: "",
    passwordRules: [
      v => !!v || "Password cannot be blank",
      v => (v && v.length >= 8 && v.length <= 20) || "Password length must be 8-20 characters"
    ],

    checkResponse: []
  }),

  methods: {
    checkPassword() {
      return axios.post("//localhost:80/MachineMaintenance/public/api/loginCheck", {
        username: this.username,
        password: this.password
      }).then(response => response.data);
    },

    validate() {
      this.loading = true;
      if (this.$refs.loginForm.validate()) {
        this.checkPassword().then(checkResponse => {
          this.checkResponse = checkResponse

          if(this.checkResponse.authResult == 1) {
            this.openSnackbar("success","Login successfully");

            this.$root.authInfo.authStatus = this.checkResponse.authResult;
            this.$root.authInfo.accessLevel = this.checkResponse.accessLevel;
            this.$root.authInfo.userId = this.checkResponse.userId;

            this.$router.push({ path: "/internalHome"});
          } else {
            this.openSnackbar("error", "Incorrect username or password");
          }

          this.loading = false;
        })
      }
      else {
        this.loading = false;
      }
    },

    openSnackbar(mode, message) {
    this.snackbarMode = mode;
    this.snackbarMessage = message;
    this.snackbarActivate = true;
    }
  }
};
</script>
