<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12">
                <v-form class="custom-form shadow1 white rounded px-4 py-5 mb-5" @submit.prevent="getPaymentRecord">
                    <v-row dense>
                        <v-col cols="2">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="3">Type</v-col>
                                <v-col cols="9">
                                    <v-combobox 
                                        v-model="searchType"
                                        dense
                                        outlined
                                        hide-details
                                        :items="['All', 'By Month', 'By Employee']"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="3"  v-if="searchType == 'By Month'">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Month</v-col>
                                <v-col cols="8">
                                    <v-combobox 
                                        dense
                                        outlined
                                        hide-details
                                        v-model="month"
                                        @focus="$store.dispatch('month/getMonths')"
                                        :items="$store.getters['month/months']"
                                        :loading="$store.getters['month/loading']"
                                        item-text="name"
                                        item-value="id"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="3"  v-if="searchType == 'By Employee'">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Employee</v-col>
                                <v-col cols="8">
                                    <v-combobox 
                                        dense
                                        outlined
                                        hide-details
                                        v-model="employee"
                                        @focus="$store.dispatch('employee/getEmployees')"
                                        :items="$store.getters['employee/employees']"
                                        item-text="display_text"
                                        item-value="id"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="5">
                            <v-row no-gutters>
                                <v-col cols="6">
                                    <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                        <v-col cols="4">Date From</v-col>
                                        <v-col cols="8">
                                            <v-menu>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="filter.dateFrom"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                    >
                                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="filter.dateFrom"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="6">
                                    <v-row class="pl-3" no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                        <v-col cols="4">Date To</v-col>
                                        <v-col cols="8">
                                            <v-menu>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="filter.dateTo"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                    >
                                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="filter.dateTo"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="1" class="d-flex align-center">
                            <v-btn type="submit" class="text_bg_fave" :loading="loading">Search</v-btn>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                </v-form>
            </v-col>
        </v-row>
        <v-row no-gutters class="py-2">
            <!-- <v-col cols="12">
                <v-btn height="26px" @click.prevent="print" class="mb-2" v-if="$store.getters['customer/customers'].length != 0">Print</v-btn>
            </v-col> -->
            <v-col cols="12" id="printContent">
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Date</th>
                                <th>Employee Id</th>
                                <th>Employee Name</th>
                                <th>Payment Type</th>
                                <th>Month</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(salary, ind) in $store.getters['salaryPayment/payments']" :key="ind">
                                <td>{{ ind + 1}}</td>
                                <td>{{ salary.date}}</td>
                                <td>{{ salary.employee.emp_id}}</td>
                                <td>{{ salary.employee.name}}</td>
                                <td>{{ salary.type}}</td>
                                <td>{{ salary.month.name}}</td>
                                <td>{{ salary.note}}</td>
                                <td>{{ salary.amount}}</td>
                                
                            </tr>
                            <tr v-if="$store.getters['salaryPayment/payments'].length > 0">
                                <td colspan="7" style="text-align:right">Total</td>
                                <td>{{ $store.getters['salaryPayment/payments'].reduce((p, c) => {return +p + +c.amount}, 0).toFixed(2) }}</td>
                            </tr>
                            <tr v-if="$store.getters['salaryPayment/payments'].length == 0">
                                <td colspan="8" class="text-center">Salary Payment information is not available</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'SalaryPayments',

    data: () => ({
        searchType: '',
        month: null,
        employee: null,
        filter: {
            monthId: null,
            employeeId: null,
            dateFrom: new Date().toISOString().substr(0, 10),
            dateTo: new Date().toISOString().substr(0, 10),
        },
        loading: false
    }),

    watch: {
        month(month) {
            if(month == undefined) return;
            this.filter.monthId = month.id;
        },

        employee(employee) {
            if(employee == undefined) return;
            this.filter.employeeId = employee.id;
        }
    },

    methods: {
        async getPaymentRecord() {
            if(this.searchType != 'By Month') {
                this.filter.monthId = null;
            }
            if(this.searchType != 'By Employee') {
                this.filter.employeeId = null;
            }

            this.loading = true;
            await this.$store.dispatch('salaryPayment/getPayments', this.filter)
            this.loading = false;
        }
    }
}
</script>

<style lang="scss" scoped>
    .v-icon.v-icon {
       font-size: 18px !important;
       top: 3px !important;
    }
   .theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {
        font-size: 11px;
        padding: 0px 1px;
        // background: #061e95;
        // color: #fff;
        background: var(--theme_lighter);
        // border: 1px solid #ccc;
        text-align: center;
        // height: 24px !important;
    }
    .v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > td {
        // height: 20px !important;
        padding: 0px 5px !important;
        font-size: 12px !important;
        border: 1px solid #ccc !important;
        text-align: center;
    }
</style>