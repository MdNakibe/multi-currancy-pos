<template>
    <v-container fluid>
         <v-row no-gutters>
            <v-col cols="12">
                <v-form ref="salaryPaymentForm" @submit.prevent="saveSalaryPayment" class="custom-form">
                    <v-card class="white shadow1 rounded mb-4">
                        <v-row no-gutters>
                            <v-col cols="12">
                                <v-toolbar :elevation="0" style="border-bottom: 1px solid #ddd !important;">
                                    <v-toolbar-title class="subtitle-1">Employee Salary Payment</v-toolbar-title>
                                </v-toolbar>
                                <v-card-text class="py-0 mt-1">
                                    <v-row>
                                        <v-col cols="2"></v-col>
                                        <v-col cols="4">
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Payment Type</v-col>
                                                <v-col cols="8">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="payment.type"
                                                        :items="['Cash', 'Bank']"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1" v-if="payment.type == 'Bank'">
                                                <v-col cols="4">Bank Acc.</v-col>
                                                <v-col cols="8">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        @focus="$store.dispatch('bankAccount/getBankAccounts')"
                                                        :loading="$store.getters['bankAccount/loadingBankAccount']"
                                                        :items="$store.getters['bankAccount/accounts']"
                                                        item-text="display_text"
                                                        item-value="id"
                                                        v-model="bank"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Employee</v-col>
                                                <v-col cols="8">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        item-text="display_text"
                                                        item-value="id"
                                                        @focus="$store.dispatch('employee/getEmployees')"
                                                        :loading="$store.getters['employee/loading']"
                                                        :items="$store.getters['employee/employees']"
                                                        v-model="selectedEmployee"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Month</v-col>
                                                <v-col cols="8">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        item-text="name"
                                                        item-value="id"
                                                        @focus="$store.dispatch('month/getMonths')"
                                                        :loading="$store.getters['month/loading']"
                                                        :items="$store.getters['month/months']"
                                                        v-model="selectedMonth"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Payable Amount</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        readonly
                                                        v-model="paymentTotal"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Payment Date</v-col>
                                                <v-col cols="8">
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
                                                                v-model="payment.date"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                                autocomplete="off"
                                                                @change="getPayments"
                                                            >
                                                                <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                            </v-text-field>
                                                        </template>
                                                        <v-date-picker
                                                            v-model="payment.date"
                                                            @input="menu = false"
                                                            @change="getPayments"
                                                        >
                                                        </v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Payment Amount</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        v-model.number="payment.amount"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4">Description </v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="payment.note"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4"></v-col>
                                                <v-col cols="8">
                                                    <v-row dense>
                                                            <v-col cols="6">
                                                                <v-btn type="submit" :loading="loading" block color="text_bg_fave">Save</v-btn>
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
        <v-row class="mt-1">
            <v-col cols="12" class="pb-0">
                <v-data-table
                    class="custom-data-table shadow1 white rounded px-4 py-4"
                    :headers="salaryPaymentHeaders"
                    :loading="$store.getters['salaryPayment/loading']"
                    :items="$store.getters['salaryPayment/payments']"
                    :search="searchSalaryPayments"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0" style="border-bottom: 1px solid #ddd !important;margin-bottom: 20px;">
                            <v-toolbar-title class="subtitle-2">Salary Payment List</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search Salary Payments"
                                    append-icon="mdi-magnify"
                                    style="width:300px;"
                                    v-model="searchSalaryPayments"
                                >
                                </v-text-field>
                            </v-form>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }">
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="editSalaryPayment(item)" color="primary" v-on="on">mdi-circle-edit-outline</v-icon>
							</template>
							<span>Edit</span>
						</v-tooltip>
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="paymentId = item.id;$refs.confirmDialog.dialog = true" color="error" v-on="on" >mdi-delete-circle-outline</v-icon>
							</template>
							<span>Delete</span>
						</v-tooltip>
					</template>
                </v-data-table>
            </v-col>
        </v-row>

        <delete-confirm ref="confirmDialog" @confirm="deleteSalaryPayment"></delete-confirm>
    </v-container>
</template>

<script>
import confirmDialog from '../../components/confirm-dialog.component.vue'
export default {
    name: 'SalaryPayment',

    components: {
        "delete-confirm": confirmDialog
    },

    data: () => ({
        menu: false,
        searchSalaryPayments: '',
        salaryPaymentHeaders: [
            { text: 'Date', value: 'date' },
            { text: 'Employee Id', value: 'employee.emp_id' },
            { text: 'Employee Name', value: 'employee.name' },
            { text: 'Month', value: 'month.name' },
            { text: 'Payment Amount', value: 'amount' },
            { text: 'Description ', value: 'note' },
            { text: 'Action ', value: 'action' },
        ],
        payment: {
            id: null,
            type: '',
            employee_id: null,
            month_id: null,
            date: new Date().toISOString().substr(0, 10),
            amount: 0,
            note: ''
        },
        selectedEmployee: null,
        selectedMonth: null,
        paymentId: null,
        bank: null,
        paymentTotal: 0,
        loading: false,
    }),

    watch: {
        async selectedEmployee(employee) {
            if(employee == undefined) return;
            this.payment.employee_id = employee.id;
            await this.getPaymentSalary();
        },

        async selectedMonth(month) {
            if(month == undefined) return;
            this.payment.month_id = month.id;

            if(this.selectedEmployee == null) {
                this.$store.dispatch('snackbar/error', 'Select an employee');
                return;
            }

            await this.getPaymentSalary();
        },

        bank(bank) {
            if(bank == undefined) return;
            this.payment.account_id = bank.id;
        }
    },

    async created() {
        await this.getPayments();
    },

    methods: {
        async getPayments() {
            let filter = {
                dateFrom: this.payment.date,
                dateTo: this.payment.date
            }

            await this.$store.dispatch('salaryPayment/getPayments', filter)
        },

        async getPaymentSalary() {
            if(this.selectedEmployee != null && this.selectedMonth != null) {
                let data = {
                    employeeId: this.selectedEmployee.id,
                    monthId: this.selectedMonth.id
                }
    
                await this.$store.dispatch('salaryPayment/getSalaryDue', data)
                this.paymentTotal = this.$store.getters['salaryPayment/paymentTotal'];
            }
        },

        async saveSalaryPayment() {
            let valid = this.$refs.salaryPaymentForm.validate()
            if (!valid) return

            if(this.payment.type == '') {
                this.$store.dispatch('snackbar/error', "Select a payment type");
                return;
            }
            
            if(this.payment.type == 'Bank' && this.bank == null) {
                this.$store.dispatch('snackbar/error', "Select a bank");
                return;
            }

            if(this.selectedEmployee == null) {
                this.$store.dispatch('snackbar/error', 'Select an employee');
                return;
            }

            if(this.selectedMonth == null) {
                this.$store.dispatch('snackbar/error', 'Select a month');
                return;
            }

            if(this.payment.amount == 0 || this.payment.amount == null) {
                this.$store.dispatch('snackbar/error', 'Amount is required');
                return;
            }

            if(this.payment.amount > +this.paymentTotal) {
                this.$store.dispatch('snackbar/error', 'Payment amount to much hight');
                return;
            }

            this.loading = true

            let isSuccess = await this.$store.dispatch('salaryPayment/saveSalaryPayment', this.payment)
            if(isSuccess) {
                await this.getPayments()
                this.resetForm();
            }

            this.loading = false
        },

        editSalaryPayment(payment) {
            Object.keys(this.payment).forEach(key => {
                this.payment[key] = payment[key];
            })

            this.selectedEmployee = payment.employee;
            this.selectedEmployee.display_text = `${payment.employee.emp_id} - ${payment.employee.name}`
            this.selectedMonth = payment.month;

            if(payment.bank_account != null) {
                this.bank = payment.bank_account;
                this.bank.display_text = `${payment.bank_account.account_name} - ${payment.bank_account.account_number} - ${payment.bank_account.bank_name}`
            }
        },

        async deleteSalaryPayment() {
            this.$store.dispatch('salaryPayment/deleteSalaryPayment', this.paymentId);
            this.$refs.confirmDialog.dialog = false;
            await this.getPayments();
        },

        resetForm() {
            this.payment.id = null;
            this.payment.amount = 0;
            this.payment.date = new Date().toISOString().substr(0, 10);
            this.payment.note = '';
            this.selectedEmployee = null;
            this.selectedMonth = null;
            this.$refs.salaryPaymentForm.resetValidation();
            this.paymentTotal = 0;
        }
    }
}
</script>

<style lang="scss" scoped>
    .v-icon.v-icon {
       font-size: 18px !important;
       top: 3px;
    }
    .v-file-input .v-text-field__slot {
        min-height: 27px !important;
    }
    .e-image {
        .v-input__prepend-inner {
            margin-top: 0 !important;
        }
    }
</style>