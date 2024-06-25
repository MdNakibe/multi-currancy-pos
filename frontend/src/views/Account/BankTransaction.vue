<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12">
                <v-form ref="bankTransactionForm" @submit.prevent="saveBankTransaction" class="custom-form shadow1 white rounded mb-4">
                    <v-card :elevation="0" color="">
                        <v-row no-gutters>
                            <v-col cols="12">
                                <v-toolbar :elevation="0">
                                    <v-toolbar-title class="subtitle-1">Bank Transaction Entry</v-toolbar-title>
                                </v-toolbar>
                                <v-card-text class="py-0 pb-5 mt-1">
                                    <v-row dense>
                                        <v-col cols="12" md="4">
                                            <v-row no-gutters class="mb-1 align-center">
                                                <v-col cols="3">Tnx. Id</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        readonly
                                                        v-model="bankTransaction.code"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1 align-center">
                                                <v-col cols="3">Tnx. Type</v-col>
                                                <v-col cols="9">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :items="['Deposit', 'Withdraw']"
                                                        v-model="bankTransaction.type"
                                                        :rules="[v => !!v]"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1 align-center">
                                                <v-col cols="3">Account</v-col>
                                                <v-col cols="9">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        item-text="display_text"
                                                        item-value="id"
                                                        @focus="$store.dispatch('bankAccount/getBankAccounts')"
                                                        :loading="$store.getters['bankAccount/loadingBankAccount']"
                                                        :items="$store.getters['bankAccount/accounts']"
                                                        v-model="selectedBank"
                                                        :rules="[v => !!v]"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-row no-gutters class="mb-1 align-center"> 
                                                <v-col cols="3" class="text-right pr-3">Tnx. Date</v-col>
                                                <v-col cols="9">
                                                    <v-menu
                                                        v-model="menu"
                                                        :close-on-content-click="false"
                                                        :nudge-right="0"
                                                        transition="scale-transition"
                                                        offset-y
                                                        min-width="auto"
                                                    >
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-text-field
                                                                dense
                                                                outlined
                                                                hide-details
                                                                v-model="bankTransaction.date"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                                autocomplete="off"
                                                            >
                                                                <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                            </v-text-field>
                                                        </template>
                                                        <v-date-picker
                                                            v-model="bankTransaction.date"
                                                            @input="menu = false"
                                                            @change="getTransactions"
                                                        >
                                                        </v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1 align-center">
                                                <v-col cols="3" class="text-right pr-3">Description</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="bankTransaction.note"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1 align-center">
                                                <v-col cols="3" class="text-right pr-3">Amount</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.number="bankTransaction.amount"
                                                        :rules="[v => !!v]"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="3"></v-col>
                                                <v-col cols="9">
                                                    <v-row no-gutters>
                                                        <v-col cols="6" class="pr-1">
                                                            <v-btn type="submit" :loading="loading" block color="text_bg_fave">Save</v-btn>
                                                        </v-col>
                                                        <v-col cols="6">
                                                            <v-btn @click="resetForm" block dark color="deep-orange">Clear</v-btn>
                                                        </v-col>
                                                    </v-row>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-row no-gutters justify="center">
                                                <v-col cols="7">
                                                    <v-card class="d-flex justify-center">
                                                        <fieldset class="current__balance">
                                                            <legend>Current Balance</legend>
                                                            <div class="content">
                                                                <div class="amount">{{ $store.getters['bankTransaction/currentBalance'].toFixed(2) }}</div>
                                                                <div class="currency">DBT</div>
                                                            </div>
                                                        </fieldset>
                                                    </v-card>
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
            <v-col cols="12" class="pb-4 px-4 shadow1 white rounded">
                <v-data-table
                    class="custom-data-table"
                    :headers="transactionHeaders"
                    :loading="$store.getters['bankTransaction/loadingTransaction']"
                    :items="$store.getters['bankTransaction/transactions']"
                    :search="searchBankTransactions"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0">
                            <v-toolbar-title class="subtitle-1">Bank Transaction List</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search Bank Transaction"
                                    append-icon="mdi-magnify"
                                    style="width:300px;"
                                    v-model="searchBankTransactions"
                                >
                                </v-text-field>
                            </v-form>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }" v-if="userType == 'super_admin' || userType == 'admin'">
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="editBankTransaction(item)" color="primary" v-on="on">mdi-circle-edit-outline</v-icon>
							</template>
							<span>Edit</span>
						</v-tooltip>
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="deleteId = item.id;$refs.confirmDialog.dialog = true" color="error" v-on="on">mdi-delete-circle-outline</v-icon>
							</template>
							<span>Delete</span>
						</v-tooltip>
					</template>
                </v-data-table>
            </v-col>
        </v-row>

        <delete-confirm ref="confirmDialog" @confirm="deleteTransaction"></delete-confirm>

    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";

export default {
    name: 'BankTransaction',

    components: {
        'delete-confirm': confirmDialog,
    },

    data: ()=> ({
        menu: false,
        transactionHeaders: [
            { text: 'Tnx. Date', value: 'date' },
            { text: 'Acc Name', value: 'bank.account_name' },
            { text: 'Acc Number', value: 'bank.account_number' },
            { text: 'Bank Name', value: 'bank.bank_name' },
            { text: 'Tnx. Type', value: 'type' },
            { text: 'Description', value: 'note' },
            { text: 'Amount', value: 'amount' },
            { text: 'Saved By', value: 'added_by.name' },
            { text: 'Action', value: 'action' },
        ],
        searchBankTransactions: '',
        selectedBank: null,
        bankTransaction: {
            id: null,
            code: '',
            date: new Date().toISOString().slice(0, 10),
            type: '',
            account_id: '',
            amount: 0,
            note: '',
        },
        loading: false,
        bankTransactionEditId: null,
        deleteId: null,
        userType: ''
    }),

    watch: {
        selectedBank(bank) {
            if(bank == undefined) return;
            this.bankTransaction.account_id = bank.id
            if (bank == null) {
                this.$store.commit('bankTransaction/setCurrentBalance', 0)
                return
            }
            this.$store.dispatch('bankTransaction/getCurrentBalance', {accountId: bank.id})
        }
    },

    async created() {
        this.bankTransaction.code = await this.$store.dispatch('bankTransaction/generateTransactionCode')
        await this.getTransactions();
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;
    },

    methods: {
        async getTransactions() {
            let filter = {
                dateFrom: this.bankTransaction.date,
                dateTo: this.bankTransaction.date
            }
            await this.$store.dispatch('bankTransaction/getTransactions', filter) 
        },

        async saveBankTransaction() {
            if (!this.$refs.bankTransactionForm.validate()) return;

            if(this.selectedBank == null) {
                this.$store.dispatch('snackbar/error', 'Select a bank account');
                return;
            }

            if(this.bankTransaction.type == '') {
                this.$store.dispatch('snackbar/error', 'Select a type');
                return;
            }

            if(this.bankTransaction.amount == 0) {
                this.$store.dispatch('snackbar/error', 'Balance amount is required');
                return;
            }

            if(this.bankTransaction.type == 'Withdraw' && +this.bankTransaction.amount > +this.$store.getters['bankTransaction/currentBalance']) {
                this.$store.dispatch('snackbar/error', 'Currently bank balance is insufficient');
                return;
            }

            this.loading = true
            let isSuccess = await this.$store.dispatch('bankTransaction/saveTransaction', this.bankTransaction)
            if(isSuccess) {
                await this.getTransactions();
                this.resetForm();
            }
            this.loading = false
        },

        editBankTransaction(item) {
            Object.keys(this.bankTransaction).map(k => this.bankTransaction[k] = item[k])
            this.selectedBank = item.bank;
            this.selectedBank.display_text = `${item.bank.account_name} - ${item.bank.account_number} - ${item.bank.bank_name}`;
        },

        async deleteTransaction() {
            await this.$store.dispatch('bankTransaction/deleteTransaction', this.deleteId)
            await this.getTransactions();
            this.$refs.confirmDialog.dialog = false;
        },

        resetForm() {
            this.bankTransaction.id = null;
            this.bankTransaction.date = new Date().toISOString().slice(0, 10)
            this.bankTransaction.type = ''
            this.bankTransaction.amount = 0
            this.bankTransaction.note = ''
            this.selectedBank = null
            this.$refs.bankTransactionForm.resetValidation()
            this.$store.commit('bankTransaction/setCurrentBalance', 0)
        }
    }
}
</script>

<style lang="scss" scoped>
    .v-icon.v-icon {
       font-size: 18px !important;
       top: 3px !important;
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
    .current__balance {
        width: 100%;
        margin: 3px 10px 5px;
        padding: 0 5px;
        .content {
            text-align: center;
            font-size: 18px;
            .currency {
                margin: 5px 0;
                font-size: 22px;
            }
            .amount {
                margin-bottom: 2px;
            }
        }
    }
</style>