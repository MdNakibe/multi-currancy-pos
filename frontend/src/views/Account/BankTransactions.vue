<template>
    <v-container fluid class="shadow1 white rounded pb-4">
        <v-row no-gutters>
            <v-col cols="12">
                <v-form class="custom-form" @submit.prevent="getTransactions">
                    <v-row dense>
                        <v-col cols="2">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Select</v-col>
                                <v-col cols="8">
                                    <v-combobox 
                                        v-model="searchType"
                                        dense
                                        outlined
                                        hide-details
                                        :items="['All', 'By Account']"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="2">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="3">Type</v-col>
                                <v-col cols="9">
                                    <v-combobox 
                                        v-model="transaction.type"
                                        dense
                                        outlined
                                        hide-details
                                        :items="['Deposit', 'Withdraw']"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="3"  v-if="searchType == 'By Account'">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Account</v-col>
                                <v-col cols="8">
                                    <v-combobox 
                                        dense
                                        outlined
                                        hide-details
                                        v-model="account"
                                        @focus="$store.dispatch('bankAccount/getBankAccounts')"
                                        :items="$store.getters['bankAccount/accounts']"
                                        :loading="$store.getters['bankAccount/loadingBankAccount']"
                                        item-text="display_text"
                                        item-value="id"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="4">
                            <v-row no-gutters>
                                <v-col cols="6">
                                    <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                        <v-col cols="4">From</v-col>
                                        <v-col cols="8">
                                            <v-menu>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="transaction.dateFrom"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                    >
                                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="transaction.dateFrom"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="6">
                                    <v-row class="pl-3" no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                        <v-col cols="4">To</v-col>
                                        <v-col cols="8">
                                            <v-menu>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="transaction.dateTo"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                    >
                                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="transaction.dateTo"></v-date-picker>
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
        <v-row dense v-if="$store.getters['bankTransaction/transactions'].length != 0">
            <v-col cols="12">
                <v-btn @click.prevent="print" >Print</v-btn>
            </v-col>

            <v-col cols="12" id="invoiceContent">
                <v-simple-table class="custom-table">
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Transaction Id</th>
                                <th>Date</th>
                                <th>Account Name</th>
                                <th>Account No.</th>
                                <th>Bank Name</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(transaction , sl) in $store.getters['bankTransaction/transactions']" :key="sl">
                                <td class="text-center">{{ sl + 1 }}</td>
                                <td class="text-center">{{ transaction.code }}</td>
                                <td class="text-center">{{ transaction.date }}</td>
                                <td class="text-center">{{ transaction.bank.account_name }}</td>
                                <td class="text-center">{{ transaction.bank.account_number }}</td>
                                <td class="text-center">{{ transaction.bank.bank_name }}</td>
                                <td class="text-center">{{ transaction.type }}</td>
                                <td class="text-center">{{ transaction.note }}</td>
                                <td class="text-right">{{ transaction.amount }}</td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="8"><strong>Total</strong></td>
                                <td class="text-right"><strong>{{ $store.getters['bankTransaction/transactions'].reduce((p, c) => {return +p + +c.amount}, 0).toFixed(2) }}</strong></td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-col>
        </v-row>
        <div v-else class="no_result">
            <div class="img"></div>
        </div>
    </v-container>
</template>

<script>
export default {
    name: 'BankTransactions',

    data: () => ({
        searchType: null,
        account: null,
        loading: false,
        transaction: {
            type: '',
            accountId: null,
            dateFrom: new Date().toISOString().substr(0, 10),
            dateTo: new Date().toISOString().substr(0, 10),
        },
    }),

    watch: {
        account(account) {
            if(account == undefined) return;
            this.transaction.accountId = account.id;
        }
    },
    async created() {
        this.setStyle();
    },

    methods: {
        async getTransactions() {
            this.loading = true;

            await this.$store.dispatch('bankTransaction/getTransactions', this.transaction)
            
            this.loading = false;
            this.show = true;
        },

        async print(){
            let invoiceContent = document.querySelector('#invoiceContent').innerHTML;
            let printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}, left=0, top=0`);
            let image = await this.$store.getters['companyProfile/company'].image;
            let ImagePath = `${this.$store.state.hostName}/${image}`;
            let companyName = this.$store.getters['companyProfile/company'].company_name;
            let address = this.$store.getters['companyProfile/company'].address;
            let contactUs = this.$store.getters['companyProfile/company'].contact_us;
            let email = this.$store.getters['companyProfile/company'].email;
            printWindow.document.write(`
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>Bank Transactions</title>
                    <style>
                    </style>
                </head>
                <body>
                    <div>
                        <div class="container">
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <td>
                                            <div class="custom-row">
                                                <div class="col-xs-2">
                                                    <img src="`+ImagePath+`" alt="Logo" style="height:90px; width:90%;object-fit: contain;" />
                                                </div>
                                                <div class="col-xs-10">
                                                    <strong style="font-size:18px;">${companyName}</strong><br>
                                                    <p style="white-space:pre-line;margin:0px">Address : ${address}</p>
                                                    <p style="margin:0px">Mobile : ${contactUs}</p>
                                                    <p style="margin:0px">E-mail : ${email}</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="custom-row">
                                                <div class="col-xs-12">
                                                    <div class="invoice-title">
                                                        Bank Transaction Record
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="custom-row">
                                                <div class="col-xs-12">
                                                    ${invoiceContent}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <div style="width:100%;height:50px;">&nbsp;</div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>    
                    
                </body>
                </html>
            `);
            
            let invoiceStyle = printWindow.document.createElement('style');
            invoiceStyle.innerHTML = this.style.innerHTML;
            printWindow.document.head.appendChild(invoiceStyle);
            printWindow.moveTo(0, 0);
            
            printWindow.focus();
            await new Promise(resolve => setTimeout(resolve, 1000));
            printWindow.print();
            printWindow.close();
        },

        setStyle(){
            this.style = document.createElement('style');
            this.style.innerHTML = `
                .custom-row {
                    width: 100%;
                    display: block;
                }
                .print-btn a{
                    background: #CFD8DC;
                    display: inline-block;
                    padding: 3px 13px;
                    border-radius: 5px;
                    color: #000 !important;
                }
                .print-btn a:hover {
                    background: #B0BEC5;
                }
                .invoice-title {
                    text-align: center;
                    font-weight: bold;
                    font-size: 15px;
                    margin-bottom: 15px;
                    padding: 5px;
                    border-top: 1px dotted #454545;
                    border-bottom: 1px dotted #454545;
                }
                .col-xs-12 {
                    width: 100%;
                }
                .col-xs-10 {
                    width: 80%;
                    float: left;
                }
                .col-xs-9 {
                    width: 70%;
                    float: left;
                }
                .col-xs-7 {
                    width: 60%;
                    float: left;
                }
                .col-xs-6 {
                    width: 50%;
                    float: left;
                }
                .col-xs-5 {
                    width: 40%;
                    float: left;
                }
                .col-xs-4 {
                    width: 35%;
                    float: left;
                }
                .col-xs-3 {
                    width: 30%;
                    float: left;
                }
                .col-xs-2 {
                    width: 20%;
                    float: left;
                }
                .b-text {
                    font-weight: 500;
                    font-size: 15px;
                }
                .normal-text {
                    font-size: 14px;
                    margin: 0px;
                }
                .invoice-details {
                    width: 100%;
                    border-collapse: collapse;
                    border:1px solid #ccc;
                }
                .invoice-details thead {
                    font-weight: 500;
                    text-align:center;
                }
                .invoice-details tbody td{
                    padding: 0px 5px;
                }
                .text-center {
                    text-align: center;
                }
                .text-right {
                    text-align: right;
                }
                .line {
                    border-bottom: 1px solid #ccc;
                    margin-top: 15px;
                    margin-bottom: 15px;
                }
                .paid-text {
                    padding:30px 0px;
                }
                .mt-60 {
                    margin-top: 60px;
                }
                .mr-20 {
                    margin-right: 20px;
                }
                .ml-20 {
                    margin-left: 20px;
                }
                .ft-fiext {
                    position: fixed;
                    bottom: 0;
                }
                @media print {
                    .hide {
                        display: none
                    }
                    .v-data-table > .v-data-table__wrapper > table {
                        width: 100%;
                        border-spacing: 0;
                    }
                    .theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {
                        font-size: 13px;
                        padding: 0px 1px;
                        color: #000;
                        border: 1px solid #ccc;
                        text-align: center;
                        height: 24px !important;
                    }
                    .v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > td {
                        height: 20px !important;
                        padding: 0px 5px !important;
                        font-size: 12px !important;
                        border: 1px solid #ccc !important;
                    }
                }
                .cls {
                    clear: both;
                }
            `;
            document.head.appendChild(this.style);
        },
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
        border: 1PX solid #ccc !important;
   }
</style>