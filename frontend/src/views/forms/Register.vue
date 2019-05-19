<template>
  <v-container fill-height>
    <v-layout align-center justify-center fill-height>
      <v-flex lg4 sm9>
        <div class="headline mb-1">
          Register
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
                v-model="name"
                type="text"
                :counter="100"
                :rules="nameRules"
                label="Company name"
                required
              ></v-text-field>
              <v-text-field
                v-model="address"
                type="text"
                :counter="100"
                :rules="addressRules"
                label="Company Address"
                required
              ></v-text-field>
              <v-text-field
                v-model="phone"
                type="text"
                :counter="20"
                :rules="phoneRules"
                label="Phone"
                required
              ></v-text-field>
              <v-text-field
                v-model="email"
                type="text"
                :counter="50"
                :rules="emailRules"
                label="Email"
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
              <v-text-field
                v-model="cfmPassword"
                type="password"
                :counter="20"
                :rules="passwordRules"
                label="Confirm Password"
                required
              ></v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn @click="validate">Register</v-btn>
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
export default {
  data: () => ({
    valid: true,
    snackbarActivate: false,
    snackbarMode: null,
    snackbarMessage: null,

    username: "",
    usernameRules: [
      v => !!v || "Username cannot be blank",
      v => (v && v.length <= 20) || "Maximum length is 20 characters"
    ],

    name: "",
    nameRules: [
      v => !!v || "Name cannot be blank",
      v => (v && v.length <= 100) || "Maximum length is 100 characters"
    ],

    address: "",
    addressRules: [
      v => !!v || "Address cannot be blank",
      v => (v && v.length <= 100) || "Maximum length is 100 characters"
    ],

    phone: "",
    phoneRules: [
      v => !!v || "Phone cannot be blank",
      v => (v && v.length <= 20) || "Maximum length is 20 characters"
    ],
    
    email: "",
    emailRules: [
      v =>
        /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
        !v ||
        "Please enter a valid email address",
      v => (v.length <= 50) || "Maximum length is 50 characters"
    ],

    password: "",
    cfmPassword: "",
    passwordRules: [
      v => !!v || "Password cannot be blank",
      v => (v && v.length >= 8 && v.length <= 20) || "Password length must be 8-20 characters"
    ]
  }),

  methods: {
    openSnackbar(mode, message) {
    this.snackbarMode = mode;
    this.snackbarMessage = message;
    this.snackbarActivate = true;
    },

    validate() {
      if(this.password != this.cfmPassword) {
        this.openSnackbar("error", "Password not matched");
      } else if (this.$refs.loginForm.validate()) {
        this.openSnackbar("success", "Sucessfully registered");
      } else {
        this.openSnackbar("error", "An error had occured, please try again.");
      }
    }
  }
};
</script>
