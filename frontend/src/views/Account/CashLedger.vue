<template>
    <v-container fluid class="white shadow1 rounded">
         <v-row no-gutters>
            <v-col cols="12">
                <v-form class="custom-form" @submit.prevent="getCashLedger">
                    <v-row dense>
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
                            <v-btn type="submit" dark color="text_bg_fave" :loading="loading">Search</v-btn>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                </v-form>
            </v-col>
        </v-row>
        <v-row class="py-2">
            <!-- <v-col cols="12">
                <v-btn height="26px" @click.prevent="print" class="mb-2" v-if="$store.getters['customer/customers'].length != 0">Print</v-btn>
            </v-col> -->
            <v-col cols="12" id="printContent">
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Cash In</th>
                                <th>Cash Out</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-left"><strong>Opening Balance</strong></td>
                                <td colspan="2"></td>
                                <td class="text-center"><strong>{{ $store.getters['cashTransaction/openingBalance'] }}</strong></td>
                            </tr>
                            <tr v-for="(ledger, ind) in $store.getters['cashTransaction/ledgers']" :key="ind">
                                <td>{{ ind + 1}}</td>
                                <td>{{ ledger.date}}</td>
                                <td class="text-left">{{ ledger.description}}</td>
                                <td>{{ ledger.cash_in}}</td>
                                <td>{{ ledger.cash_out}}</td>
                                <td>{{ ledger.balance}}</td>
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
    name: 'CashLedger',

    data: () => ({
        filter: {
            dateFrom: new Date().toISOString().substr(0, 10),
            dateTo: new Date().toISOString().substr(0, 10),
        },
        loading: false
    }),

    methods: {
        async getCashLedger() {
            this.loading = true;
            await this.$store.dispatch('cashTransaction/getCashLedgers', this.filter)
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