<template>
    <v-container fluid>
        <v-form class="custom-form main_wrap" @submit.prevent="saveSaleReturn">
            <v-row justify="center" style="align-items: center;">
                <v-col cols="1">Invoice No</v-col>
                <v-col cols="2">
                    <v-combobox 
                        dense
                        outlined
                        hide-details
                        v-model="sale"
                        @focus="$store.dispatch('sale/getInvoices')"
                        :items="$store.getters['sale/invoices']"
                        :loading="$store.getters['sale/loadingSale']"
                        item-text="invoice"
                        item-value="id"
                    >
                    </v-combobox>
                </v-col>
            </v-row>

            <v-divider></v-divider>

            <v-row v-if="cart.length > 0">
                <v-col cols="9">
                    <v-simple-table dense>
                        <template v-slot:default>
                            <thead>
                                <th>SL</th>
                                <th>Product Name</th>
                                <th>Pur. Qty</th>
                                <th>Pur. Amount</th>
                                <th>Alr. Ret. Qty.</th>
                                <th>Alr. Ret. Amt.</th>
                                <th>Ret. Quantity</th>
                                <th>Ret. Rate</th>
                                <th>Ret. Amt.</th>
                            </thead>
                            <tbody>
                                <tr v-for="(item, sl) in cart" :key="sl">
                                    <td width="5%" style="text-align:center">{{ sl + 1 }}</td>
                                    <td>{{ item.name }}</td>
                                    <td width="10%" style="text-align:right">{{ item.quantity }}</td>
                                    <td width="10%" style="text-align:right">{{ item.total}}</td>
                                    <td width="10%" style="text-align:right">{{ item.returned_quantity }}</td>
                                    <td width="10%" style="text-align:right">{{ item.returned_amount }}</td>
                                    <td width="12%">
                                        <v-text-field
                                            dense
                                            outlined
                                            hide-details
                                            v-model.number="item.return_quantity"
                                            type="number"
                                            min="0"
                                            @input="productReturnTotal(sl)"
                                        ></v-text-field>
                                    </td>
                                    <td width="12%">
                                        <v-text-field
                                            dense
                                            outlined
                                            hide-details
                                            v-model.number="item.return_rate"
                                            type="number"
                                            min="0"
                                            @input="productReturnTotal(sl)"
                                        ></v-text-field>
                                    </td>
                                    <td width="10%" style="text-align:right">{{ item.return_amount }}</td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                </v-col>

                <v-col cols="3">
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-card 
                                :elevation="1"
                                color="white"
                            >
                                <v-toolbar color="white" :elevation="1" height="30px">
                                    <v-toolbar-title class="subtitle-2">Return Information</v-toolbar-title>
                                </v-toolbar>

                                <v-card-text class="py-1 pa-0 pl-2 pr-2">
                                    <v-row no-gutters>
                                        <v-col cols="3" class="py-1 caption">Date</v-col>
                                        <v-col cols="9" class="py-0">
                                            <v-menu>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        autocomplete="off"
                                                        v-model="saleReturn.date"
                                                    >
                                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="saleReturn.date"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>

                                    <v-row no-gutters>
                                        <v-col cols="3" class="py-1 caption">Note</v-col>
                                        <v-col cols="9">
                                            <v-textarea
                                                dense
                                                outlined
                                                hide-details
                                                min-height="12vh"
                                                v-model="saleReturn.note"
                                            ></v-textarea>
                                        </v-col>
                                    </v-row>

                                    <v-row no-gutters>
                                        <v-col cols="3" class="py-1 caption">Total</v-col>
                                        <v-col cols="9" class="py-1">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                type="number"
                                                min="0"
                                                readonly
                                                v-model="saleReturn.total"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                   
                                    <v-row no-gutters>
                                        <v-col cols="3" class="py-1"></v-col>
                                        <v-col cols="4" class="py-1">
                                            <v-btn type="submit" height="30px" dark block color="light-blue darken-2" :loading="loadingForSave">Save</v-btn>
                                        </v-col>
                                        <v-col cols="5" class="pl-2 py-1">
                                            <v-btn  height="30px" dark block color="deep-orange">Clear</v-btn>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
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
    name: 'SaleReturn',

    data: () => ({
        saleReturn: {
            id: null,
            invoice: '',
            date: new Date().toISOString().substr(0, 10),
            total: 0,
            note: ''
        },
        sale: null,
        saleId: null,
        cart: [],
        loadingForSave: false
    }),

    watch: {
        async sale(sale) {
            if(sale == undefined) return;
            this.saleId = sale.id;
            this.saleReturn.total = 0;
            this.saleReturn.invoice = sale.invoice;
            await this.viewInvoice();
        }
    },

    methods: {
        async viewInvoice(){
            await this.$store.dispatch('sale/getSaleReteurnForDetails', {saleId: this.saleId })
            this.cart = this.$store.getters['sale/returns'].sales;
            
            this.cart.map(item => {
                item.return_rate = item.purchase_rate
                return item;
            })
        },

        productReturnTotal(ind){
            if((+this.cart[ind].return_quantity + +this.cart[ind].returned_quantity) > +this.cart[ind].quantity){
                this.$store.dispatch('snackbar/error', 'Return quantity is not valid');
                this.cart[ind].return_quantity = '';
            }

            if(+this.cart[ind].return_rate > +this.cart[ind].purchase_rate){
                this.$store.dispatch('snackbar/error', 'Rate is not valid');
                this.cart[ind].return_rate = '';
            }

            this.cart[ind].return_amount = (+this.cart[ind].return_quantity * +this.cart[ind].return_rate);
            this.calculateTotal();
        },

        calculateTotal(){
            this.saleReturn.total = this.cart.reduce((p, c) => {return +p + (c.return_amount ? +c.return_amount : 0.00)}, 0);
        },

        async saveSaleReturn(){
            let filterCart = this.cart.filter(product => product.return_quantity > 0 && product.return_rate > 0);

            if(filterCart.length == 0){
                this.$store.dispatch('snackbar/error', 'No products to return');
                return;
            }

            if(this.saleReturn.date == null || this.saleReturn.date == ''){
                this.$store.dispatch('snackbar/error', 'Return date is required');
                return;
            }

            let data = {
                saleReturn: this.saleReturn,
                cart: filterCart
            }

            this.loadingForSave = true; 

            let success = await this.$store.dispatch('sale/saveSaleReturn', data);
            if(success) {
                this.resetForm();
            }

            this.loadingForSave = false;            
        },

        resetForm() {
            this.cart = [];
            Object.keys(this.saleReturn).forEach(key => {
                if(typeof(this.saleReturn[key]) == "string"){
                    this.saleReturn[key] = '';
                } else if(typeof(this.saleReturn[key]) == "number"){
                    this.saleReturn[key] = 0;
                }
            })


            this.saleReturn.id = null;
            this.saleReturn.date = new Date().toISOString().substr(0, 10);
            this.purchase = null;
        }
    }
}
</script>

<style scoped lang="scss">
.main_wrap {
    background: #fff;
}
    .v-icon.v-icon {
       font-size: 18px !important;
       top: 0px !important;
   }
   .v-data-table--dense > .v-data-table__wrapper > table > thead > th {
        font-size: 14px;
        // padding: 0px 1px;
        // background: #061e95;
        // color: #fff;
        border: 1px solid #eee !important;
        text-align: center;
        height: 35px !important;
   }
   .v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > td {
        // height: 20px !important;
        // padding: 0px 5px !important;
        font-size: 12px !important;
        border: 1px solid #eee !important;
   }
</style>
