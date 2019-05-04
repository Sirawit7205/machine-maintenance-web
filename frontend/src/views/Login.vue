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
            <v-btn @click="validate">Login</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    username: "",
    usernameRules: [
      v => !!v || "Username cannot be blank",
      v => (v && v.length <= 20) || "Maximum length is 20 characters"
    ],

    password: "",
    passwordRules: [
      v => !!v || "Password cannot be blank",
      v => (v && v.length <= 20) || "Maximum length is 20 characters"
    ]
  }),

  methods: {
    validate() {
      if (this.$refs.loginForm.validate()) {
        alert("OK! Logged in as " + this.username);
      }
    }
  }
};
</script>
