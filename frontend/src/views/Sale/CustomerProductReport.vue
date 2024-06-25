<template>
    <v-container fluid class="white rounded shadow1">
        <v-row no-gutters>
            <v-col cols="12">
                <v-form class="custom-form" @submit.prevent="getSaleRecord">
                    <v-row dense class="flex_align_center flex_wrap">
                        <v-col cols="auto" md="3">
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
            <v-col cols="12">
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
                                    @click="$router.push(`/sale/${item.id}`)"
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

        <div v-show="false" id="invoiceContent">
            <v-simple-table class="bordered-table">
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th>SL.</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Quantity Sold</th>
                            <th>Sale Amount</th>
                            <!-- <th>Quantity Returned</th>
                            <th>Return Amount</th>
                            <th>Net Sale Amount</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in customer_unique_products" :key="product.sl">
                            <td class="text-center">{{ product.sl }}</td>
                            <td class="text-center">{{ product.code }}</td>
                            <td class="text-center">{{ product.name }}</td>
                            <td class="text-center">{{ lodash.get(product, 'category.name') }}</td>
                            <td class="text-center">{{ lodash.get(product, 'brand.name') }}</td>
                            <td class="text-center">{{ getSum('quantity') }}</td>
                            <td class="text-center">{{ sumBy('total') }}</td>
                            <!-- <td class="text-center">{{ product.sale_rate }}</td> -->
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </div>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
import { handlePrint } from "../../composable/usePrint";
import _ from 'lodash'

export default {
    name: 'SaleRecord',

    components: {
		"confirm-dialog": confirmDialog,
    },

    data: ()=> ({
        searchType: null,
        sale: {
            customerId: null,
            dateFrom: new Date().toISOString().substr(0, 10),
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

        customer_products: [],
        customer_unique_products: [],
        
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
  
        product(product) {
            if(product == null) return
            this.sale.productId = product.id;
        },  
        
    },

    computed: {
       
    },

    created() {
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;
    },

    methods: {
        getSum(column) {
            return _.sumBy(this.customer_products, item => item[column])
        },
        async getSaleRecord() {

            this.loading = true;

            await this.$store.dispatch('sale/getSales', this.sale);

            this.loading = false;
            
            this.show = true;
            this.prepareProductDataFromSaleRecord()
        },

        prepareProductDataFromSaleRecord() {
            let sales = this.$store.getters['sale/sales']
            let products = sales.map(item => item.sale_details).flat()
            let unique_product = _.uniqBy(products, item => {
                item.id
            })
            this.customer_products = products
            this.customer_unique_products = unique_product
            console.log(unique_product);
        },

        deleteSale() {
            this.$store.dispatch('sale/deleteSale', this.saleId);
            this.$refs.confirmDialog.dialog = false;
        },

        printInvoice(id) {
            this.$router.push(`/sale-invoice/${id}`);
        },
        async print() {
            let invoiceContent = document.querySelector('#invoiceContent').innerHTML;
            handlePrint({
                title: 'Product price list',
                content: invoiceContent,
            })
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