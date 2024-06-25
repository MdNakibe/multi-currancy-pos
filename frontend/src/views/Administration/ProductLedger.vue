<template>
    <v-container fluid class="white shadow1 rounded">
        <v-form class="custom-form" @submit.prevent="getProductLedger">
            <v-row dense justify="center" class="pb-4">
                <v-col cols="auto" md="4">
                    <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                        <v-col cols="3">Product</v-col>
                        <v-col cols="9">
                            <v-combobox 
                                dense
                                outlined
                                hide-details
                                v-model="product"
                                @focus="$store.dispatch('product/getProducts')"
                                :items="$store.getters['product/products']"
                                :loading="$store.getters['product/loadingProducts']"
                                item-text="display_text"
                                item-value="id"
                            >
                            </v-combobox>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="auto" md="5">
                    <v-row no-gutters>
                        <v-col cols="6">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Date From</v-col>
                                <v-col cols="8">
                                    <v-menu>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model="filter.dateFrom"
                                                v-bind="attrs"
                                                v-on="on"
                                            >
                                            <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                            </v-text-field>
                                        </template>
                                        <v-date-picker v-model="filter.dateFrom"></v-date-picker>
                                    </v-menu>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="6">
                            <v-row class="pl-3" no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Date To</v-col>
                                <v-col cols="8">
                                    <v-menu>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model="filter.dateTo"
                                                v-bind="attrs"
                                                v-on="on"
                                            >
                                            <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                            </v-text-field>
                                        </template>
                                        <v-date-picker v-model="filter.dateTo"></v-date-picker>
                                    </v-menu>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="auto" md="1" class="d-flex align-center">
                    <v-btn type="submit" class="text_bg_fave" :loading="loading">Search</v-btn>
                </v-col>
            </v-row>
            <v-divider></v-divider>

            <v-row v-if="show">
                <v-col cols="12" id="printContent" class="d_table">
                    <v-simple-table>
                        <template v-slot:default>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Rate</th>
                                    <th>Stock In</th>
                                    <th>Stock Out</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td><strong>Opening Stock</strong></td>
                                    <td colspan="3"></td>
                                    <td class="text-right"><strong>{{ $store.getters['product/openingStock'] }}</strong></td>
                                </tr>

                                <tr v-for="(product, ind) in $store.getters['product/ledgers']" :key="ind">
                                    <td class="text-center">{{ product.date }}</td>
                                    <td>{{ product.description }}</td>
                                    <td class="text-right">{{ product.rate }}</td>
                                    <td class="text-right">{{ product.in_quantity }}</td>
                                    <td class="text-right">{{ product.out_quantity }}</td>
                                    <td class="text-right">{{ product.stock }}</td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
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
    name: 'ProductLedger',

    data: () => ({
        filter: {
            dateFrom: new Date().toISOString().substr(0, 10),
            dateTo: new Date().toISOString().substr(0, 10),
            productId: null
        },
        product: null,
        loading: false,
        show: false,
    }),

    watch: {
        product(product) {
            if(product == undefined) return;
            this.filter.productId = product.id;
        }
    },

    methods: {
        async getProductLedger() {
            if(this.product == null) {
                this.$store.dispatch('snackbar/error', 'Select a product');
                return;
            }

            this.loading = true;

            await this.$store.dispatch('product/getProductLedger', this.filter)

            this.show = true;
            this.loading = false;
        }
    }
}
</script>

<style lang="scss" scoped>
    .v-icon.v-icon {
       font-size: 18px !important;
       top: 3px !important;
    }
   .d_table > thead > tr:last-child > th {
        font-size: 11px;
        padding: 0px 1px;
        border: 1px solid #ddd !important;
        text-align: center;
   }
   .theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {
    border: 1px solid #ddd;
   }
   .d_table table > tbody > tr > td {
        // height: 20px !important;
        padding: 0px 5px !important;
        font-size: 12px !important;
        border: 1px solid #ddd !important;
   }
</style>