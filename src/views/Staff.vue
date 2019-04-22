<template>
    <v-container fill-height grid-list-md>
        <v-layout align-start justify-end fill-height>
            <v-flex xs3>
                <div class="headline mb-1">
                    Add or edit staff
                </div>
                <v-card>
                    <v-card-text>
                        <v-form ref="StaffForm" v-model="valid" lazy-validation>
                            Search for existing staff:
                            <v-autocomplete placeholder="Search..."></v-autocomplete>
                            <p class="text-md-center">----- OR -----</p>
                            Add new staff: <br />
                            <v-btn block>Add Staff</v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs6>
                <div class="headline mb-1">
                    Staff Info
                </div>
                <v-card>
                    <v-card-text>
                        <v-form ref="StaffForm" v-model="valid" lazy-validation>
                            <v-layout row>
                                <v-flex xs6>
                                    <v-text-field v-model="StaffID" type="text" label="Staff ID" required disabled></v-text-field>
                                    <v-text-field v-model="StaffName" type="text" label="Name and Surname" required></v-text-field>
                                    <v-textarea v-model="Address" label="Address" required></v-textarea>
                                    <v-text-field v-model="Phone" type="number" label="Phone" required></v-text-field>
                                    <v-text-field v-model="Email" type="email" label="Email"></v-text-field>
                                </v-flex>
                                <v-flex xs6>
                                    <v-select :items="positionList" label="Position" required></v-select>
                                    <v-text-field v-model="Salary" type="number" label="Salary" required></v-text-field>
                                    <v-select :items="statusList" label="Status" required></v-select>
                                    <v-text-field v-model="Experience" type="number" label="Experience Points" required></v-text-field>
                                    <v-text-field v-model="VacationTotal" type="number" label="Vacation days total" required></v-text-field>
                                    <v-text-field v-model="VacationLeft" type="number" label="Vacation days left" required></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer />
                        <v-btn @click="validate">Save</v-btn>
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
        username: '',
        usernameRules: [
            v => !!v || 'Username cannot be blank',
            v => (v && v.length <= 20) || 'Maximum length is 20 characters'
        ],

        password: '',
        passwordRules: [
            v => !!v || 'Password cannot be blank',
            v => (v && v.length <= 20) || 'Maximum length is 20 characters'
        ],

        positionList: ["Manager","Supervisor","Technician","Call center"],
        statusList: ["Idle","On Site","On job","Vacation","Sick"]
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

