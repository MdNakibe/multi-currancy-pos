<template>
    <v-container fluid class="white shadow1 rounded">
        <v-row no-gutters justify="center">
            <v-col cols="8">
                <v-form class="custom-form pb-5" @submit.prevent="barcodeGenerate">
                    <v-row>
                        <v-col cols="4">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Product Id</v-col>
                                <v-col cols="8">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        v-model="product.code"
                                        :rules="[v => !!v]"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="4">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Pro. Name</v-col>
                                <v-col cols="8">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        v-model="product.name"
                                        :rules="[v => !!v]"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="4">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Pro. Price</v-col>
                                <v-col cols="8">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        v-model="product.sale_rate"
                                        :rules="[v => !!v]"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                    <v-row dense>
                        <v-col cols="4">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Quantity</v-col>
                                <v-col cols="8">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        v-model="product.quantity"
                                        :rules="[v => !!v]"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="4">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Article</v-col>
                                <v-col cols="8">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        v-model="product.article"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="4">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="3">
                                    <v-btn type="submit" :loading="loading" dark block color="light-blue darken-2">Generate</v-btn>
                                </v-col>
                                <v-col cols="2"></v-col>
                                <v-col cols="7" class="pl-3">
                                    <v-btn @click.prevent="print">Print</v-btn>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                </v-form>
            </v-col>
        </v-row>
        <v-row no-gutters class="py-2">
            <v-col cols="12" id="printContent">
                <div class="bacode-area" v-for="(product, sl) in cart" :key="sl">
                    <span class="body-2">{{ product.article }}</span>
                    <p class="caption text-truncate">{{ product.name }}</p>
                    <vue-barcode 
                        :value="product.code" 
                        :options="{ displayValue: false, height:50}"
                        tag="img"
                    >
                    </vue-barcode>
                    <h5>{{ product.code }}</h5>
                    <p class="subtitle-2">BDT {{ product.sale_rate }}</p>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import VueBarcode from '@chenfengyuan/vue-barcode';
export default {
    name: 'ProductBarcode',

    components: {
        'vue-barcode': VueBarcode
    },

    data: () => ({
        product: {
            code: '',
            name: '',
            sale_rate: 0,
            quantity: 0,
            article: ''
        },
        loading: false,
        cart: []
    }),

    async created() {
        await this.$store.dispatch('product/getProducts', {id: this.$route.params.id})
        this.product = await this.$store.getters['product/products'][0]
        this.setStyle();    
    },

    methods: {
        barcodeGenerate() {
            this.cart = [];
            this.loading = true;

            for(let j = 0; j < this.product.quantity; j++) {
                let product = {
                    code: this.product.code,
                    name: this.product.name,
                    sale_rate: this.product.sale_rate,
                    article: this.product.article
                }
                this.cart.push(product)
            }
            this.loading = false;

            this.product.quantity = '';
            this.product.article = '';
        },

        async print(){
            let printContent = document.querySelector('#printContent').innerHTML;
            let printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}, left=0, top=0`);
            printWindow.document.write(`
                <!DOCTYPE html>
                <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                        <title>Product Barcode Print</title>
                        <style>
                        </style>
                    </head>
                    <body>
                        <div>
                            <div class="container">
                                <table style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="custom-row">
                                                    <div class="col-xs-12">
                                                        ${printContent}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
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
                .bacode-area {
                    width: 175px;
                    border: 1px solid #ccc;
                    padding: 3px;
                    margin: 0;
                    text-align: center;
                    float: left;
                    margin-right: 2px;
                    margin-bottom: 2px;
                }
                img {
                    width: 120px;
                    height: 50px;
                }
                h5 {
                    margin-top: -5px;
                }
                p {
                    padding: 0px 5px;
                    margin: 0px;
                }
               
                @media print {
                    .subtitle-2 {
                        margin-top: -20px !important;
                    }
                }
            `;
            document.head.appendChild(this.style);
        },
    }
}
</script>

<style lang="scss" scoped>
    .bacode-area {
        width: 175px;
        border: 1px solid #ccc;
        padding: 3px;
        margin: 0;
        text-align: center;
        float: left;
        margin-right: 2px;
        margin-bottom: 2px;
    }
    img {
        width: 120px;
        height: 50px;
    }
    h5 {
        margin-top: -12px;
    }
    p {
        padding: 0px 5px;
        margin: 0px;
    }
</style>