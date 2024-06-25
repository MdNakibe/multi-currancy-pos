<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12">
                <v-form ref="cashTransactionForm" @submit.prevent="saveCashTransaction" class="custom-form">
                    <v-card color="white shadow1 rounded mb-4">
                        <v-row no-gutters>
                            <v-col cols="12">
                                <v-toolbar :elevation="0" style="border-bottom: 1px solid #ddd !important;">
                                    <v-toolbar-title class="subtitle-1">Cash Transaction Entry</v-toolbar-title>
                                </v-toolbar>
                                <v-card-text class="py-0 mt-1">
                                    <v-row justify="center">
                                        <v-col cols="4">
                                            <v-row no-gutters class="mb-1 align-center">
                                                <v-col cols="3">Tnx. ID</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        readonly
                                                        v-model="cashTransaction.code"
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
                                                        :rules="[v => !!v]"
                                                        item-text="account_name"
                                                        item-value="id"
                                                        :items="['Cash Receive', 'Cash Payment']"
                                                        v-model="cashTransaction.type"
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
                                                        @focus="$store.dispatch('expense/getExpenses')"
                                                        :loading="$store.getters['expense/loadingExpense']"
                                                        :items="$store.getters['expense/expenses']"
                                                        :rules="[v => !!v]"
                                                        item-text="name"
                                                        item-value="id"
                                                        v-model="selectedAccount"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-row no-gutters class="mb-1 align-center"> 
                                                <v-col cols="3" class="text-right pr-2">Tnx. Date</v-col>
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
                                                                v-model="cashTransaction.date"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                                autocomplete="off"
                                                            >
                                                                <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                            </v-text-field>
                                                        </template>
                                                        <v-date-picker
                                                            v-model="cashTransaction.date"
                                                            @input="menu = false"
                                                            @change="getTransactions"
                                                        >
                                                        </v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1 align-center">
                                                <v-col cols="3" class="text-right pr-2">Description</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="cashTransaction.note"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1 align-center">
                                                <v-col cols="3" class="text-right pr-2">Amount</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        v-model.number="cashTransaction.amount"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="3"></v-col>
                                                <v-col cols="9">
                                                    <v-row no-gutters>
                                                        <v-col cols="6" class="pr-1">
                                                            <v-btn type="submit" :loading="logading" dark block color="text_bg_fave">Save</v-btn>
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
            <v-col cols="12" class="pb-0 shadow1 rounded white">
                <v-data-table
                    class="custom-data-table"
                    :headers="transactionHeaders"
                    :loading="$store.getters['cashTransaction/loadingTransaction']"
                    :items="$store.getters['cashTransaction/transactions']"
                    :search="searchCashTransactions"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0">
                            <v-toolbar-title class="subtitle-1">Cash Transaction List</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search Cash Transaction"
                                    append-icon="mdi-magnify"
                                    style="width:300px;"
                                    v-model="searchCashTransactions"
                                >
                                </v-text-field>
                            </v-form>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }" v-if="userType == 'super_admin' || userType == 'admin'">
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="editCashTransaction(item)" color="primary" v-on="on">mdi-circle-edit-outline</v-icon>
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

        <delete-confirm ref="confirmDialog" @confirm="deleteCashTransaction"></delete-confirm>

    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";

export default {
    name: 'CashTransaction',

    components: {
        'delete-confirm': confirmDialog,
    },

    data: ()=> ({
        transactionHeaders: [
            { text: 'Tnx. ID', value: 'code' },
            { text: 'Account Name', value: 'expense.name' },
            { text: 'Date', value: 'date' },
            { text: 'Description', value: 'note' },
            { text: 'Received Amount', value: 'received_amount' },
            { text: 'Paid Amount', value: 'paid_amount' },
            { text: 'Saved By', value: 'added_by.name' },
            { text: 'Action', value: 'action' },
        ],
        searchCashTransactions: '',
        cashTransaction: {
            id: null,
            code: '',
            type: '',
            account_id: null,
            amount: 0,
            date: new Date().toISOString().slice(0, 10),
            note: '',
        },
        selectedAccount: null,
        logading: false,
        deleteId: null,
        menu: false,
        userType: ''
    }),

    watch: {
        selectedAccount(account) {
            if(account == undefined) return;
            this.cashTransaction.account_id = account.id;
        }
    },

    async created() {
        this.cashTransaction.code = await this.$store.dispatch('cashTransaction/generateTransactionCode')
        await this.getTransactions();
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;

    },

    methods: {
        async getTransactions() {
            let filter = {
                dateFrom: this.cashTransaction.date,
                dateTo: this.cashTransaction.date
            }
            await this.$store.dispatch('cashTransaction/getTransactions', filter)
        },

        async saveCashTransaction() {
            if (!this.$refs.cashTransactionForm.validate()) return

            this.logading = true

            let isSuccess = await this.$store.dispatch('cashTransaction/saveTransaction', this.cashTransaction)
            if(isSuccess) {
                await this.getTransactions();
                this.resetForm();
            }

            this.logading = false
        },

        editCashTransaction(item) {
            Object.keys(this.cashTransaction).map(key => this.cashTransaction[key] = item[key])
            this.selectedAccount = item.expense
            if (item.type == 'Cash Receive') this.cashTransaction.amount = item.received_amount
            if (item.type == 'Cash Payment') this.cashTransaction.amount = item.paid_amount
        },

        async deleteCashTransaction() {
            await this.$store.dispatch('cashTransaction/deleteTransaction', this.deleteId)
            await this.getTransactions();
            this.$refs.confirmDialog.dialog = false;
        },
        
        resetForm() {
            this.selectedAccount = null
            this.cashTransaction.type = ''
            this.cashTransaction.amount = 0
            this.cashTransaction.date = new Date().toISOString().slice(0, 10)
            this.cashTransaction.note = ''
            this.$refs.cashTransactionForm.resetValidation()
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
</style>