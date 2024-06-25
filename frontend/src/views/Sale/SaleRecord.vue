<template>
    <v-container fluid class="white rounded shadow1">
        <v-row no-gutters>
            <v-col cols="12">
                <v-form class="custom-form" @submit.prevent="getSaleRecord">
                    <v-row dense class="flex_align_center flex_wrap">
                        <v-col cols="auto" md="2">
                            <v-row no-gutters style="margin-top: 3px;color: #000;" class="flex_align_center">
                                <v-col cols="3">Type</v-col>
                                <v-col cols="9">
                                    <v-combobox 
                                        v-model="searchType"
                                        dense
                                        outlined
                                        hide-details
                                        :items="['All', 'By Customer', 'By Employee', 'By Product']"
                                       
                                    >
                                    <p> {{ searchType= "All" }}</p>
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="auto" md="3"  v-if="searchType == 'By Customer'">
                            <v-row no-gutters style="margin-top: 3px;color: #000; align-items: center;">
                                <v-col cols="4">Customer</v-col>
                                <v-col cols="8">
                                    <v-combobox 
                                        dense
                                        outlined
                                        hide-details
                                        v-model="customer"
                                        @focus="$store.dispatch('customer/getCustomers')"
                                        :items="$store.getters['customer/customers']"
                                        :loading="$store.getters['customer/loading']"
                                        item-text="display_text"
                                        item-value="id"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="auto" md="3"  v-if="searchType == 'By Employee'">
                            <v-row no-gutters style="margin-top: 3px;color: #000;" class="flex_align_center">
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
                        <v-col cols="auto" md="3"  v-if="searchType == 'By Product'">
                            <v-row no-gutters style="margin-top: 3px;color: #000;" class="flex_align_center">
                                <v-col cols="4">Product</v-col>
                                <v-col cols="8">
                                    <v-combobox 
                                        dense
                                        outlined
                                        hide-details
                                        @focus="$store.dispatch('product/getProducts')"
                                        :items="$store.getters['product/products']"
                                        :loading="$store.getters['product/loadingProducts']"
                                        item-text="display_text"
                                        item-value="id"
                                        :auto-select-first="true"
                                        v-model="product"
                                        :filter="globalFilter"
                                        ref="product"
                                    >
                                        <template v-slot:[`item`]="{ item }">
                                            <div>
                                                <v-avatar size="50">
                                                    <v-img
                                                        :src="`${$store.state.hostName}${item.image}`"
                                                    />
                                                </v-avatar>
                                                {{ item.display_text }}
                                            </div>
                                        </template>
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="auto" md="5">
                            <v-row no-gutters>
                                <v-col cols="auto" md="6">
                                    <v-row no-gutters style="margin-top: 3px;color: #000;">
                                        <v-col cols="4">Date From</v-col>
                                        <v-col cols="8">
                                            <v-menu>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="sale.dateFrom"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                    >
                                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="sale.dateFrom"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="auto" md="6">
                                    <v-row class="pl-3" no-gutters style="margin-top: 3px;color: #000;">
                                        <v-col cols="4">Date To</v-col>
                                        <v-col cols="8">
                                            <v-menu>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="sale.dateTo"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                    >
                                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="sale.dateTo"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="1">
                            <v-btn type="submit" class="text_bg_fave" :loading="loading">Search</v-btn>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                </v-form>
            </v-col>
        </v-row>
        <v-row dense v-if="show">
            <v-col cols="12">
                <v-btn height="26px" v-on:click.prevent="print">Print</v-btn>
            </v-col>
            <v-col cols="12" id="invoiceContent">
                <v-data-table
                    class="custom-data-table elevation-1"
                    dense
                    show-expand
                    :headers="saleHeaders"
                    :loading="$store.getters['sale/loadingSale']"
                    :items="$store.getters['sale/sales']"
                    :search="searchSale"
                    :itemsPerPage="15"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0" class="mt-4">
                            <v-toolbar-title class="subtitle-2">Sale Report</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search sale"
                                    append-icon="mdi-magnify"
                                    style="width:300px;"
                                    v-model="searchSale"
                                >
                                </v-text-field>
                            </v-form>
                            <v-btn dark color="primary" v-on:click.prevent="print">Print</v-btn>
                        </v-toolbar>
                    </template>
                    <v-divider></v-divider>
                    <template v-slot:[`item.action`]="{ item }">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="$router.push(`/sale-invoice/${item.id}`)"
                                    color="success"
                                    v-on="on"
                                    target="_blank"
                                >
                                    mdi-file
                                </v-icon>
                            </template>
                            <span>Invoice</span>
                        </v-tooltip>
                        <v-tooltip bottom v-if="userType == 'super_admin' || userType == 'admin'">
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="$router.push(`/${item.customer.type}/${item.id}`)"
                                    color="primary"
                                    v-on="on"
                                    >mdi-circle-edit-outline</v-icon
                                >
                            </template>
                            <span>Edit</span>
                        </v-tooltip>
                        <v-tooltip bottom v-if="userType == 'super_admin' || userType == 'admin'">
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="saleId = item.id;$refs.confirmDialog.dialog = true"
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
                                    <th>Sale Rate</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                                <tr v-for="(detail, i) in item.sale_details" :key="i">
                                    <td>{{ i + 1 }}</td>
                                    <td>{{ detail.product.code }}</td>
                                    <td>{{ detail.product.name }}</td>
                                    <td>{{ detail.purchase_rate }}</td>
                                    <td>{{ detail.sale_rate }}</td>
                                    <td>{{ detail.quantity }}</td>
                                    <td>{{ detail.total }}</td>
                                </tr>
                            </table>
                        </td>
                    </template>
                </v-data-table>

                <confirm-dialog ref="confirmDialog" @confirm="deleteSale"></confirm-dialog>
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
    name: 'SaleRecord',

    components: {
		"confirm-dialog": confirmDialog,
    },

    data: ()=> ({
        searchType: null,
        sale: {
            customerId: null,
            employeeId: null,
            dateFrom: '',//new Date().toISOString().substr(0, 10),
            dateTo: new Date().toISOString().substr(0, 10),
        },
        saleRecord: [],
        customer: null,
        product: null,
        employee: null,
        searchLoading: false,
        show: false,
        saleId: null,
        loading: false,
        
        saleHeaders: [
            { text: 'Sl', value: 'sl' },
            { text: 'Date', value: 'date' },
            { text: 'Invoice', value: 'invoice' },
            { text: 'Customer Name', value: 'customer.name' },
            { text: 'Sub Total', value: 'sub_total' },
            // { text: 'Vat', value: 'vat' },
            // { text: 'Discount', value: 'discount' },
            // { text: 'Transport', value: 'transport' },
            { text: 'Total', value: 'total' },
            { text: 'Paid', value: 'paid' },
            { text: 'Due', value: 'due' },
            { text: 'Action', value: 'action' },
            { text: 'Details', value: 'data-table-expand' },
        ],
        searchSale: '',
        userType: ''
    }),

    watch: {
        customer(customer) {
            if (customer == null) return
            this.sale.customerId = customer.id;
        },

        employee(employee) {
            if(employee == null) return
            this.sale.employeeId = employee.id;
        },  
        product(product) {
            if(product == null) return
            this.sale.productId = product.id;
        },  
        
    },

    computed: {
        
    },

    created() {
        this.setStyle();
        this.getSaleRecord();
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;
    },

    methods: {
        async getSaleRecord() {

            this.loading = true;

            await this.$store.dispatch('sale/getSales', this.sale);

            this.loading = false;
            
            this.show = true;
        },

        deleteSale() {
            this.$store.dispatch('sale/deleteSale', this.saleId);
            this.$refs.confirmDialog.dialog = false;
        },

        printInvoice(id) {
            this.$router.push(`/sale-invoice/${id}`);
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
                                                    sale Record
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