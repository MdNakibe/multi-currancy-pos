<template>
    <v-container fluid class="white py-3 px-2 shadow1 rounded">
        <v-row no-gutters>
            <v-col cols="12">
                <v-form class="custom-form" @submit.prevent="getProducts">
                    <v-row style="align-items: center;">
                        <v-col cols="auto" sm="2">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="3">Type</v-col>
                                <v-col cols="9">
                                    <v-combobox 
                                        v-model="searchType"
                                        dense
                                        outlined
                                        hide-details
                                        :items="['All', 'By Category', 'By Brand']"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="auto" sm="3"  v-if="searchType == 'By Category'">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Cateogry</v-col>
                                <v-col cols="8">
                                    <v-combobox 
                                        dense
                                        outlined
                                        hide-details
                                        v-model="category"
                                        @focus="$store.dispatch('category/getCategories')"
                                        :items="$store.getters['category/categories']"
                                        :loading="$store.getters['category/loadingCategories']"
                                        item-text="name"
                                        item-value="id"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="auto" sm="3"  v-if="searchType == 'By Brand'">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Brand</v-col>
                                <v-col cols="8">
                                    <v-combobox 
                                        dense
                                        outlined
                                        hide-details
                                        v-model="brand"
                                        @focus="$store.dispatch('brand/getBrands')"
                                        :items="$store.getters['brand/brands']"
                                        :loading="$store.getters['category/loadingBrands']"
                                        item-text="name"
                                        item-value="id"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="auto" sm="1">
                            <v-btn type="submit" class="text_bg_fave" :loading="loading">Search</v-btn>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                </v-form>
            </v-col>
        </v-row>

        <v-row no-gutters class="py-2" v-if="show">
            <v-col cols="12">
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Product Id</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Purchase Rate</th>
                                <th>Sale Rate</th>
                                <th>Wholesale Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in $store.getters['product/products']" :key="product.sl">
                                <td class="text-center">{{ product.sl}}</td>
                                <td class="text-center">{{ product.code }}</td>
                                <td class="text-center">{{ product.name }}</td>
                                <td class="text-center">{{ product.category.name }}</td>
                                <td class="text-center">{{ product.brand.name }}</td>
                                <td class="text-center">{{ product.purchase_rate }}</td>
                                <td class="text-center">{{ product.sale_rate }}</td>
                                <td class="text-center">{{ product.wholesale_rate }}</td>
                            </tr>
                            <tr v-if="$store.getters['product/products'].length == 0">
                                <td colspan="9" class="text-center">Poduct information is not available</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-col>
        </v-row>
        <div v-else class="no_result">
            <div class="img"></div>
        </div>
    </v-container>
</template>

<script>
export default {
    name: 'Products',

    data: () => ({
        searchType: 'All',
        category: null,
        brand: null,
        loading: false,
        show: false
    }),

    methods: {
        async getProducts() {
            this.loading = true;

            if(this.searchType == 'All') {
                this.category = null;
                this.brand = null;
            }
            if(this.searchType != 'By Category') {
                this.category = null;
            }
            if(this.searchType != 'By Brand') {
                this.brand = null;
            }

            let filter = {
                categoryId: this.category == null ? null : this.category.id,
                brandId: this.brand == null ? null : this.brand.id
            }

            await this.$store.dispatch('product/getProducts', filter)
            this.show = true;
            this.loading = false;
        }
    }
}
</script>

<style lang="scss" scoped>
    .v-icon.v-icon {
       font-size: 18px !important;
       top: -3px !important;
   }
   .theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {
        font-size: 11px;
        // padding: 0px 1px;
        background: var(--theme_lighter);
        // color: #fff;
        // border: 1px solid #ccc;
        text-align: center;
        // height: 24px !important;
   }
   .v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > td {
        // height: 20px !important;
        // padding: 0px 5px !important;
        // font-size: 12px !important;
        border: 1px solid #ccc !important;
   }
</style>