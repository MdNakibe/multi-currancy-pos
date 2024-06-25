<template>
    <v-container fluid class="white pb-4 shadow1 rounded">
        <v-form class="custom-form" @submit.prevent="getCustomerLedger">
            <v-row dense justify="center">
                <v-col cols="4">
                    <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                        <v-col cols="3">Customer</v-col>
                        <v-col cols="9">
                            <v-combobox 
                                dense
                                outlined
                                hide-details
                                v-model="customer"
                                @focus="$store.dispatch('customer/getCustomers')"
                                :items="$store.getters['customer/customers']"
                                :loading="$store.getters['customer/loadingCustomers']"
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

            <v-row v-if="show">
                <v-col cols="12" id="printContent">
                    <v-simple-table>
                        <template v-slot:default>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Bill</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Returned</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td><strong>Opening Balance</strong></td>
                                    <td colspan="4"></td>
                                    <td class="text-right"><strong>{{ $store.getters['customer/openingBalance'] }}</strong></td>
                                </tr>

                                <tr v-for="(payment, ind) in $store.getters['customer/ledgers']" :key="ind">
                                    <td class="text-center">{{ payment.date }}</td>
                                    <td>{{ payment.description }}</td>
                                    <td class="text-right">{{ payment.bill }}</td>
                                    <td class="text-right">{{ payment.paid }}</td>
                                    <td class="text-right">{{ payment.due }}</td>
                                    <td class="text-right">{{ payment.returned }}</td>
                                    <td class="text-right">{{ payment.balance }}</td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                </v-col>
            </v-row>
            <div v-else class="no_result">
                <div class="img"></div>
            </div>
        </v-form>
    </v-container>
</template>

<script>
export default {
    name: 'CustomerLedger',

    data: () => ({
        filter: {
            dateFrom: new Date().toISOString().substr(0, 10),
            dateTo: new Date().toISOString().substr(0, 10),
            customerId: null
        },
        customer: null,
        loading: false,
        show: false,
    }),

    watch: {
        customer(customer) {
            if(customer == undefined) return;
            this.filter.customerId = customer.id;
        }
    },

    methods: {
        async getCustomerLedger() {
            if(this.customer == null) {
                this.$store.dispatch('snackbar/error', 'Select a customer');
                return;
            }

            this.loading = true;

            await this.$store.dispatch('customer/getCustomerLedger', this.filter)

            this.show = true;
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
        font-size: 14px;
        // padding: 0px 1px;
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
   }
</style>