<template>
    <v-container fluid>
        <v-form class="custom-form" @submit.prevent="saveDamage" ref="damageForm">
            <v-row dense>
                <v-col cols="8">
                    <v-row dense>
                        <v-col cols="8">
                            <v-card
                                class="white shadow1 rounded mb-5 pb-4"
                            >
                                <v-toolbar color="white" :elevation="0">
                                    <v-toolbar-title class="subtitle-1">Product Information</v-toolbar-title>
                                </v-toolbar>
                                <v-card-text class="py-1">
                                    <v-form ref="productForm" class="custom-form" @submit.prevent="addToCart">
                                        <v-row class="mb-2">
                                            <v-col cols="3" class="py-1">Product</v-col>
                                            <v-col cols="9" class="py-0">
                                                <v-combobox 
                                                    dense
                                                    outlined
                                                    hide-details
                                                    @focus="$store.dispatch('product/getProducts')"
                                                    :items="$store.getters['product/products']"
                                                    :loading="$store.getters['product/loadingProducts']"
                                                    item-text="display_text"
                                                    item-value="id"
                                                    v-model="product"
                                                    ref="product"
                                                >
                                                </v-combobox>
                                            </v-col>
                                        </v-row>
                                        <v-row class="mb-2">
                                            <v-col cols="3" class="py-1">Damage Rate</v-col>
                                            <v-col cols="4" class="py-0">
                                                <v-text-field
                                                    dense
                                                    outlined
                                                    hide-details
                                                    type="number"
                                                    min="0"
                                                    v-model.number="product.purchase_rate"
                                                    @input="productTotal"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="2" class="py-0 pa-0 d-flex" style="align-items: center;">Quantity</v-col>
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
                                        <v-row class="mb-2" style="align-items: center;">
                                            <v-col cols="3" class="py-1">Damage Total</v-col>
                                            <v-col cols="6" class="py-0">
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
                                            <v-col cols="3" class="py-0 pa-0 pr-3">
                                                <v-btn block type="submit" dark color="light-blue darken-2">Add</v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                </v-card-text>
                            </v-card>
                        </v-col>
                        <v-col cols="4">
                            <v-card 
                                class="white shadow1 rounded pb-3"
                                style="min-height: 200px;"
                            >
                                <v-toolbar :elevation="0" height="50px" style="border-bottom: 1px solid #ddd;">
                                    <v-toolbar-title class="subtitle-1 text-center">Product Stock</v-toolbar-title>
                                </v-toolbar>
                                <v-card-text class="py-1">
                                    <div class="stock">
                                        {{ stock }} 
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col cols="12">
                            <v-card :elevation="1" class="px-0">
                                <v-toolbar color="white" :elevation="0" height="50px">
                                    <v-toolbar-title class="subtitle-2">Cart Information</v-toolbar-title>
                                </v-toolbar>
                                <v-card-text class="py-1 pa-0 pl-1 pr-1">
                                    <v-simple-table>
                                        <template v-slot:default>
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Product Name</th>
                                                    <th>Damage Rate</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(cart, ind) in cart" :key="ind">
                                                    <td class="text-center" style="width:5%">{{ind+1}}</td>
                                                    <td>{{cart.name}}</td>
                                                    <td class="text-right" style="width:18%">{{cart.rate}}</td>
                                                    <td class="text-right" style="width:10%">{{cart.quantity}}</td>
                                                    <td class="text-right" style="width:10%">{{ cart.total}}</td>
                                                    <td class="text-center" style="width:7%">
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
                <v-col cols="4">
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-card 
                                :elevation="0"
                                class="white shadow1 rounded"
                            >
                                <v-toolbar color="white" :elevation="0" height="50px" style="border-bottom: 1px solid #ddd !important;">
                                    <v-toolbar-title class="subtitle-1">Invoice Information</v-toolbar-title>
                                </v-toolbar>

                                <v-card-text class="py-5 px-2">
                                    <v-row no-gutters>
                                        <v-col cols="3" class="py-1">Invoice</v-col>
                                        <v-col cols="9" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model="damage.invoice"
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row no-gutters>
                                        <v-col cols="3" class="py-1">Date</v-col>
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
                                                        v-model="damage.date"
                                                    >
                                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="damage.date"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>

                                    <v-row no-gutters>
                                        <v-col cols="3" class="py-1">Note</v-col>
                                        <v-col cols="9">
                                            <v-textarea
                                                dense
                                                outlined
                                                hide-details
                                                min-height="12vh"
                                                v-model="damage.note"
                                            ></v-textarea>
                                        </v-col>
                                    </v-row>

                                    <v-row no-gutters>
                                        <v-col cols="3" class="py-1">Total</v-col>
                                        <v-col cols="9" class="py-1">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                type="number"
                                                min="0"
                                                readonly
                                                v-model="damage.total"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                   
                                    <v-row no-gutters>
                                        <v-col cols="3" class="py-1"></v-col>
                                        <v-col cols="4" class="py-1">
                                            <v-btn type="submit" dark block color="light-blue darken-2" :loading="loading">Save</v-btn>
                                        </v-col>
                                        <v-col cols="5" class="pl-2 py-1">
                                            <v-btn dark block color="deep-orange">Clear</v-btn>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-form>
    </v-container>
</template>

<script>
import swal from 'sweetalert'

export default {
    name: 'Damage',

    data: () => ({
        damage: {
            invoice: '',
            date: new Date().toISOString().substr(0, 10),
            note: '',
            total: 0
        },
        product: {
            id: '',
            code: '',
            display_text: 'Select product',
            name: '',
            purchase_rate: '',
            quantity: '',
            total: '',
            unit: {}
        },
        cart: [],
        editCartIndex: null,
        modal: false,
        loading: false,
        stock: ''
    }),

    watch: {
        async product(product) {
            if(product == undefined) return;
            this.product = product;
            if(product.id != '') {
                this.$refs.quantity.focus();
            }

            await this.$store.dispatch('product/getCurrentStock', {productId: product.id})
            this.stock = await this.$store.getters['product/stock'][0].current_quantity
        }
    },

    async created() {
        this.damage.invoice = await this.$store.dispatch('damage/generateDamageCode');

        if (this.$route.params.id != undefined) {
            await this.$store.dispatch('damage/getDamages', {id: this.$route.params.id});
            await this.getDamage();
        }
    },

    methods: {
        productTotal() {
            this.product.purchase_rate = this.product.purchase_rate == null || this.product.purchase_rate == '' ? 0: this.product.purchase_rate;
            this.product.quantity = this.product.quantity == null || this.product.quantity == '' ? 0: this.product.quantity;
            this.product.total = (+this.product.purchase_rate * +this.product.quantity).toFixed(2);
        },

        addToCart() {
            if (!this.$refs.productForm.validate()) return;

            if(this.product.id == '' || this.product.id == null) {
                this.$store.dispatch('snackbar/error', 'Select a product');
                return;
            }
            if(this.product.purchase_rate == 0 || this.product.purchase_rate == '' || this.product.purchase_rate == null) {
                this.$store.dispatch('snackbar/error', 'damage rate is required');
                return;
            }
            if(this.product.quantity == 0 || this.product.quantity == '' || this.product.quantity == null) {
                this.$store.dispatch('snackbar/error', 'damage quantity is required');
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
                rate: this.product.purchase_rate,
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

                this.cart.unshift(product);
            }

            this.calculateTotal();
            this.clearProduct();
            this.$refs.product.focus();
        },

        editCart(index) {
            let cartProduct = this.cart[index];
            this.editCartIndex = index;
            this.product = cartProduct;
            this.product.purchase_rate = cartProduct.rate
        },

        deleteCart(ind) {
            this.cart.splice(ind, 1);
            this.calculateTotal();
        },

        calculateTotal() {
            this.damage.total = this.cart.reduce((p, c) => {return +p + +c.total}, 0).toFixed(2);
            console.log(this.damage.total)
        },

        clearProduct() {
            this.product = {
                id: '',
                display_text: '',
                name: '',
                purchase_rate: '',
                quantity: '',
                total: ''
            }
            this.editCartIndex = null;
            this.stock = '';
            this.$refs.productForm.resetValidation()
        },

        async saveDamage() {
            if(!this.validatedamage()) {
                return;
            }
     
            let data = {
                damage: this.damage,
                cart: this.cart
            }
            this.loadingForSave = true;

            let res = await this.$store.dispatch('damage/saveDamage', data);

            if(res) {
                if(res.isSuccess) {
                    this.resetForm();
                    swal({
                        title: 'Damage success! Do you want to show invoice ?',
                        icon: 'success',
                        buttons: true
                    }).then(response => {
                        if (response) this.$router.push(`/damage-invoice/${res.id}`)
                    })
                }
            }

            this.loadingForSave = false
        },

        validatedamage() {
            let isValid = true;
            
            this.$refs.damageForm.validate();

            this.$refs.damageForm.inputs.forEach(input => {
                if(input.hasError) isValid = false;
            })

            if(!isValid) return;

            if(this.cart.length == 0) {
                this.$store.dispatch('snackbar/error', 'Cart is empty');
                isValid = false; 
                return isValid;
            }

            return isValid;
        },

        async resetForm() {
            this.cart = [];
            Object.keys(this.damage).map(k => this.damage[k] = '');
            this.$refs.damageForm.resetValidation();
            this.damage.id = null;
            this.damage.date = new Date().toISOString().substr(0, 10);
            this.damage.invoice = await this.$store.dispatch('damage/generateDamageCode');
        },

        async getDamage() {
            let damage = await this.$store.getters['damage/damages'][0]
            this.damage.id = damage.id;
            this.damage.invoice = damage.invoice;
            this.damage.date = damage.date;
            this.damage.total = damage.total;
            
            damage?.damage_details.forEach(item => {
                this.cart.unshift({
                    id: item.product.id,
                    name: item.product.name,
                    rate: item.rate,
                    quantity: item.quantity,
                    total: item.total,
                    display_text: `${item.product.code} - ${item.product.name}`
                })
            });
        }
    }
}
</script>

<style lang="scss" scoped>
    .v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > td {
        // height: 18px !important;
        border: 1px solid #ccc;
    }
    .theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {
        color: #000 !important;
        font-weight: 600 !important;
        // border: 1px solid #ccc !important;
        // background: var(--theme_lighter);
        text-align: center;
        // height: 25px !important;
        letter-spacing: 0.7px;
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
</style>