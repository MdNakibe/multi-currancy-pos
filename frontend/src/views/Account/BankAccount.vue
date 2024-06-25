<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12">
                <v-form ref="bankAccountForm" @submit.prevent="saveBankAccount" class="custom-form">
                    <v-card class="white shadow1 rounded mb-4 pb-4">
                        <v-row no-gutters>
                            <v-col cols="12">
                                <v-toolbar :elevation="0">
                                    <v-toolbar-title class="subtitle-1">Bank Account Information</v-toolbar-title>
                                </v-toolbar>
                                <v-card-text class="py-0 mt-1">
                                    <v-row dense justify="center">
                                        <v-col cols="4">
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Acct. Name</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        v-model="account.account_name"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Acct. No</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        v-model="account.account_number"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Acct. Type</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        v-model="account.account_type"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Bank Name</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        v-model="account.bank_name"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col cols="5">
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4" class="text-right pr-2">Branch Name</v-col>
                                                <v-col cols="7">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="account.branch_name"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4" class="text-right pr-2">Initial Balance</v-col>
                                                <v-col cols="7">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.number="account.initial_balance"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4" class="text-right pr-2">Description</v-col>
                                                <v-col cols="7">
                                                    <v-textarea
                                                        dense
                                                        outlined
                                                        hide-details
                                                        height="8vh"
                                                        v-model="account.description"
                                                    ></v-textarea>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4"></v-col>
                                                <v-col cols="7">
                                                    <v-row no-gutters>
                                                        <v-col cols="6">
                                                            <v-btn type="submit" :loading="loading" dark block color="text_bg_fave">Save</v-btn>
                                                        </v-col>
                                                        <v-col cols="6" class="pl-1">
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
                    class="custom-data-table white shadow1 rounded px-4 py-4"
                    :headers="accountHeaders"
                    :loading="$store.getters['bankAccount/loading']"
                    :items="$store.getters['bankAccount/accounts']"
                    :search="searchBankAccounts"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0">
                            <v-toolbar-title class="subtitle-2">Bank Account List</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search Bank Account"
                                    append-icon="mdi-magnify"
                                    style="width:300px;"
                                    v-model="searchBankAccounts"
                                >
                                </v-text-field>
                            </v-form>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.status`]="{ item }" v-if="userType == 'super_admin' || userType == 'admin'">
                        <span v-if="item.status">Active</span>
                        <span v-if="!item.status">Inactive</span>
                    </template>
                    <template v-slot:[`item.action`]="{ item }">
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="editBankAccount(item)" color="primary" v-on="on">mdi-circle-edit-outline</v-icon>
							</template>
							<span>Edit</span>
						</v-tooltip>
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="deleteId = item.id;$refs.confirmDialog.dialog = true" color="error" v-on="on" >mdi-delete-circle-outline</v-icon>
							</template>
							<span>Delete</span>
						</v-tooltip>
					</template>
                </v-data-table>
            </v-col>
        </v-row>

        <delete-confirm ref="confirmDialog" @confirm="deleteBankAccount"></delete-confirm>

    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";

export default {
    name: 'BankAccount',

    components: {
        'delete-confirm': confirmDialog,
    },

    data: ()=> ({
        date: new Date().toISOString().substr(0, 10),
        accountHeaders: [
            { text: 'Account Name', value: 'account_name' },
            { text: 'Account Number', value: 'account_number' },
            { text: 'Account Type', value: 'account_type' },
            { text: 'Bank Name', value: 'bank_name' },
            { text: 'Branch Name', value: 'branch_name' },
            { text: 'Initial Balance', value: 'initial_balance' },
            { text: 'Status', value: 'status' },
            { text: 'Action', value: 'action' },
        ],
        searchBankAccounts: '',
        account: {
            id: null,
            account_name: '',
            account_number: '',
            account_type: '',
            bank_name: '',
            branch_name: '',
            initial_balance: 0,
            description: '',
        },
        loading: false,
        deleteId: null,
        userType: ''
    }),

    created() {
        this.$store.dispatch('bankAccount/getBankAccounts')
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;
    },

    methods: {
        async saveBankAccount() {
            if (!this.$refs.bankAccountForm.validate()) return

            this.loading = true

            let isSuccess = await this.$store.dispatch('bankAccount/saveBankAccount', this.account);
			if(isSuccess) {
                this.resetForm();
			}

            this.loading = false
        },

        editBankAccount(item) {
            Object.keys(this.account).map(key => this.account[key] = item[key])
        },

        deleteBankAccount() {
            this.$store.dispatch('bankAccount/deleteBankAccount', this.deleteId)
            this.$refs.confirmDialog.dialog = false;
        },

        resetForm() {
            Object.keys(this.account).map(k => {
                if (k == 'initial_balance') this.account[k] = 0
                else this.account[k] = ''
            })
            this.$refs.bankAccountForm.resetValidation()
        }
    }
}
</script>

<style lang="scss" scoped>
    .v-icon.v-icon {
       font-size: 18px !important;
       top: 0 !important;
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