<template>
    <v-container fluid>
        <v-row no-gutters class="pt-2">
            <v-col cols="12">
                <v-form class="custom-form" ref="saleForm" @submit.prevent="saveSale">
                    <v-row dense>
                        <v-col cols="12" md="9">
                            <v-row >
                                <v-col cols="5">
                                    <v-card 
                                        height="100%"
                                        color="white"
                                        class="theme_rounded pa-3 shadow1"
                                    >
                                        <v-toolbar color="white lighten-4" :elevation="0" height="40px">
                                            <v-toolbar-title class="subtitle-2">Customer Information</v-toolbar-title>
                                        </v-toolbar>
                                        <v-card-text class="py-1 pa-0 pl-2 pr-2">
                                            <!-- <v-row>
                                                <v-col cols="3" class="py-1 caption">Cust. Type</v-col>
                                                <v-col cols="9" class="py-0 pa-0 pl-3 pr-4">
                                                    <v-radio-group
                                                        v-model="type"
                                                        row
                                                    >
                                                        <v-radio
                                                            label="Retail"
                                                            value="Retail"
                                                        ></v-radio>
                                                        <v-radio
                                                            label="Wholesale"
                                                            value="Wholesale"
                                                        ></v-radio>
                                                    </v-radio-group>
                                                </v-col>
                                            </v-row> -->
                                            <v-row>
                                                <v-col cols="3" class="py-1 caption">Customer</v-col>
                                                <v-col cols="8" class="py-0 pa-0 pl-3 pr-4">
                                                    <v-combobox 
                                                        dense
                                                        outlined
                                                        hide-details
                                                        @focus="$store.dispatch('customer/getCustomers', {type: type})"
                                                        :items="customers"
                                                        :loading="$store.getters['customer/loadingCustomers']"
                                                        item-text="display_text"
                                                        item-value="id"
                                                        v-model="customer"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                                <v-col cols="1" class="py-0 pl-2 pa-0" style="margin-left: -17px;">
                                                    <v-btn to="/customer" target="_blank" fab x-small depressed color="primary">
                                                        <v-icon color="white">mdi-plus</v-icon>
                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                            
                                            <v-row v-if="customer.type == 'G'" class="py-2">
                                                <v-col cols="3" class="py-1 caption">Name</v-col>
                                                <v-col cols="9" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="customer.name"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="3" class="py-1 caption">Phone</v-col>
                                                <v-col cols="9" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="customer.phone"
                                                        :readonly="customer.type == 'G' ? false: true"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="3" class="py-1 caption">Address</v-col>
                                                <v-col cols="9" class="py-0">
                                                    <v-textarea
                                                        dense
                                                        outlined
                                                        hide-details
                                                        height="8vh"
                                                        v-model="customer.address"
                                                        :readonly="customer.type == 'G' ? false: true"
                                                    ></v-textarea>
                                                </v-col>
                                            </v-row>
                                        </v-card-text>
                                    </v-card>
                                </v-col>
                                <v-col cols="5">
                                    <v-card 
                                        color="white"
                                        class="shadow1 theme_rounded py-2 px-4"
                                    >
                                        <v-toolbar color="white lighten-4" :elevation="0" height="40px">
                                            <v-toolbar-title class="subtitle-2">Product Information</v-toolbar-title>
                                        </v-toolbar>
                                        <v-card-text class="py-1 pa-0 pl-2 pr-2">
                                            <v-form ref="productForm" class="custom-form" @submit.prevent="addToCart">
                                                <v-row class="py-2">
                                                    <v-col cols="12" class="py-1 caption">Product</v-col>
                                                    <v-col cols="11" class="py-0 pa-0 pl-3 pr-4">
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
                                                    <v-col cols="1" class="py-0 pa-0" style="margin-left: -17px;">
                                                        <v-btn to="/product" target="_blank" fab x-small depressed color="primary">
                                                            <v-icon color="white">mdi-plus</v-icon>
                                                        </v-btn>
                                                    </v-col>
                                                </v-row>
                                                <v-row class="py-2">
                                                    <v-col cols="3" class="py-1 caption">Sale Rate</v-col>
                                                    <v-col cols="4" class="py-0">
                                                        <v-text-field
                                                            dense
                                                            outlined
                                                            hide-details
                                                            type="number"
                                                            min="0"
                                                            v-model.number="product.sale_rate"
                                                            @input="productTotal"
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="2" class="py-0 pa-0">Quantity</v-col>
                                                    <v-col cols="3" class="py-0 pa-0 pr-3">
                                                        <v-text-field
                                                            dense
                                                            outlined
                                                            hide-details
                                                            type="number"
                                                            min="0"
                                                            v-model.number="product.quantity"
                                                            @input="productTotal"
                                                            ref="quantity"
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row class="py-2">
                                                    <v-col cols="3" class="py-1 caption">Total</v-col>
                                                    <v-col cols="9" class="py-0">
                                                        <v-text-field
                                                            dense
                                                            outlined
                                                            hide-details
                                                            type="number"
                                                            min="0"
                                                            readonly
                                                            v-model="product.total"
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row class="py-2">
                                                    <v-col cols="9"></v-col>
                                                    <v-col cols="3" class="py-0" style="display: flex;justify-content: end;">
                                                        <v-btn type="submit" height="35px" dark color="primary">Add</v-btn>
                                                    </v-col>
                                                </v-row>
                                            </v-form>
                                        </v-card-text>
                                    </v-card>
                                </v-col> 
                                <v-col cols="2">
                                    <v-card
                                        color="white"
                                        height="136"
                                        class="shadow1 theme_rounded"
                                    >
                                        <v-toolbar color="white lighten-4" :elevation="0" height="50px">
                                            <v-toolbar-title class="subtitle-2" style="width: 100%;display: flex;align-items: center; flex-direction: column;justify-content: center;">
                                                Product Stock
                                                <v-divider style="width: 100%;"></v-divider>
                                            </v-toolbar-title>
                                        </v-toolbar>
                                        <v-card-text class="py-1">
                                            <div class="stock">
                                                {{ stock }} <span v-if="stock != ''"> <br>
                                                {{ product.unit.name }}</span>
                                            </div>
                                        </v-card-text>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12">
                                    <v-card class="px-0 shadow1 theme_rounded">
                                        <v-toolbar color="white lighten-4" :elevation="0" height="40px">
                                            <v-toolbar-title class="subtitle-1">Cart Information</v-toolbar-title>
                                        </v-toolbar>
                                        <v-card-text class="py-3 pa-3 pb-5">
                                            <v-simple-table dense>
                                                <template v-slot:default>
                                                    <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Product Name</th>
                                                            <th>Sale Rate</th>
                                                            <th>Quantity</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, ind) in cart" :key="ind">
                                                            <td class="text-center" style="width:5%">{{ind+1}}</td>
                                                            <td>{{item.name}}</td>
                                                            <td class="text-right" style="width:12%">{{item.sale_rate}}</td>
                                                            <td class="text-right" style="width:10%">{{item.quantity}}</td>
                                                            <td class="text-right" style="width:10%">{{ item.total}}</td>
                                                            <td class="text-center" style="width:10%">
                                                                <v-icon small @click="editCart(ind)" color="primary">mdi-circle-edit-outline</v-icon>
                                                                <v-icon small @click="deleteCart(ind)" color="error">mdi-delete-circle-outline</v-icon>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </template>
                                            </v-simple-table>
                                        </v-card-text>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="12" md="3">
                            <v-row dense>
                                <v-col cols="12">
                                    <v-card
                                        color="white lighten-4"
                                        class="shadow1 theme_rounded px-2 py-2 pb-5"
                                    >
                                        <v-toolbar color="white lighten-4" :elevation="0" height="40px">
                                            <v-toolbar-title class="subtitle-2">Invoice Information</v-toolbar-title>
                                        </v-toolbar>
                                        <v-card-text class="py-1 pa-0 pl-2 pr-2">
                                            <!-- <v-row no-gutters>
                                                <v-col cols="4" class="py-1 caption">Invoice</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="sale.invoice"
                                                        readonly
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row> -->
                                            <v-row no-gutters>
                                                <v-col cols="4" class="py-1 caption">Date</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <!-- <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="sale.date"
                                                    ></v-text-field> -->
                                                    <v-menu
                                                        v-model="date_menu"
                                                        :close-on-content-click="false"
                                                        :nudge-right="0"
                                                        transition="scale-transition"
                                                    >
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-text-field
                                                                dense
                                                                outlined
                                                                hide-details
                                                                v-model="sale.date"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                                autocomplete="off"
                                                            >
                                                                <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                            </v-text-field>
                                                        </template>
                                                        <v-date-picker
                                                            v-model="sale.date"
                                                            @input="date_menu = false"
                                                        >
                                                        </v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4" class="py-1 caption">Sales Person</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-combobox 
                                                        dense
                                                        outlined
                                                        hide-details
                                                        @focus="$store.dispatch('employee/getEmployees')"
                                                        :items="$store.getters['employee/employees']"
                                                        :loading="$store.getters['employee/loadingEmployees']"
                                                        item-text="display_text"
                                                        item-value="id"
                                                        v-model="employee"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4" class="py-1 caption">PO No</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="sale.po_no"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4" class="py-1 caption">PO Date</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <!-- <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="sale.po_date"
                                                    ></v-text-field> -->
                                                    <v-menu
                                                        v-model="po_date_menu"
                                                        :close-on-content-click="false"
                                                        :nudge-right="0"
                                                        transition="scale-transition"
                                                    >
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-text-field
                                                                dense
                                                                outlined
                                                                hide-details
                                                                v-model="sale.po_date"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                                autocomplete="off"
                                                            >
                                                                <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                            </v-text-field>
                                                        </template>
                                                        <v-date-picker
                                                            v-model="sale.date"
                                                            @input="po_date_menu = false"
                                                        >
                                                        </v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4" class="py-1 caption">Sub Total</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        type="number"
                                                        min="0"
                                                        readonly
                                                        v-model="sale.sub_total"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4" class="py-1 caption">VAT</v-col>
                                                <v-col cols="3" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        type="number"
                                                        min="0"
                                                        v-model.number="vatPercent"
                                                        @input="calculateTotal"
                                                        class="mt-2"
                                                        label="Percentage"
                                                        id="vat"
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col cols="1" style="display: flex;align-items: center;justify-content: center;"><span class="ml-1">%</span></v-col>
                                                <v-col cols="4" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        type="number"
                                                        min="0"
                                                        class="mt-2"
                                                        label="Amount"
                                                        v-model.number="sale.vat"
                                                        @input="calculateTotal"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4" class="py-1 caption">Discount</v-col>
                                                <v-col cols="3" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        type="number"
                                                        min="0"
                                                        v-model.number="disPercent"
                                                        @input="calculateTotal"
                                                        class="mt-2"
                                                        label="Percentage"
                                                        id="discount"
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col cols="1" class="py-0" style="display: flex;justify-content: center;align-items: center;"><span class="ml-1">%</span></v-col>
                                                <v-col cols="4" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        type="number"
                                                        min="0"
                                                        class="mt-2"
                                                        label="Amount"
                                                        v-model.number="sale.discount"
                                                        @input="calculateTotal"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4" class="py-1 caption">Delivery charge</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        type="number"
                                                        min="0"
                                                        v-model.number="sale.transport"
                                                        @input="calculateTotal"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4" class="py-1 caption">Total</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        type="number"
                                                        min="0"
                                                        v-model.number="sale.total"
                                                        @input="calculateTotal"
                                                        readonly
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4" class="py-1 caption">Paid</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        type="number"
                                                        min="0"
                                                        v-model.number="sale.paid"
                                                        @input="calculateTotal"
                                                        :readonly="customer.type == 'G' ? true : false"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4" class="py-1 caption">Due</v-col>
                                                <v-col cols="4" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        readonly
                                                        v-model.number="sale.due"
                                                        @input="calculateTotal"
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col cols="4" class="pl-2">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        readonly
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mt-3">
                                                <v-col cols="4" class="py-1"></v-col>
                                                <v-col cols="4" class="py-1">
                                                    <v-btn type="submit" height="30px" dark block color="primary" :loading="loadingForSave">Save</v-btn>
                                                </v-col>
                                                <v-col cols="4" class="pl-2 py-1">
                                                    <v-btn type="reset" @click="resetForm" height="30px" dark block color="deep-orange">Clear</v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-card-text>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-form>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import swal from 'sweetalert'
import Upcomming from '../../components/upcomming.vue'
import {parseInt} from "lodash";
export default {
    name: 'Sale',
    components: {
        Upcomming
    },
    data: ()=> ({
        type: 'Retail',
        sale: {
            id: null,
            invoice: '',
            date: new Date().toISOString().substr(0, 10),
            customer_id: null,
            employee_id: null,
            po_no: '',
            po_date: new Date().toISOString().substr(0, 10),
            sub_total: 0,
            vat: 0,
            discount: 0,
            transport: 0,
            total: 0,
            paid: 0,
            due: 0,
        },
        vatPercent: 0.0,
        date_menu: false,
        po_date_menu: false,
        disPercent: 0.0,
        discountLimit: 0,
        customer: {
            id: null,
            name: '',
            phone: '',
            address: '',
            type: '',
            display_text: 'Select Customer'
        },
        employee: null,
        product: {
            id: '',
            code: '',
            display_text: 'Select product',
            name: '',
            sale_rate: '',
            quantity: '',
            total: '',
            unit: {}
        },
        cart: [],
        editCartIndex: null,
        modal: false,
        loadingForSave: false,
        stock: ''
    }),

    watch: {
        customer(customer) {
            if(customer == undefined) return;
            this.sale.customer_id = customer.id;
            this.customer = customer;
            this.calculateTotal()
        },
        async product(product) {
            if(product == undefined) return;
            this.product = product;
            this.product.sale_rate = product.sale_rate;
            if(product.id != '') {
                this.$refs.quantity.focus();
                await this.$store.dispatch('product/getCurrentStock', {productId: product.id})
                // this.stock = await this.$store.getters['product/stock'][0].current_quantity;
                let some = await this.$store.getters['product/stock'];
                if (some && some.current_stock > 0) {
                    this.stock = some.current_stock;
                } else { 
                    swal({
                        title: 'Product stock out',
                        icon: 'error',
                        buttons: true
                    }).then(()=> {
                        this.stock = 0;
                    });
                }
                // console.log(some);
            }
        },
        employee(employee) {
            if(employee == undefined) return;
            this.sale.employee_id = employee.id;
            this.discountLimit = employee.discount_limit;
        }
    },

    computed: {
        customers() {
            let customer = this.$store.getters['customer/customers'];
            customer.push({
                id: null,
                display_text: "General Customer",
                type: 'G',
                name: '',
                phone: '',
                address: ''
            })
            return customer;
        }, 
    },

    async created() {
        this.sale.invoice = await this.$store.dispatch('sale/generateSaleCode');

        if (this.$route.params.id != undefined) {
            await this.$store.dispatch('sale/getSales', {id: this.$route.params.id});
            await this.getSales();
        }
    },

    methods: {
        productTotal() {
            this.product.sale_rate = this.product.sale_rate == null || this.product.sale_rate == '' ? 0: this.product.sale_rate;
            this.product.quantity = this.product.quantity == null || this.product.quantity == '' ? 0: this.product.quantity;
            this.product.total = (+this.product.sale_rate * +this.product.quantity).toFixed(2);
        },

        addToCart() {
            if (!this.$refs.productForm.validate()) return;

            if(this.product.id == '' || this.product.id == null) {
                this.$store.dispatch('snackbar/error', 'Select a product');
                return;
            }
            if(this.product.sale_rate == 0 || this.product.sale_rate == '' || this.product.sale_rate == null) {
                this.$store.dispatch('snackbar/error', 'sale rate is required');
                return;
            }
            if(this.product.quantity == 0 || this.product.quantity == '' || this.product.quantity == null) {
                this.$store.dispatch('snackbar/error', 'sale quantity is required');
                return;
            }
            if(+this.product.quantity > +this.stock) {
                this.$store.dispatch('snackbar/error', 'Product stock is insufficient');
                return;
            }

            let product = {
                id: this.product.id,
                code: this.product.code,
                name: this.product.name,
                purchase_rate: this.product.purchase_rate,
                sale_rate: this.product.sale_rate,
                quantity: this.product.quantity,
                total: this.product.total,
                display_text: this.product.display_text
            }

            if(this.editCartIndex != null) {
                let editProduct = this.cart[this.editCartIndex];
                let checkIfExist = this.cart.findIndex(p => (p.id == product.id) && (p.id != editProduct.id));

                if (checkIfExist > -1) {
                    this.$store.dispatch("snackbar/error", "Product already existed in cart");
                    return;
                }

				this.cart[this.editCartIndex] = product;

            } else {
                let cartIndex = this.cart.findIndex(p => p.id == this.product.id)
                if(cartIndex > -1) {
                    this.$store.dispatch("snackbar/error", "Product already existed in cart");
                    return;
                }

                this.cart.push(product);
            }

            this.calculateTotal();
            this.clearProduct();
            this.$refs.product.focus();
        },

        editCart(index) {
            let cartProduct = this.cart[index];
            this.product = cartProduct;
            this.editCartIndex = index;
        },

        deleteCart(ind) {
            this.cart.splice(ind, 1);
            this.calculateTotal();
        },

        calculateTotal() {
            this.sale.sub_total = this.cart.reduce((p, c) => {return +p + +c.total}, 0).toFixed(2);

            if(event.target.id == "vat") {
                this.sale.vat = ((+this.sale.sub_total * +this.vatPercent) / 100).toFixed(2);
            } else {
                this.vatPercent = ((+this.sale.vat / +this.sale.sub_total) * 100).toFixed(2);
            }

            if(event.target.id == "discount") {
              this.sale.discount = ((+this.sale.sub_total * +this.disPercent) / 100).toFixed(2);
            } else {
                this.disPercent = ((+this.sale.discount / +this.sale.sub_total) * 100).toFixed(2);
            }

            // console.log(this.discountLimit, parseInt(this.sale.discount));

            // if(parseInt(this.sale.discount) > this.discountLimit) {
            //     this.limitIncreaseRequest();
            //     console.log('grater');
            // }

            this.sale.total = ((+this.sale.sub_total + +this.sale.vat + +this.sale.transport) - +this.sale.discount).toFixed(2);

            if(this.customer.type == 'G') {
                this.sale.paid = this.sale.total;
            } else {
                this.sale.due = (+this.sale.total - +this.sale.paid).toFixed(2);
            }
            
        },

        clearProduct() {
            this.product = {
                id: '',
                display_text: '',
                name: '',
                sale_rate: '',
                sale_rate: '',
                quantity: '',
                total: '',
                unit: {}
            }
            this.editCartIndex = null;
            this.stock = '';
            this.$refs.productForm.resetValidation()
        },

        validateSale() {
            let isValid = true;
            
            this.$refs.saleForm.validate();

            this.$refs.saleForm.inputs.forEach(input => {
                if(input.hasError) isValid = false;
            })

            if(!isValid) return;

            if(this.customer.type == '' && this.sale.customer_id == null) {
                this.$store.dispatch('snackbar/error', 'Select a customer');
                isValid = false; 
                return isValid;
            }

            if(this.cart.length == 0) {
                this.$store.dispatch('snackbar/error', 'Cart is empty');
                isValid = false; 
                return isValid;
            }

            if(this.sale.employee_id == null) {
                this.$store.dispatch('snackbar/error', 'Select an employee');
                isValid = false; 
                return isValid;
            }

            return isValid;
        },

        async saveSale() {
            if(!this.validateSale()) {
                return;
            }
     
            let data = {
                sale: this.sale,
                cart: this.cart,
                customer: this.customer.type == 'G' ? this.customer : null
            }
            this.loadingForSave = true;

            let res = await this.$store.dispatch('sale/saveSale', data);

            if(res) {
                this.resetForm();
                if(res.isSuccess) {
                    this.resetForm();
                    swal({
                        title: 'Sale success! Do you want to show invoice ?',
                        icon: 'success',
                        buttons: true
                    }).then(response => {
                        if (response) this.$router.push(`/sale-invoice/${res.id}`)
                    })
                }
            }

            this.loadingForSave = false
        },

        async resetForm() {
            this.cart = [];
            Object.keys(this.sale).map(k => this.sale[k] = '');
            this.$refs.saleForm.resetValidation();
            this.sale.id = null;
            this.customer = null;
            this.sale.date = new Date().toISOString().substr(0, 10);
            this.sale.po_date = new Date().toISOString().substr(0, 10);
            this.sale.invoice = await this.$store.dispatch('sale/generateSaleCode');
        },

        async getSales() {
            let sale = await this.$store.getters['sale/sales'][0]
            this.sale.id = sale.id;
            this.sale.invoice = sale.invoice;
            this.sale.date = sale.date;
            this.sale.customer_id = sale.customer_id;
            this.sale.po_no = sale.po_no;
            this.sale.po_date = sale.po_date;
            this.sale.po_date = sale.po_date;
            this.sale.sub_total = sale.sub_total;
            this.sale.vat = sale.vat;
            this.sale.discount = sale.discount;
            this.sale.transport = sale.transport;
            this.sale.total = sale.total;
            this.sale.paid = sale.paid;
            this.sale.due = sale.due;

            this.customer = sale?.customer;
            this.customer.display_text = `${sale?.customer.code} - ${sale?.customer.name == null ? '' : sale?.customer.name} - ${sale?.customer.phone == null ? '' : sale?.customer.phone}`;

            this.employee = sale?.employee;
            this.employee.display_text = `${sale?.employee.emp_id} - ${sale?.employee.name}`;

            sale?.sale_details.forEach(item => {
                this.cart.push({
                    id: item.product.id,
                    code: item.product.code,
                    name: item.product.name,
                    purchase_rate: item.purchase_rate,
                    sale_rate: item.sale_rate,
                    quantity: item.quantity,
                    total: item.total,
                    display_text: `${item.product.code} - ${item.product.name}`
                })
            });
        },

        async limitIncreaseRequest() {
          swal("Enter the coupon code to increase discount limit:", {
            content: "input",
          })
          .then((value) => {
            swal(`Coupon code: ${value}`);
          });
        }
    }

}
</script>

<style lang="scss" scoped>
    .product-name {
        font-size: 12px;
        line-height: 15px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    .v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > td {
        // height: 18px !important;
        border: 1px solid #ccc;
    }
    .theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {
        color: #000 !important;
        font-weight: 600 !important;
        border: 1px solid #ccc !important;
        text-align: center;
        // height: 25px !important;
        letter-spacing: 0.7px;
    }
    .caption {
        font-weight: 500 !important;
        color: #000 !important;
    }
    .container {
        padding: 2px 12px !important;
    }
    .stock {
        text-align: center;
        font-size: 30px;
        font-weight: bold;
        margin-top: 25px;
        span {
            font-size: 24px;
            font-weight: normal;
        }
    }
    .v-input--selection-controls {
        margin-top: 0px !important;
        // height: 34px !important;
    }
</style>
