<template>
    <v-container fluid class="white theme_rounded shadow1 py-2 mb-3">
        <v-form class="custom-form" @submit.prevent="savePurchaseReturn">
            <v-row dense justify="center" style="height: 60px;" class="flex_center">
                <v-col cols="1">Invoice No</v-col>
                <v-col cols="2">
                    <v-combobox 
                        dense
                        outlined
                        hide-details
                        v-model="purchase"
                        @focus="$store.dispatch('purchase/getInvoices')"
                        :items="$store.getters['purchase/invoices']"
                        :loading="$store.getters['purchase/loadingPurchase']"
                        item-text="invoice"
                        item-value="id"
                    >
                    </v-combobox>
                </v-col>
            </v-row>

            <v-divider></v-divider>

            <v-row v-if="cart.length > 0">
                <v-col cols="9">
                    <v-simple-table>
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
                                <v-toolbar color="white" :elevation="0">
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
                                                        v-model="purReturn.date"
                                                    >
                                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="purReturn.date"></v-date-picker>
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
                                                v-model="purReturn.note"
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
                                                v-model="purReturn.total"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                   
                                    <v-row no-gutters>
                                        <v-col cols="3" class="py-1"></v-col>
                                        <v-col cols="9" class="pl-2 py-1">
                                            <v-btn inline-block type="submit" color="primary" :loading="loadingForSave">Save</v-btn>
                                            <v-btn dark inline-block color="deep-orange" class="ml-3">Clear</v-btn>
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
    name: 'PurchaseReturn',

    data: () => ({
        purReturn: {
            id: null,
            invoice: '',
            date: new Date().toISOString().substr(0, 10),
            total: 0,
            note: ''
        },
        purchase: null,
        purchaseId: null,
        cart: [],
        loadingForSave: false
    }),

    watch: {
        async purchase(purchase) {
            if(purchase == undefined) return;
            this.purchaseId = purchase.id;
            this.purReturn.total = 0;
            this.purReturn.invoice = purchase.invoice;
            await this.viewInvoice();
        }
    },

    methods: {
        async viewInvoice(){
            await this.$store.dispatch('purchase/getPurchaseReteurnForDetails', {purchaseId: this.purchaseId })
            this.cart = this.$store.getters['purchase/returns'].purchases;
            
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
            this.purReturn.total = this.cart.reduce((p, c) => {return +p + (c.return_amount ? +c.return_amount : 0.00)}, 0);
        },

        async savePurchaseReturn(){
            let filterCart = this.cart.filter(product => product.return_quantity > 0 && product.return_rate > 0);

            if(filterCart.length == 0){
                this.$store.dispatch('snackbar/error', 'No products to return');
                return;
            }

            if(this.purReturn.date == null || this.purReturn.date == ''){
                this.$store.dispatch('snackbar/error', 'Return date is required');
                return;
            }

            let data = {
                purReturn: this.purReturn,
                cart: filterCart
            }

            this.loadingForSave = true; 

            let success = await this.$store.dispatch('purchase/savePurchaseReturn', data);
            if(success) {
                this.resetForm();
            }

            this.loadingForSave = false;            
        },

        resetForm() {
            this.cart = [];
            Object.keys(this.purReturn).forEach(key => {
                if(typeof(this.purReturn[key]) == "string"){
                    this.purReturn[key] = '';
                } else if(typeof(this.purReturn[key]) == "number"){
                    this.purReturn[key] = 0;
                }
            })


            this.purReturn.id = null;
            this.purReturn.date = new Date().toISOString().substr(0, 10);
            this.purchase = null;
        }
    }
}
</script>

<style scoped lang="scss">
    .v-icon.v-icon {
       font-size: 18px !important;
       top: 0px !important;
   }
   .v-data-table > .v-data-table__wrapper > table > thead > th {
        // font-size: 11px;
        // padding: 0px 1px;
        background: var(--theme_lighter);
        // background: #0b577c;
        // color: #fff;
        border-bottom: 1px solid #eee !important;
        // border: 1px solid #ccc !important;
        text-align: center;
        margin-bottom: 10px;
        // height: 28px !important;
   }
   .v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > td {
        // height: 20px !important;
        padding: 0px 5px !important;
        // font-size: 12px !important;
        border: 1px solid #ccc !important;
   }
</style>
