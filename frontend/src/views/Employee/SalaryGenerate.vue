<template>
    <v-container fluid class="white shadow1 rounded">
        <v-row no-gutters>
            <v-col cols="12">
                <v-form class="custom-form">
                    <v-row dense>
                        <v-col cols="3">
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
                        <v-col cols="1" class="d-flex align-center">
                            <v-btn color="text_bg_fave" @click="getEmployee">View</v-btn>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                </v-form>
            </v-col>
        </v-row>

        <v-row no-gutters class="py-2" v-if="cart.length > 0">
            <v-col cols="12">
                <form class="custom-form">
                    <v-simple-table>
                        <template v-slot:default>
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Employee Id</th>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Salary</th>
                                    <th>Deduction</th>
                                    <th>Commission</th>
                                    <th>Advance</th>
                                    <th>Other Benefit</th>
                                    <th>Net Payable</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(employee, sl) in cart" :key="sl">
                                    <td>{{ sl + 1 }}</td>
                                    <td>{{ employee.emp_id }}</td>
                                    <td>{{ employee.name }}</td>
                                    <td>{{ employee.department.name }}</td>
                                    <td>{{ employee.designation.name }}</td>
                                    <td>{{ employee.salary }}</td>
                                    <td width="10%">
                                        <v-text-field
                                            disabled
                                            dense
                                            outlined
                                            hide-details
                                            v-model.number="employee.commission"
                                            type="number"
                                            min="0"
                                        ></v-text-field>
                                    </td>
                                    <td width="10%">
                                        <v-text-field
                                            dense
                                            outlined
                                            hide-details
                                            v-model.number="employee.deduction"
                                            type="number"
                                            min="0"
                                            @input="calculateTotal(sl)"
                                        ></v-text-field>
                                    </td>
                                    <td width="10%">
                                        <v-text-field
                                            dense
                                            outlined
                                            hide-details
                                            v-model.number="employee.advance"
                                            type="number"
                                            min="0"
                                            @input="calculateTotal(sl)"
                                        ></v-text-field>
                                    </td>
                                    <td width="10%">
                                        <v-text-field
                                            dense
                                            outlined
                                            hide-details
                                            v-model.number="employee.others"
                                            type="number"
                                            min="0"
                                            @input="calculateTotal(sl)"
                                        ></v-text-field>
                                    </td>
                                    <td width="10%">
                                        {{ employee.total}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9" class="text-center"> 
                                        <strong>Total Salary: {{ total }}</strong>
                                        
                                    </td>
                                    <td>
                                        <v-text-field
                                            dense
                                            outlined
                                            hide-details
                                            v-model="salary.date"
                                            type="date"
                                        ></v-text-field>
                                    </td>
                                    <td>
                                        <v-btn class="text_bg_fave" :loading="loading" @click="salaryGenerate">Generate</v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                </form>
            </v-col>
        </v-row>
        <div v-else class="no_result">
            <div class="img"></div>
        </div>
    </v-container>
</template>

<script>
export default {
    name: 'SalaryGenerate',

    data: () => ({
        month: null,
        cart: [],
        loading: false,
        total: 0,
        salary: {
            id: null,
            date: new Date().toISOString().substr(0, 10),
            month_id: null
        }
    }),

    watch: {
        month(month) {
            if(month == undefined) return;
            this.salary.month_id = month.id
        }
    },

    created() {

    },

    methods: {
        async getEmployee() {
            this.cart = [];
            if(this.month == null) {
                this.$store.dispatch('snackbar/error', 'Select a month');
                return;
            }

            await this.$store.dispatch('employee/getEmployees', this.salary)
            this.cart = this.$store.getters['employee/employees'].filter(e => e.status == 'a')
            this.cart.map(item => {
                item.deduction = 0;
                item.advance = 0;
                item.others = 0;
                return item;
            })

        },

        calculateTotal(ind) {
            let total = ((+this.cart[ind].salary + +this.cart[ind].others + +this.cart[ind].commission) - (+this.cart[ind].deduction + +this.cart[ind].advance)).toFixed(2);
            this.cart[ind].total = total;
            this.total = this.cart.reduce((p, c) => {return +p + +c.total}, 0).toFixed(2)
        },

        async salaryGenerate() {
            if(this.month == null) {
                this.$store.dispatch('snackbar/error', 'Select a month');
                return;
            }

            this.loading = true;
            let data = {
                salary: this.salary,
                cart: this.cart
            }

            let isSuccess = await this.$store.dispatch('employee/salaryGenerate', data)
            if(isSuccess) {
                this.cart = [];
                this.month = null;
                this.salary.date = new Date().toISOString().substr(0, 10);
            }

            this.loading = false;
        }
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
   }
</style>