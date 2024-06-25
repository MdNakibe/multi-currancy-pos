<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12">
                <v-form ref="userForm" @submit.prevent="saveUser" class="custom-form">
                    <v-card class="shadow1 white rounded mb-5 pb-5 px-3">
                        <v-row no-gutters>
                            <v-col cols="12">
                                <v-toolbar :elevation="0" style="border-bottom: 1px solid #ddd !important;">
                                    <v-toolbar-title class="subtitle-1">Create User</v-toolbar-title>
                                </v-toolbar>
                                <v-card-text class="py-0 mt-1">
                                    <v-row dense justify="center">
                                        <v-col cols="4">
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Full Name</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        v-model.trim="user.name"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Phone</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        v-model.trim="user.phone"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">E-Mail</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="user.email"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Branch</v-col>
                                                <v-col cols="9">
                                                    <v-combobox 
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="branch"
                                                        @focus="$store.dispatch('branch/getBranches')"
                                                        :items="$store.getters['branch/branches']"
                                                        :loading="$store.getters['branch/loading']"
                                                        item-text="name"
                                                        item-value="id"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">User Type</v-col>
                                                <v-col cols="9">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        :items="userTypes"
                                                        item-text="display_text"
                                                        item-value="type"
                                                        v-model="selectedUserType"
                                                        :disabled="selectedUserType == 'super_admin' ? true : false"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3" class="text-right pr-2">Username</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        v-model.trim="user.username"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3" class="text-right pr-2">Password</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[() => !!user.password, validatePassword.length]"
                                                        v-model.trim="user.password"
                                                        type="password"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3" class="text-right pr-2">Re-type</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[() => !!retype || 'Confirm your password', () => user.password == retype || 'Password did not match']"
                                                        v-model.trim="retype"
                                                        type="password"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="3"></v-col>
                                                <v-col cols="9">
                                                    <v-row no-gutters>
                                                        <v-col cols="6" class="pr-1">
                                                            <v-btn type="submit" :loading="waitingForSave" block color="text_bg_fave">Save</v-btn>
                                                        </v-col>
                                                         <v-col cols="6">
                                                            <v-btn @click="resetForm" dark block color="deep-orange">Clear</v-btn>
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
        <v-row dense class="mt-1">
            <v-col cols="12" class="pb-0">
                <v-data-table
                    class="custom-data-table shadow1 px-4 py-4 rounded"
                    :headers="userHeaders"
                    :items="$store.getters['user/users']"
                    :search="searchUser"
                    :loading="$store.getters['user/loadingUser']" 
					loading-text="Loading... Please wait"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0" style="border-bottom: 1px solid #ddd !important;margin-bottom:10px;">
                            <v-toolbar-title class="subtitle-1">User List</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search User"
                                    append-icon="mdi-magnify"
                                    style="width:300px;"
                                    v-model="searchUser"
                                >
                                </v-text-field>
                            </v-form>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }" v-if="userType == 'super_admin' || userType == 'admin'">
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="editUser(item)" color="primary" v-on="on">mdi-circle-edit-outline</v-icon>
							</template>
							<span>Edit</span>
						</v-tooltip>
						<v-tooltip bottom v-if="(item.user_type != 'super_admin')">
							<template v-slot:activator="{ on }">
								<v-icon small @click="userId = item.id;$refs.confirmDialog.dialog = true" color="error" v-on="on">mdi-delete-circle-outline</v-icon>
							</template>
							<span>Delete</span>
						</v-tooltip>
                        <v-tooltip v-if="(item.user_type != 'super_admin' && item.user_type != 'admin')" bottom>
							<template v-slot:activator="{ on }">
								<v-icon @click="openPermissionDialog(item)" small color="#000" v-on="on">mdi-account-key</v-icon>
							</template>
							<span>Permission</span>
						</v-tooltip>
					</template>
                </v-data-table>
            </v-col>
        </v-row>

        <delete-confirm ref="confirmDialog" @confirm="deleteUser"></delete-confirm>
        <user-permission :user="selectedUserForPermission" ref="permissionDialog"></user-permission>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
import userPermission from "../../components/permission-dialog.component.vue";
import utilities from '../../mixins/utility.mixin'

export default {
    name: 'User',

    mixins: [utilities],

    components: {
        'delete-confirm': confirmDialog,
        'user-permission': userPermission,
    },

    data: ()=> ({
        userHeaders: [
            { text: 'SL', value: 'sl' },
            { text: 'Name', value: 'name' },
            { text: 'Username', value: 'username' },
            { text: 'Branch', value: 'branch.name' },
            { text: 'Phone', value: 'phone' },
            { text: 'E-Mail', value: 'email' },
            { text: 'Type', value: 'user_type' },
            { text: 'Action', value: 'action' },
        ],
        searchUser: '',
        userTypes: [
            { display_text: 'Super Admin', type: 'super_admin' },
            { display_text: 'Admin', type: 'admin' },
            { display_text: 'User', type: 'user' },
        ],
        selectedUserType: null,
        user: {
            id: null,
            name: '',
            username: '',
            phone: '',
            email: '',
            password: '',
            branch_id: null,
        },
        waitingForSave: false,
        retype: '',
        userEditId: null,
        userId: null,
        selectedUserForPermission: null,
        branch: null,
        userType: ''
    }),

    watch: {
        branch(branch) {
            if(branch == undefined) return;
            this.user.branch_id = branch.id
        }
    },

    async created() {
        await this.$store.dispatch('user/getUsers');
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;
    },

    methods: {
        async saveUser() {
            if (!this.$refs.userForm.validate()) return
            if(this.branch == null) {
                this.$store.dispatch('snackbar/error', 'Select a branch');
                return;
            }

            this.waitingForSave = true
            
            if (this.selectedUserType != null) this.user.user_type = String(this.selectedUserType.type).toLowerCase();
            
            let success = await this.$store.dispatch('user/saveUser', this.user);
            if(success) {
                this.resetForm();
            }

            this.waitingForSave = false
        },

        editUser(user) {
            this.userEditId = user.id;
            this.userTypes.forEach(el => {
                if (el.type == String(user.user_type).toLowerCase()) 
                this.selectedUserType = el
            })

            Object.keys(this.user).map(k => this.user[k] = user[k])
            this.branch = user.branch
        },

        deleteUser() {
            this.$store.dispatch('user/deleteUser', this.userId);
            this.$refs.confirmDialog.dialog = false
        },
        
        resetForm() {
            this.selectedUserType = null
            Object.keys(this.user).map(k => this.user[k] = '')
            this.userEditId = null
            this.retype = ''
            this.user.id = null;
            this.$refs.userForm.resetValidation()
            this.branch = null;
        },

        validatePhone(v) {
            if (v == '' && this.userEditId == null) return false
            else return true
        },

        openPermissionDialog(user) {
            this.selectedUserForPermission = user
            this.$refs.permissionDialog.dialog = true
        },
    }
}
</script>

<style lang="scss" scoped>
    .v-icon.v-icon {
       font-size: 18px !important;
       top: -3px !important;
    }
    .v-icon.v-icon[data-v-1f38b4e5] {
        font-size: 14px !important;
        top: 0px !important; 
    }
    .v-messages {
        flex: 1 1 auto;
        font-size: 12px;
        min-height: 0px !important;
        max-height: 0px!important;
        min-width: 1px;
        position: relative;
    }
</style>
