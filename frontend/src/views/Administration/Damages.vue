<template>
    <v-container fluid class="white shadow1 py-4 pt-2 px-3 rounded">
        <v-row no-gutters>
            <v-col cols="12">
                <v-form class="custom-form" @submit.prevent="getDamageRecord">
                    <v-row dense>
                        <v-col cols="5">
                            <v-row>
                                <v-col cols="auto" sm="6">
                                    <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                        <v-col cols="4">Date From</v-col>
                                        <v-col cols="8">
                                            <v-menu>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="damage.dateFrom"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                    >
                                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="damage.dateFrom"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="auto" sm="6">
                                    <v-row class="pl-3" no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                        <v-col cols="4">Date To</v-col>
                                        <v-col cols="8">
                                            <v-menu>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="damage.dateTo"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                    >
                                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="damage.dateTo"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="auto" sm="1" class="d-flex align-center">
                            <v-btn type="submit" dark color="light-blue darken-2" :loading="loading">Search</v-btn>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                </v-form>
            </v-col>
        </v-row>
        <v-row dense v-if="show">
            <v-col cols="12" style="display:none">
                <v-btn height="26px" v-on:click.prevent="print">Print</v-btn>
            </v-col>
            <v-col cols="12" id="invoiceContent">
                <v-data-table
                    class="custom-data-table mt-5"
                    show-expand
                    :headers="damageHeaders"
                    :loading="$store.getters['damage/loadin']"
                    :items="$store.getters['damage/damages']"
                    :search="searchDamage"
                    :items-per-page="15"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0" style="border-bottom: 1px solid #ddd !important;">
                            <v-toolbar-title class="subtitle-2">Damage Report</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search damage"
                                    append-icon="mdi-magnify"
                                    style="width:300px;"
                                    v-model="searchDamage"
                                >
                                </v-text-field>
                            </v-form>
                        </v-toolbar>
                    </template>
                    
                    <template v-slot:[`item.action`]="{ item }">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="$router.push(`/damage-invoice/${item.id}`)"
                                    color="success"
                                    v-on="on"
                                    target="_blank"
                                >
                                    mdi-file
                                </v-icon>
                            </template>
                            <span>Invoice</span>
                        </v-tooltip>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="$router.push(`/damage/${item.id}`)"
                                    color="primary"
                                    v-on="on"
                                    >mdi-circle-edit-outline</v-icon
                                >
                            </template>
                            <span>Edit</span>
                        </v-tooltip>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="damageId = item.id;$refs.confirmDialog.dialog = true"
                                    color="error"
                                    v-on="on"
                                    >mdi-delete-circle-outline</v-icon
                                >
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>

                    <template v-slot:expanded-item="{ headers, item }">
                        <td :colspan="headers.length">
                            <table class="details__table">
                                <tr>
                                    <th>SL No.</th>
                                    <th>Product Id</th>
                                    <th>Product Name</th>
                                    <th>Purchase Rate</th>
                                    <th>damage Rate</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                                <tr v-for="(detail, i) in item.damage_details" :key="i">
                                    <td>{{ i + 1 }}</td>
                                    <td>{{ detail.product.code }}</td>
                                    <td>{{ detail.product.name }}</td>
                                    <td>{{ detail.product.purchase_rate }}</td>
                                    <td>{{ detail.rate }}</td>
                                    <td>{{ detail.quantity }}</td>
                                    <td>{{ detail.total }}</td>
                                </tr>
                            </table>
                        </td>
                    </template>
                </v-data-table>

                <confirm-dialog ref="confirmDialog" @confirm="deleteDamage"></confirm-dialog>
            </v-col>
        </v-row>
        <div v-else class="no_result">
            <div class="img"></div>
        </div>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
export default {
    name: 'Damages',

    components: {
		"confirm-dialog": confirmDialog,
    },

    data: ()=> ({
        searchType: null,
        damage: {
            dateFrom: new Date().toISOString().substr(0, 10),
            dateTo: new Date().toISOString().substr(0, 10),
        },
        searchLoading: false,
        show: false,
        damageId: null,
        loading: false,
        
        damageHeaders: [
            { text: 'Sl', value: 'sl' },
            { text: 'Date', value: 'date' },
            { text: 'Invoice', value: 'invoice' },
            { text: 'Damage Total', value: 'total' },
            { text: 'Note', value: 'note' },
            { text: 'Save By', value: 'added_by.name' },
            { text: 'Action', value: 'action' },
            { text: 'Details', value: 'data-table-expand' },
        ],
        searchDamage: '',
    }),

    created() {
        this.setStyle();
    },

    methods: {
        async getDamageRecord() {

            this.loading = true;

            await this.$store.dispatch('damage/getDamages', this.damage);

            this.loading = false;
            
            this.show = true;
        },

        deleteDamage() {
            this.$store.dispatch('damage/deleteDamage', this.damageId);
            this.$refs.confirmDialog.dialog = false;
        },

        printInvoice(id) {
            this.$router.push(`/damage-invoice/${id}`);
        },

        async print(){
            let invoiceContent = document.querySelector('#invoiceContent').innerHTML;
            let printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}, left=0, top=0`);
            let companyProfile = this.$store.getters['companyProfile/company']
            let companyImage = companyProfile != null ? this.$store.getters['companyProfile/company'].image : ''
            let ImagePath = companyImage ? this.apiBasePath + '/' + companyImage : '';
            printWindow.document.write(`
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>Investigation Payment Slip</title>
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
                                                    <strong style="font-size:18px;">${companyProfile != null ? companyProfile.company_name : ''}</strong><br>
                                                    <p style="white-space:pre-line;margin:0px">Address : ${companyProfile != null ? companyProfile.address : ''}</p>
                                                    <p style="margin:0px">Mobile : ${companyProfile != null ? companyProfile.contact_us : ''}</p>
                                                    <p style="margin:0px">E-Mail : ${companyProfile != null ? companyProfile.email : ''}</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="custom-row">
                                                <div class="invoice-title">
                                                    damage Record
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
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
        background: #607D8B;
        color: #fff;
        border: 1px solid #ccc;
        text-align: center;
        height: 24px !important;
   }
   .v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > td {
        height: 20px !important;
        padding: 0px 5px !important;
        font-size: 12px !important;
        border: 1PX solid #ccc !important;
   }
</style>