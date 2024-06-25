<template>
    <v-container fluid class="white shadow1 rounded">
        <v-row>
            <v-col cols="12">
                <v-form class="custom-form" @submit.prevent="getProducts">
                    <v-row dense>
                        <v-col cols="3">
                            <v-row no-gutters style="color: #000;align-items: center;">
                                <v-col cols="4">Category</v-col>
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
                        <v-col cols="2">
                            <v-row no-gutters style="color: #000;align-items: center;">
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
                        <v-col cols="1" style="color: #000;display: flex;align-items: center;">Sale Price</v-col>
                        <v-col cols="4">
                            <v-row no-gutters>
                                <v-col cols="12">
                                    <v-range-slider
                                        v-model="rangeSlider.priceRange"
                                        :max="rangeSlider.max"
                                        :min="rangeSlider.min"
                                        hide-details
                                        class="align-center"
                                        @change="filterByPrice"
                                    >
                                        <template v-slot:prepend>
                                        <v-text-field
                                            :value="rangeSlider.priceRange[0]"
                                            class="mt-0 pt-0"
                                            hide-details
                                            single-line
                                            style="width: 60px"
                                            @change="$set(rangeSlider, 0, $event)"
                                        ></v-text-field>
                                        </template>
                                        <template v-slot:append>
                                        <v-text-field
                                            :value="rangeSlider.priceRange[1]"
                                            class="mt-0 pt-0"
                                            hide-details
                                            single-line
                                            style="width: 60px"
                                            @change="$set(rangeSlider, 1, $event)"
                                        ></v-text-field>
                                        </template>
                                    </v-range-slider>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="1">
                            <v-btn type="submit" dark color="text_bg_fave" :loading="loading">Search</v-btn>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                </v-form>
            </v-col>
        </v-row>

        <v-row no-gutters class="py-2">
            <v-col cols="12">
                <v-data-table
                    class="custom-data-table elevation-0" 
                    :headers="productHeaders"
                    :items="$store.getters['product/products']"
                    :search="searchProduct"
                    :loading="$store.getters['product/loadingProducts']" 
					loading-text="Loading... Please wait"
                >
                    <template v-slot:top>
                        <v-toolbar color="white" :elevation="0" class="px-2">
                            <v-toolbar-title class="subtitle-2">Product List</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search Product"
                                    append-icon="mdi-magnify"
                                    style="width:300px;"
                                    v-model="searchProduct"
                                >
                                </v-text-field>
                            </v-form>
                        </v-toolbar>
                    </template>

                    <template v-slot:[`item.image`]="{ item }">
                        <v-img
                            :width="50"
                            :height="50"
                            cover
                            :src="`${$store.state.hostName}${item.image}`"
                        />
					</template>

                    <template v-slot:[`item.action`]="{ item }">
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="$router.push(`/barcode-generate/${item.id}`)" color="primary" v-on="on">mdi-barcode</v-icon>
							</template>
							<span>Barcode</span>
						</v-tooltip>
					</template>
                </v-data-table>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'ProductList',

    data: () => ({
        productHeaders: [
            { text: 'SL', value: 'sl' },
            { text: 'Product Id', value: 'code' },
            { text: 'Image', value: 'image' },
            { text: 'Product Name', value: 'name' },
            { text: 'Category', value: 'category.name' },
            { text: 'Brand', value: 'brand.name' },
            { text: 'Unit', value: 'unit.name' },
            { text: 'Purchase Rate', value: 'purchase_rate' },
            { text: 'Sale Rate', value: 'sale_rate' },
            { text: 'Action', value: 'action' },
        ],
        searchProduct: '',
        category: null,
        brand: null,
        loading: false,
        rangeSlider: {
            min: 0,
            max: 100000,
            priceRange: [100, 100000],
        },
    }),

    created() {

    },

    methods: {
        async getProducts() {
            this.loading = true;
            let filter = {
                categoryId: this.category == null ? null : this.category.id,
                brandId: this.brand == null ? null : this.brand.id
            }

            await this.$store.dispatch('product/getProducts', filter)

            this.loading = false;
        },

        async filterByPrice() {
            this.loadingProducts = true;
            await this.$store.dispatch('product/getProducts', {price: this.rangeSlider.priceRange});
            this.loadingProducts = false;
        },

    }
}
</script>

<style lang="scss">
    .v-treeview-node__root {
        // min-height: 35px !important;
        padding-left: 0px !important;
        position: relative;
    }
</style>
