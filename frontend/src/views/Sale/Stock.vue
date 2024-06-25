<template>
    <v-container fluid>
        
        <v-row no-gutters v-if="$store.getters['product/stock'].length">
            <v-col cols="12">
                <v-btn height="26px" @click.prevent="print" class="mb-2">Print</v-btn>
            </v-col>
        </v-row>
        <div id="printContent">
            <v-row no-gutters v-if="$store.getters['product/stock'].length">
                <v-col cols="12">
                    <v-simple-table class="bordered-table">
                        <template v-slot:default>
                            <thead>
                                <tr>
                                    <!-- <th>Sl</th>
                                    <th>Product Id</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Purchase Rate</th>
                                    <th>Pur. Quantity</th>
                                    <th>Pur. Return</th>
                                    <th>Sale Quantity</th>
                                    <th>Sale Return</th>
                                    <th>Damage Quantity</th>
                                    <th>Current Quantity</th>
                                    <th>Stock Value</th> -->
                                    <th>SL</th>
                                    <th>Product ID</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Unit</th>
                                    <th>Purchase</th>
                                    <th>Purchase Return</th>
                                    <th>Sale</th>
                                    <th>Sale Return</th>
                                    <th>Damage</th>
                                    <th>Closing Stock</th>
                                    <th>Stock Value (USD)</th>
                                    <th>Stock Value (SRD)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, sl) in $store.getters['product/stock']" :key="sl">
                                    <td class="text-center">{{ sl + 1 }}</td>
                                    <td class="text-center">{{ product.product_data.code }}</td>
                                    <td class="text-center">
                                        <img :src="`${$store.state.hostName}/${product.image}`" alt="">
                                    </td>
                                    <td class="text-center">{{ product.product_data.name }}</td>
                                    <td class="text-center">{{ product.product_data.category.name }}</td>
                                    <td class="text-center">{{ product.product_data.brand.name }}</td>
                                    <td class="text-center">{{ product.product_data.unit.name }}</td>
                                    <td class="text-center">{{ product.purchase_quantity }}</td>
                                    <td class="text-center">{{ product.purchase_return }}</td>
                                    <td class="text-center">{{ product.sale_quantity }}</td>
                                    <td class="text-center">{{ product.sale_return }}</td>
                                    <td class="text-center">{{ product.damage_quantity }}</td>
                                    <td class="text-center">{{ product.current_stock }}</td>
                                    <td class="text-right">{{ Number(product.product_data.purchase_detail[0].avarage_usd * product.current_stock).toFixed(2) }}</td>
                                    <td class="text-right"></td>
                                </tr>

                                <!-- <tr>
                                    <td colspan="11" class="text-right"><strong>Total</strong></td>
                                    <td class="text-center"><strong>{{totalQuantity }}</strong></td>
                                    <td class="text-right"><strong>{{ totalStockValue }}</strong></td>
                                </tr> -->
                            </tbody>
                        </template>
                    </v-simple-table>
                </v-col>
            </v-row>
            <div class="white shadow1 rounded" v-else>
                <div class="no_result">
                    <div class="img"></div>
                </div>
            </div>
        </div>
    </v-container>
</template>

<script>
import { handlePrint } from '../../composable/usePrint'

export default {
    name: 'Stock',

    data: () => ({
        searchType: '',
        category: null,
        brand: null,
        product: null,
        loading: false
    }),
    created(){
         this.getStock();
        this.companyProfile = this.$store.getters['companyProfile/company']
        this.usd_rate = Number(this.companyProfile.dolor_rate) || 1;
    },
    computed: {
        totalQuantity() {
        return this.$store.getters['product/stock'].reduce((p, c) => { return +p + +c.current_quantity}, 0)
        },
        totalStockValue() {
            return this.$store.getters['product/stock'].reduce((p, c) => { return +p + +c.stock_value}, 0)
        },
    },

    methods: {

        async getStock() {
            await this.$store.dispatch('product/getTotalStock');
            this.$store.dispatch('companyProfile/getCompanyProfile');
        },

        async print(){
            let printContent = document.querySelector('#printContent').innerHTML;
            handlePrint({
                title: 'Product stock',
                content: printContent,
            })
        },
    }
}
</script>

<style lang="scss" scoped>
   .v-icon.v-icon {
       font-size: 18px !important;
       top: -3px !important;
   }
   .theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {
        // font-size: 11px;
        padding: 0px 1px;
        background: var(--theme_lighter);
        color: var(--theme_deep_dark);
        // border: 1px solid #ccc;
        text-align: center;
        height: 40px !important;
   }
   .v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > td {
        height: 40px !important;
        // padding: 0px 5px !important;
        // font-size: 12px !important;
        // border: 1px solid #ccc !important;
   }
</style>