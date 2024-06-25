<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12">
                <v-form
                    ref="profileSettingForm"
                    @submit.prevent="saveProfileSetting"
                    class="custom-form"
                >
                    <v-card color="white shadow1 rounded">
                        <v-row no-gutters>
                        <v-col cols="12">
                            <v-toolbar :elevation="0">
                            <v-toolbar-title class="subtitle-1"
                                >Profile Setting</v-toolbar-title
                            >
                            </v-toolbar>
                            <v-card-text class="py-2 mt-1">
                            <v-row dense justify="center">
                                <v-col cols="4">
                                <v-row no-gutters class="mb-1">
                                    <v-col cols="4" class="text-right pr-4">Name</v-col>
                                    <v-col cols="8">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        :rules="[v => !!v]"
                                        v-model.trim="profile.name"
                                    ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row no-gutters class="mb-1">
                                    <v-col cols="4" class="text-right pr-4">Username</v-col>
                                    <v-col cols="8">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        :rules="[v => !!v]"
                                        v-model.trim="profile.username"
                                    ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row no-gutters class="mb-1">
                                    <v-col cols="4" class="text-right pr-4">E-Mail</v-col>
                                    <v-col cols="8">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        v-model.trim="profile.email"
                                    ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row no-gutters class="mb-1">
                                    <v-col cols="4" class="text-right pr-4">Phone</v-col>
                                    <v-col cols="8">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        v-model.trim="profile.phone"
                                    ></v-text-field>
                                    </v-col>
                                </v-row>
                                </v-col>
                                <v-col cols="5">
                                <v-row no-gutters class="mb-1">
                                    <v-col cols="5" class="text-right pr-4"
                                    >Current Password</v-col
                                    >
                                    <v-col cols="7">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        v-model.trim="password.currentPassword"
                                        type="password"
                                    ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row no-gutters class="mb-1">
                                    <v-col cols="5" class="text-right pr-4"
                                    >New Password</v-col
                                    >
                                    <v-col cols="7">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        v-model.trim="password.newPassword"
                                        type="password"
                                    ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row no-gutters class="mb-1">
                                    <v-col cols="5" class="text-right pr-4"
                                    >Confirm Password</v-col
                                    >
                                    <v-col cols="7">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        v-model.trim="password.confirmPassword"
                                        type="password"
                                    ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row no-gutters>
                                    <v-col cols="5"></v-col>
                                    <v-col cols="7">
                                    <v-row no-gutters>
                                        <v-col cols="6" class="pr-1">
                                            <v-btn
                                                type="submit"
                                                :loading="loading"
                                                dark
                                                block
                                                class="text_bg_fave"
                                                >Save</v-btn
                                            >
                                        </v-col>
                                        
                                        <v-col cols="6">
                                        <v-btn
                                            @click="resetForm"
                                            dark
                                            block
                                            color="deep-orange"
                                            >Clear</v-btn
                                        >
                                        </v-col>
                                    </v-row>
                                    </v-col>
                                </v-row>
                                </v-col>
                            </v-row>
                            </v-card-text>
                        </v-col>
                        </v-row>
                    </v-card>
                </v-form>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'ProfileSetting',

    data: () => ({
        profile: {
            name: "",
            username: "",
            email: "",
            phone: ""
        },
        password: {
            currentPassword: "",
            newPassword: "",
            confirmPassword: ""
        },
        loading: false,
        userId: null
    }),

    async created() {
        let user = JSON.parse(localStorage.getItem('userData'))
        this.userId = user.userId;

        await this.$store.dispatch('user/getUsers', {id: this.userId})
        let userData = this.$store.getters['user/users'][0]

        Object.keys(this.profile).map(k => (this.profile[k] = userData[k]));
    },

    methods: {
        async saveProfileSetting() {
            if (!this.$refs.profileSettingForm.validate()) return;

            if(this.password.newPassword != '' && this.password.newPassword.length < 6) {
                this.$store.dispatch("snackbar/error", "Password must be at least 6 characters long");
                return ;
            }

            if (this.password.newPassword && this.password.confirmPassword == "") {
                this.$store.dispatch("snackbar/error", "Confirm password is required");
                return;
            }

            if (this.password.newPassword != this.password.confirmPassword) {
                this.$store.dispatch("snackbar/error","New password & Confirm password didn't match");
                return;
            }

            if (this.password.newPassword && this.password.confirmPassword && this.password.currentPassword == "") {
                this.$store.dispatch("snackbar/error", "Current password is required");
                return;
            }

            this.loading = true;

            let userData = { ...this.profile };
            userData.id = this.userId;

            if (this.password.confirmPassword != "") {
                userData.currentPassword = this.password.currentPassword;
                userData.password = this.password.confirmPassword;
            }

            let res = await this.$store.dispatch("user/userProfileUpdate", userData);
            if (res) {
                Object.keys(this.password).map(k => (this.password[k] = ""));
                // this.$store.dispatch("user/getCurrentUser");
            }
            this.loading = false;
        },

        resetForm() {
            Object.keys(this.profile).map(k => (this.profile[k] = ""));
            Object.keys(this.password).map(k => (this.password[k] = ""));
            this.$refs.profileSettingForm.resetValidation();
        }
    }
}
</script>

<style>

</style>