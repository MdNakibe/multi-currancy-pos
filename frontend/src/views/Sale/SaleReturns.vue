<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12">
                <v-form class="custom-form white py-3 px-2 shadow1 rounded" @submit.prevent="getSaleReturns">
                    <v-row dense justify="center" align="center">
                        <v-col cols="2">
                            <v-row no-gutters style="margin-top: 3px;color: #000;" align="center">
                                <v-col cols="3">Type</v-col>
                                <v-col cols="9">
                                    <v-combobox 
                                        v-model="searchType"
                                        dense
                                        outlined
                                        hide-details
                                        :items="['All', 'By Customer']"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="3"  v-if="searchType == 'By Customer'">
                            <v-row no-gutters style="margin-top: 3px;color: #000;" align="center">
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
                        <v-col cols="5">
                            <v-row no-gutters>
                                <v-col cols="6">
                                    <v-row no-gutters style="margin-top: 3px;color: #000;" align="center">
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
                                <v-col cols="6">
                                    <v-row class="pl-3" no-gutters style="margin-top: 3px;color: #000;" align="center">
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
                </v-form>
                <v-divider></v-divider>
            </v-col>
        </v-row>
        <v-row dense v-if="show">
            <v-col cols="12" style="display:none">
                <v-btn height="26px" v-on:click.prevent="print">Print</v-btn>
            </v-col>
            <v-col cols="12" id="invoiceContent">
                <v-data-table
                    class="custom-data-table elevation-1"
                    dense
                    show-expand
                    :headers="saleReturnHeaders"
                    :loading="$store.getters['sale/loadingSale']"
                    :items="$store.getters['sale/saleReturns']"
                    :search="searchSale"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="1">
                            <v-toolbar-title class="subtitle-1">Sale Return List</v-toolbar-title>
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
                        </v-toolbar>
                    </template>
                    
                    <template v-slot:[`item.action`]="{ item }">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="$router.push(`/sale-return-invoice/${item.id}`)"
                                    color="success"
                                    v-on="on"
                                    target="_blank"
                                >
                                    mdi-file
                                </v-icon>
                            </template>
                            <span>Invoice</span>
                        </v-tooltip>
                        <!-- <v-tooltip bottom v-if="userType == 'super_admin' || userType == 'admin'">
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="$router.push(`/sale-return/${item.id}`)"
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
                                    @click="saleReturnId = item.id;$refs.confirmDialog.dialog = true"
                                    color="error"
                                    v-on="on"
                                    >mdi-delete-circle-outline</v-icon
                                >
                            </template>
                            <span>Delete</span>
                        </v-tooltip> -->
                    </template>

                    <template v-slot:expanded-item="{ headers, item }">
                        <td :colspan="headers.length">
                            <table class="details__table">
                                <tr>
                                    <th>SL No.</th>
                                    <th>Product Id</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                                <tr v-for="(detail, i) in item.return_details" :key="i">
                                    <td width="5%">{{ i + 1 }}</td>
                                    <td>{{ detail.product.code }}</td>
                                    <td>{{ detail.product.name }}</td>
                                    <td>{{ detail.quantity }}</td>
                                    <td>{{ detail.return_amount }}</td>
                                </tr>
                            </table>
                        </td>
                    </template>
                </v-data-table>

                <!-- <confirm-dialog ref="confirmDialog" @confirm="deleteSaleReturn"></confirm-dialog> -->
            </v-col>
        </v-row>
        <div v-else class="white shadow1 rounded">
            <div class="no_result">
                <div class="img"></div>
            </div>
        </div>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
export default {
    name: 'SaleReturns',

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
        customer: null,
        searchLoading: false,
        show: false,
        saleReturnId: null,
        loading: false,
        
        saleReturnHeaders: [
            { text: 'Sl', value: 'sl' },
            { text: 'Sale Date', value: 'sale.date' },
            { text: 'Return Date', value: 'date' },
            { text: 'Invoice', value: 'invoice' },
            { text: 'Customer', value: 'sale.customer.name' },
            { text: 'Total', value: 'total' },
            { text: 'Note', value: 'note' },
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
    },

    created() {
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;
    },

    methods: {
        async getSaleReturns() {

            this.loading = true;

            await this.$store.dispatch('sale/getSaleReturns', this.sale);

            this.loading = false;
            
            this.show = true;
        },

        // deleteSaleReturn() {
        //     this.$store.dispatch('sale/deleteSaleReturn', this.saleReturnId);
        //     this.$refs.confirmDialog.dialog = false;
        // },
    }
}
</script>

<style lang="scss" scoped>
   .v-icon.v-icon {
       font-size: 18px !important;
       top: 3px !important;
   }
   .theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {
        // font-size: 11px;
        // padding: 0px 1px;
        background: #607D8B;
        color: #fff;
        border: 1px solid #ccc;
        text-align: center;
        // height: 24px !important;
   }
   .v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > td {
        // height: 20px !important;
        // padding: 0px 5px !important;
        font-size: 14px !important;
        border: 1PX solid #ccc !important;
   }
</style>