<template>
    <v-container>
        <v-layout align-center justify-center>
            <v-flex xs3>
                <v-form ref="loginForm" v-model="valid" lazy-validation>
                    <v-text-field v-model="username" type="text" :counter="20" :rules="usernameRules" label="Username" required></v-text-field>
                    <v-text-field v-model="password" type="password" :counter="20" :rules="passwordRules" label="Password" required></v-text-field>
                    <v-btn @click="validate">Login</v-btn>
                </v-form>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    data: () => ({
        valid: true,
        username: '',
        usernameRules: [
            v => !!v || 'Username cannot be blank',
            v => (v && v.length <= 20) || 'Maximum length is 20 characters'
        ],

        password: '',
        passwordRules: [
            v => !!v || 'Password cannot be blank',
            v => (v && v.length <= 20) || 'Maximum length is 20 characters'
        ]
    }),

    methods: {
        validate() {
            if(this.$refs.loginForm.validate()) {
                alert("OK! Logged in as " + this.username);
            }
            else {
                alert("Error!");
            }
        }
    }
}
</script>

