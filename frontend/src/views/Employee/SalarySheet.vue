<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12">
                <v-form class="custom-form shadow1 white rounded py-5 px-4" @submit.prevent="getSalaryRecord">
                    <v-row dense justify="center" class="align-center">
                        <v-col cols="4">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Select Month</v-col>
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
                        <v-col cols="1" class="d-flex align-center">
                            <v-btn type="submit" color="text_bg_fave" :loading="loading">Search</v-btn>
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
                                <th>Employee Id</th>
                                <th>Employee Name</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Basic Salary</th>
                                <th>Month</th>
                                <th>Commission</th>
                                <th>Deduction</th>
                                <th>Advance</th>
                                <th>Others</th>
                                <th>Net Payable</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(salary, ind) in $store.getters['employee/salarySheets']" :key="ind">
                                <td>{{ ind + 1}}</td>
                                <td>{{ salary.employee.emp_id}}</td>
                                <td>{{ salary.employee.name}}</td>
                                <td>{{ salary.employee.department.name}}</td>
                                <td>{{ salary.employee.designation.name}}</td>
                                <td>{{ salary.employee.salary}}</td>
                                <td>{{ salary.month.name}}</td>
                                <td>{{ salary.commission}}</td>
                                <td>{{ salary.deduction}}</td>
                                <td>{{ salary.advance}}</td>
                                <td>{{ salary.others}}</td>
                                <td>{{ salary.total}}</td>
                                
                            </tr>
                            <tr v-if="$store.getters['employee/salarySheets'].length > 0">
                                <td colspan="11" style="text-align:right">Total</td>
                                <td>{{ $store.getters['employee/salarySheets'].reduce((p, c) => {return +p + +c.total}, 0).toFixed(2) }}</td>
                            </tr>
                            <tr v-if="$store.getters['employee/salarySheets'].length == 0">
                                <td colspan="11" class="text-center">Salary sheet information is not available</td>
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
    name: 'SalarySheet',

    data: () => ({
        month: null,
        monthId: null,
        loading: false
    }),

    watch: {
        month(month) {
            if(month == undefined) return;
            this.monthId = month.id;
        }
    },

    async created() {
        },

    methods: {
        async getSalaryRecord() {
            if(this.month == null) {
                this.$store.dispatch('snackbar/error', 'Select a month');
                return;
            }

            this.loading = true;
            await this.$store.dispatch('employee/getSalarySheet', {monthId: this.monthId})
            this.loading = false
        },
    }
}
</script>

<style lang="scss" scoped>
    .v-icon.v-icon {
       font-size: 18px !important;
       top: -3px !important;
   }
   .theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {
        font-size: 11px;
        padding: 0px 1px;
        // background: #061e95;
        // color: #fff;
        // border: 1px solid #ccc;
        background: var(--theme_lighter);
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